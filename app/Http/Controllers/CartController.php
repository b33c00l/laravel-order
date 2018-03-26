<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Order;
use App\OrderProduct;
use App\Product;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CartService;


class CartController extends Controller
{
    private $getTotal;

    public function __construct(CartService $cartService)
    {
        $this->getTotal = $cartService;
    }
    public function index()
    {
        $user = Auth::user();
        $order = $user->orders()->InCart()->Order()->first();
        $backorder =$user->orders()->InCart()->BackOrder()->first();
        $preorder =$user->orders()->InCart()->PreOrder()->first();
        if (!empty($order))
        {
            $order_products = $order->orderProducts()->get();
        }else{
                $order_products = [];
                $order = null;
        }
        if (!empty($backorder))
        {
            $backorders = $backorder->orderProducts()->get();

        }else{
            $backorders =[];
            $backorder = null;
        }
        if (!empty($preorder))
        {
            $preorders = $preorder->orderProducts()->get();
        }else{
            $preorders =[];
            $preorder = null;
        }

        return view('orders.single_basket', [
            'products' => $order_products,
            'order' =>$order,
            'backorder' => $backorder,
            'preorder' => $preorder,
            'backorders' => $backorders,
            'preorders' => $preorders,
        ]);
    }
    public function store($product_id, StoreOrderRequest $request)
    {
        $product = Product::findOrfail($product_id);

        if ($product->stock()->first()->amount !== 0 && $product->preorder !== 1)
        {
            $amount = $this->getTotal->storeOrder($product, $request);
            if ($amount !== 0 )
            {
                $this->getTotal->storeBackOrder($product, $amount);
            }
        }elseif($product->stock()->first()->amount === 0 && $product->preorder == 0){
            $this->getTotal->storeBackOrder($product, $request->quantity);
        } elseif($product->preorder === 1) {
            $this->getTotal->storePreOrder($product, $request->quantity);
        }
        $data = [
        	'product_id'=>$product_id,
	        'totalQuantity' => $this->getTotal->getUserOrderTotalQuantity(),
	        'totalPrice' => $this->getTotal->getUserOrderTotalPrice(),
        ];

        return $data;
    }

    public function update($id, StoreOrderRequest $request)
    {
        $user = Auth::user();
        $product = OrderProduct::where('id', $id);
            if ($user->role === 'admin' && !empty($request->price))
            {
                $product->update([
                    'price' => $request->price,
                    ]);
                $product = OrderProduct::where('id', $id);
                $singleProduct = $product->first();
                $data = ['id' => $id,
                    'singleProductPrice' => $this->getTotal->getSingleProductPrice($singleProduct),
                    'totalPrice' => $this->getTotal->getTotalCartPrice($singleProduct->order),
                ];
            }elseif($request->from == 'order'){
                if ($product->first()->product->stock->first()->amount >=  $request->quantity)
                {
                    $data = $this->getTotal->updateOrder ($request->quantity, $product);
                }else{
                    $product->update(['quantity' => $product->first()->product->stock->first()->amount]);
                    $data = ['id' => $id,
                        'singleQuantity' => $product->first()->product->stock->first()->amount,
                        'true' => true,
                        'singlePrice' => $this->getTotal->getSingleProductPrice($product->first()),
                    ];
                }
            }else{
                $data = $this->getTotal->updateOrder ($request->quantity, $product);
            }
        return $data;
    }

    public function destroy($id)
    {
        $order_product = OrderProduct::findOrFail($id);
        $order_product->delete();
        $order_products = OrderProduct::where('order_id', $order_product->order_id)->get();
        if (count($order_products) == 0){
            Order::findOrFail($order_product->order_id)->delete();
        }
        return redirect()->back();
    }

    public function destroySelected(Request $request)
    {
        if ($request->has('checkbox')){
            foreach ($request->checkbox as $orderProduct) {
                OrderProduct::findOrFail($orderProduct)->delete();
            }
            if ($request->has('order_id')){
                $order = Order::findOrFail($request->order_id);
                if (count($order->orderProducts) == 0) {
                    $order->delete();
                }
            }
            if ($request->has('backorder_id')){
                $backorder = Order::findOrFail($request->backorder_id);
                if (count($backorder->orderProducts) == 0) {
                    $backorder->delete();
                }
            }

            if ($request->has('preorder_id')){
                $preorder = Order::findOrFail($request->preorder_id);
                if (count($preorder->orderProducts) == 0) {
                    $preorder->delete();
                }
            }
        }

    return redirect()->back();
    }

    public function confirm(Request $request)
    {
        if ($request->has('order_id')) {
            $order = Order::findOrFail($request->order_id);
            $order->update(['status' => Order::UNCONFIRMED]);
            foreach ($order->orderProducts as $product) {
                $stock = Stock::findOrFail($product->product_id);
                $quantity = $stock->amount - $product->quantity;
                if ($quantity >= 0) {
                    Stock::create(['amount' => $quantity, 'product_id' => $product->product_id]);
                } else {
                    Stock::create(['amount' => 0, 'product_id' => $product->product_id]);
                }
            }
        }
        if ($request->has('backorder_id')) {
            Order::findOrFail($request->backorder_id)->update(['status' => Order::UNCONFIRMED]);
        }
        if ($request->has('preorder_id')) {
            Order::findOrFail($request->preorder_id)->update(['status' => Order::UNCONFIRMED]);
        }
    return redirect()->back();
    }
}
