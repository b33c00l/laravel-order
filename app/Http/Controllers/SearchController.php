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
            $products = Product::paginate(config('pagination.value'));
        } else {
            $products = Product::search('*"' . $request->get('query') . '"*')
//                ->orderBy('stock', 'desc')
                ->paginate(config('pagination.value'));
        }
        return view('home', ['products' => $products,
            'categories' => $categories,
            'sortName' => '',
            'direction'=> '',
            'query' => $request->get('query')]);
    }
}
