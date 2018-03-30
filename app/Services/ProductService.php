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
        $products = Product::all();
        $products_latest = [];

        foreach ($products as $product) {
            $stock = $product->stock()->orderBy('id', 'desc')->take(2)->get();

            if (count($stock) == 1) {
                $products_latest[] = $product;
            }
            if (count($stock) > 1) {
                if ($stock[0]->amount > $stock[1]->amount) {
                    $products_latest[] = $product;
                }
            }
        }
        return $products_latest;
    }
}