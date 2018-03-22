<?php

namespace App\Services;


use App\Product;
use DB;

class ProductService {
    public function MostPopularProducts($quantity = 3)
    {
        return $mostPopularProducts = Product::select('products.*', 'product_id')
            ->addSelect(DB::raw('SUM(quantity) as Total'))
            ->from('order_products')
            ->join('products', function ($join) {
                $join->on('order_products.product_id', '=', 'products.id');
            })
            ->join('orders', function ($join) {
                $join->on('order_products.order_id', '=', 'orders.id');
            })
            ->where('status', '=', 2)
            ->groupBy('order_products.product_id')
            ->orderByRaw('Total DESC')
            ->limit($quantity)
            ->get();
    }
}