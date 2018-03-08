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

        $order = Order::where([['user_id', $user->id],['status', 0]])->get()->first();
        $order_products = $order->order()->get();

        return view('orders.single_basket', ['products' => $order_products]);
    }
    public function store($product_id, Request $request)
    {
        $user = Auth::user();
        $user_order = Order::where('user_id', $user->id)->get()->first();
        if ($user_order == null)
        {
            $order = $user->orders()->create([
                'status' => 0,
                'date' => Carbon::now(),
            ]);
        }else{
            $order = $user_order;
        }

        $order->order()->create($request->except('_token')+[
                'product_id' => $product_id,
            ]);
    }

    public function update(Request $request)
    {

    }
}
