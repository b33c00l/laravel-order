<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
    	$categories = Category::all();
        if ($request->get('query') == null) {
            $products = Product::paginate(25);
        } else {
            $products = Product::search('*' . $request->get('query') . '*')->paginate(25);
        }
        return view('home', ['products' => $products, 'categories' => $categories, 'query' => $request->get('query')]);

    }
}
