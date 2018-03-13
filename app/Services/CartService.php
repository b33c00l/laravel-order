<?php

namespace App\Services;

use App\Order;
use App\OrderProduct;
use Auth;
use App\User;

class CartService
{
    public function getSingleProductPrice($product){
        $total = $product->product->PriceAmount * $product->quantity;
        return $total;
    }
    public function getTotalCartPrice($order)
    {
         $totalCartPrice = 0;
         $products = $order;
         foreach ($products as $product)
         {
             $totalCartPrice += $product->quantity * $product->product->PriceAmount;
         }
         return $totalCartPrice;
    }
    public function getTotalCartQuantity($order)
    {
        $totalCartQuantity = 0;
        $products = $order;
        foreach ($products as $product)
        {
            $totalCartQuantity += $product->quantity;
        }
        return $totalCartQuantity;
    }
}