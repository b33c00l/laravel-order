<?php

namespace App\Http\Controllers;

use App\Product;
use DB;
use App\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
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
        $products = Product::with('platform','publisher', 'images')->paginate(config('pagination.value'));

        return view('home', [
            'products' => $products,
            'categories' => $categories,
            'direction' => '',
            'sortName' => '',
        ]);
    }

    public function paginate($items, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, config('pagination.value')), $items->count(), config('pagination.value'), $page, $options);
    }

    public function sort(Request $request)
    {
        $products = Product::with('platform','publisher', 'images');

        if ($request->get('direction') == 'asc') {
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
                $products = $products->orderBy('name', $direction);
                break;
            case 'ean':
                $products = $products->orderBy('ean', $direction);
                break;
            case 'release':
                $products = $products->orderBy('release_date', $direction);
                break;
            case 'stock':
                $products = Product::select('products.*',
                    DB::raw('(SELECT amount FROM stock WHERE product_id = products.id ORDER BY date DESC LIMIT 1) AS amount'))
                    ->orderBy('amount', $direction);
                break;
            case 'price':
                $products = Product::all();
                if ($direction == 'desc') {
                    $products = $this->paginate($products->sortBy('PriceAmount') );
                } else {
                    $products = $this->paginate($products->sortByDesc('PriceAmount'));
                }
                $products->setPath('/sort');
                break;
            default:
                $products = $products->orderBy('name', $direction);
                break;
        }

        if(!($products instanceof LengthAwarePaginator)){
            $products = $products->paginate(config('pagination.value'));
        }
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
