<?php

namespace App\Http\Controllers;

use App\Product;
use DB;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $products = Product::with('platform','publisher', 'images')->paginate(env('PAGINATE', 25));

        return view('home', [
            'products' => $products,
            'categories' => $categories,
            'direction' => '',
            'sortName' => ''
        ]);
    }

    public function sort(Request $request)
    {
        if($request->get('direction') == 'asc') {
            $direction = 'asc';
        } else {
            $direction = 'desc';
        }

        switch ($request->get('name')) {
            case 'pub':
                $products = Product::select('products.*')->leftJoin('publishers as pub', 'pub.id', '=', 'publisher_id')
                    ->orderBy('pub.name', $direction);
                break;
            case 'plat':
                $products = Product::select('products.*')->leftJoin('platforms as plat', 'plat.id', '=', 'platform_id')
                    ->orderBy('plat.name', $direction);
                break;
            case 'title':
                $products = Product::with('platform','publisher', 'images')
                    ->orderBy('name', $direction);
                break;
            case 'ean':
                $products = Product::with('platform','publisher', 'images')
                    ->orderBy('ean', $direction);
                break;
            case 'release':
                $products = Product::with('platform','publisher', 'images')
                    ->orderBy('release_date', $direction);
                break;
            case 'stock':
                $products = Product::select('products.*',
                    DB::raw('(SELECT amount FROM stock WHERE product_id = products.id ORDER BY date DESC LIMIT 1) AS amount'))
                    ->orderBy('amount', $direction);
                break;
            default:
                $products = Product::with('platform','publisher', 'images')->orderBy('name', $direction);
                break;

        }
        $products = $products->paginate(env('PAGINATE', 25));
        $categories = Category::all();
        return view('home', [
            'products' => $products->appends(Input::except('page')),
            'categories' => $categories,
            'sortName' =>  $request->get('name'),
            'direction' => $direction
        ]);
    }

    public function contacts() 
    {
        return view('pages.contacts');
    }


}
