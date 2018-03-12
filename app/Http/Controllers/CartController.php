<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Order;
use App\OrderProduct;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
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
        return view('orders.single_basket', ['products' => $order_products, 'order_id' => $order_id]);
    }
    public function store($product_id, StoreOrderRequest $request)
    {
        $user = Auth::user();
        $user_order = $user->orders()->asCart()->first();
        if (empty($user_order))
        {
            $order = $user->orders()->create([
                'status' => 0,
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
        OrderProduct::where('id', $id)->update($request->except('_token'));
        return $id;
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
        Order::findOrFail($id)->update(['status' => 1]);
        return redirect()->back();
    }
}
