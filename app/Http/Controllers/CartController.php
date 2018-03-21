<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Order;
use App\OrderProduct;
use App\Price;
use App\Product;
use Carbon\Carbon;
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
        $order = $user->orders()->asCart()->first();
        $backorder =$user->orders()->asCartBackOrder()->first();
        $preorder =$user->orders()->asCartPreOrder()->first();
        if (!empty($order))
        {
            $order_products = $order->orderProducts()->get();
            $order_id = $order->id;
        }else{
                $order_products = [];
                $order_id = [];
        }
        if (!empty($backorder))
        {
            $backorders = $backorder->orderProducts()->get();
        }else{
            $backorders =[];
        }
        if (!empty($preorder))
        {
            $preorders = $preorder->orderProducts()->get();
        }else{
            $preorders =[];
        }

        return view('orders.single_basket', [
            'products' => $order_products,
            'order_id' => $order_id,
            'order' =>$order,
            'backorders' => $backorders,
            'preorders' => $preorders
        ]);
    }
    public function store($product_id, StoreOrderRequest $request)
    {
        $product = Product::findOrfail($product_id);

        if ($product->stock()->first()->amount !== 0 && $product->preorder !== Order::PREORDER)
        {
            $amount = $this->getTotal->getStoreOrder($product, $request);
            if ($amount !== 0 )
            {
                $this->getTotal->getStoreBackOrder($product, $amount);
            }
        }elseif($product->stock()->first()->amount === 0 && $product->preorder === Order::ORDER){
            $this->getTotal->getStoreBackOrder($product, $request->quantity);
        } elseif($product->preorder === Order::PREORDER) {
            $this->getTotal->getStorePreOrder($product, $request->quantity);
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
            }else{
                $product->update($request->except('_token'));
                $singleProduct = $product->first();
                $data = ['id' => $id,
                    'totalQuantity' => $this->getTotal->getTotalCartQuantity($singleProduct->order),
                    'singleProductPrice' => $this->getTotal->getSingleProductPrice($singleProduct),
                    'totalPrice' => $this->getTotal->getTotalCartPrice($singleProduct->order),
                ];
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
    public function confirm($id)
    {
        Order::findOrFail($id)->update(['status' => Order::UNCONFIRMED]);
        return redirect()->back();
    }
}
