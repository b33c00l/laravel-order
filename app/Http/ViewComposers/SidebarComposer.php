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
        $this->ProductService = $productService;
    }

    public function compose(View $view)
    {
        $cats = Category::all();
        $products_latest = Product::orderBy('id', 'desc')->take(8)->get();
        $mostPopularProducts = $this->ProductService->MostPopularProducts();
        $view->with(['cats' => $cats, 'products_latest' => $products_latest, 'mpp' => $mostPopularProducts]);
    }
}