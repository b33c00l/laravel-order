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

        $view->with(['cats' => Category::all(), 'products_latest' => $this->productService->newArrivals(), 'mpp' => $this->productService->getMostPopular()]);
    }
}