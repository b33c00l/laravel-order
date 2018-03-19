<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Category;
use App\Product;

class SidebarComposer {

	public function compose(View $view) {

		$cats = Category::all();
		$products_latest = $products = Product::orderBy('id', 'desc')->take(8)->get();

		$view->with(['cats' => $cats, 'products_latest' => $products_latest]);

	}	

}