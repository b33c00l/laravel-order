<?php

namespace App\Services;

use App\Order;
use App\Product;
use DB;


class ProductService {
    public function getMostPopular($quantity = 3)
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
            ->where('status', '=', Order::CONFIRMED)
            ->groupBy('order_products.product_id')
            ->orderByRaw('Total DESC')
            ->limit($quantity)
            ->get();
    }

    public function getNewArrivals()
    {
        return Product::with('platform')
          ->whereRaw('(SELECT stock.amount FROM stock WHERE products.id = stock.product_id ORDER BY id DESC LIMIT 1) > IFNULL((SELECT stock.amount FROM stock WHERE products.id = stock.product_id ORDER BY id DESC LIMIT 1, 1), 0)')
          ->take(12)->get();
    }
}