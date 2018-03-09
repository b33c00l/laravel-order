<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Order;
use App\OrderProduct;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $order = $user->orders()->where('status', 0)->get()->first();
        if (!empty($order))
        {
            $order_products = $order->orderProducts()->get();
        }else{
            $order_products = '';
        }
        return view('orders.single_basket', ['products' => $order_products]);
    }
    public function store($product_id, StoreOrderRequest $request)
    {
        $user = Auth::user();
        $user_order = $user->orders()->get()->first();
        if ($user_order == null)
        {
            $order = $user->orders()->create([
                'status' => 0,
                'date' => Carbon::now(),
            ]);
        }else{
            $order = $user_order;
        }
        $product = OrderProduct::where('product_id', $product_id)->first();
        if (empty($product))
        {
            $order->orderProducts()->create($request->except('_token')+[
                    'product_id' => $product_id,
                ]);
        }else{
            $amount = $product->quantity + $request->quantity;
            $product->update(['quantity' => $amount]);
        }
        return redirect()->back();
    }

    public function update($id, StoreOrderRequest $request)
    {
        OrderProduct::where('id', $id)->update($request->except('_token'));
        return $id;
    }

    public function destroy($id)
    {
        OrderProduct::findOrFail($id)->delete();
        return redirect()->back();
    }
}
