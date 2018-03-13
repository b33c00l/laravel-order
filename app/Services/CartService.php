<?php

namespace App\Services;

use Auth;

class CartService
{
    public function getSingleProductPrice($product){
        $total = $product->product->PriceAmount * $product->quantity;
        return $total;
    }
    public function getTotalCartPrice($order)
    {
         $totalCartPrice = 0;
         foreach ($order->orderProducts as $product)
         {
             $totalCartPrice += $product->quantity * $product->product->PriceAmount;
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
}