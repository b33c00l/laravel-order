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
        if (!empty($order))
        {
            $order_products = $order->orderProducts()->get();
            $order_id = $order->id;
        }else{
                $order_products = [];
                $order_id = [];
        }
        return view('orders.single_basket', ['products' => $order_products, 'order_id' => $order_id, 'order' =>$order]);
    }
    public function store($product_id, StoreOrderRequest $request)
    {
        $user = Auth::user();
        $user_order = $user->orders()->asCart()->first();
        if (empty($user_order))
        {
            $order = $user->orders()->create([
                'status' => Order::PENDING,
                'date' => Carbon::now(),
            ]);
        }else{
            $order = $user_order;
        }
        $product = $order->orderProducts->where('product_id', $product_id)->first();
        if ($product == null)
        {
            $order->orderProducts()->create($request->except('_token')+[
                    'product_id' => $product_id,
                ]);
        }else{
            $amount = $product->quantity + $request->quantity;
            $product->update(['quantity' => $amount]);
        }

        return $product_id;
    }

    public function update($id, StoreOrderRequest $request)
    {
        $user = Auth::user();
        $product = OrderProduct::where('id', $id);
        $singleProduct = $product->first();
            if ($user->role === 'admin' && !empty($request->price))
            {
                $singleProduct = $product->update([
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
