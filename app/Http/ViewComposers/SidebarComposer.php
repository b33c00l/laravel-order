<?php

namespace App\Http\ViewComposers;

use App\Services\ProductService;
use Illuminate\Contracts\View\View;
use App\Category;
use App\Product;
use DB;

class SidebarComposer
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function compose(View $view)
    {
        $cats = Category::all();
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
        $mostPopularProducts = $this->productService->getMostPopular();
        $view->with(['cats' => $cats, 'products_latest' => $products_latest, 'mpp' => $mostPopularProducts]);
    }
}