<?php

namespace App\Services;

use App\Order;
use Auth;
use Carbon\Carbon;
use App\OrderProduct;

class CartService
{
    public function getSingleProductPrice($product){
        $total = $product->price * $product->quantity;
        return $total;
    }
    public function getTotalCartPrice($order)
    {
         $totalCartPrice = 0;
         foreach ($order->orderProducts as $product)
         {
             $totalCartPrice += $product->quantity * $product->price;
         }
         return $totalCartPrice;
    }
    public function getTotalCartQuantity($order)
    {
        $totalCartQuantity = 0;
        foreach ($order->orderProducts as $product)
        {
            $totalCartQuantity += $product->quantity;
        }
        return $totalCartQuantity;
    }

    public function storeOrder($product, $request)
    {
        $user = Auth::user();
        $user_order = $user->orders()->InCart()->Order()->first();

        if (empty($user_order))
        {
            $this->createOrder($user);
        }else{
            $order = $user_order;
        }
        $order_product = $order->orderProducts->where('product_id', $product->id)->first();
        if ($order_product == null)
        {
            if ($request->quantity <= $product->stockamount)
            {
                $quantity  = $request->quantity;
                $value = 0;
            }else{
                $quantity  = $product->stockamount;
                $value = $request->quantity - $product->stockamount;
            }
            $order->orderProducts()->create([
                    'product_id' => $product->id,
                    'price' => $product->PriceAmount,
                    'quantity' => $quantity,
                ]);
        }else{
            $amount = $order_product->quantity + $request->quantity;
            if ($amount <= $product->stockamount)
            {
                $order_product->update(['quantity' => $amount]);
                $value = 0;
            }else{
                $order_product->update(['quantity' => $product->stockamount]);
                $value = $amount - $product->stockamount;
            }

        }
        return $value;
    }

    public function createOrder($user)
    {
        $order = $user->orders()->create([
            'status' => Order::PENDING,
            'date' => Carbon::now(),
            'type' => Order::ORDER
        ]);
        return $order;
    }

    public function storeBackOrder($product, $quantity)
    {
        $user = Auth::user();
        $user_backorder = $user->orders()->InCart()->BackOrder()->first();
        if (empty($user_backorder))
        {
            $backorder = $user->orders()->create([
                'status' => Order::PENDING,
                'date' => Carbon::now(),
                'type' => Order::BACKORDER
            ]);
        }else{
            $backorder = $user_backorder;
        }
        $backorder_product = $backorder->orderProducts->where('product_id', $product->id)->first();
        if ($backorder_product == null)
        {
            $backorder->orderProducts()->create([
                    'product_id' => $product->id,
                    'price' => $product->PriceAmount,
                    'quantity' => $quantity
                ]);
        }else{
            $amount = $backorder_product->quantity + $quantity;
            $backorder_product->update(['quantity' => $amount]);
        }
    }

    public function storePreOrder($product, $quantity)
    {
        $user = Auth::user();
        $user_preorder = $user->orders()->InCart()->Preorder()->first();
        if (empty($user_preorder))
        {
            $preorder = $user->orders()->create([
                'status' => Order::PENDING,
                'date' => Carbon::now(),
                'type' => Order::PREORDER
            ]);
        }else{
            $preorder = $user_preorder;
        }
        $preorder_product = $preorder->orderProducts->where('product_id', $product->id)->first();
        if ($preorder_product == null)
        {
            $preorder->orderProducts()->create([
                'product_id' => $product->id,
                'price' => $product->PriceAmount,
                'quantity' => $quantity
            ]);
        }else{
            $amount = $preorder_product->quantity + $quantity;
            $preorder_product->update(['quantity' => $amount]);
        }
    }

	public function getUserOrderTotalPrice() {
		$order = Auth::user()->orders->where('status', 0)->first();
		if (!empty($order)){
			$price = $this->getTotalCartPrice($order);
			return $price;
		}else{
			return 0;
		}
    }

	public function getUserOrderTotalQuantity() {
		$order = Auth::user()->orders->where('status', 0)->first();
		if (!empty($order)){
			$quantity = $this->getTotalCartQuantity($order);
			return $quantity;
		}else{
			return 0;
		}
	}

	public function updateOrder($quantity, $product) {
        $product->update(['quantity' => $quantity]);
        $singleProduct = $product->first();
        $data = ['id' => $product->first()->id,
            'totalQuantity' => $this->getTotalCartQuantity($singleProduct->order),
            'singleProductPrice' => $this->getSingleProductPrice($singleProduct),
            'totalPrice' => $this->getTotalCartPrice($singleProduct->order),
        ];
        return $data;
    }

    public function delPendingPreorders($preorderProduct)
    {
        $products = OrderProduct::where('product_id', $preorderProduct->id)->get();
        if (!empty($products)) {
            foreach ($products as $product) {
                $order = $product->order()->first();
                if ($order->status === Order::PENDING && $order->type === Order::PREORDER)
                {
                    $product->delete();
                    $order = Order::findOrFail($order->id);
                    if ($order->orderProducts->count() == 0) {
                        $order->delete();
                    }
                }
            }
        }

    }
}