<?php

namespace App\Http\Controllers;

use App\Product;

use App\Category;

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
        $products = Product::with('platform','publisher', 'images')->orderBy('id', 'desc')->paginate(25);
        return view('home', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function contacts() 
    {
        return view('pages.contacts');
    }


}
