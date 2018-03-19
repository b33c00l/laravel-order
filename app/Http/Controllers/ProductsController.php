<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductsRequest;
use App\Platform;
use App\Product;
use App\Publisher;
use App\Services\ImageService;
use App\Stock;
use App\Image;
use App\Price;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $products = Product::all();

        return view('products.index', ['products' => $products]);
    }

    public function create()
    {
        $platforms = Platform::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('products.create',['platforms' => $platforms, 'publishers' => $publishers, 'categories' => $categories]);
    }

    public function store(StoreProductsRequest $request)
    {

        $category = Category::where('name', $request->get('category_name'))->first();
        $platform = Platform::where('name', $request->get('platform_name'))->first();
        $publisher = Publisher::where('name', $request->get('publisher_name'))->first();

        if ($platform == null) {
            $platform = Platform::create( ['name' => $request->get('platform_name')] );
        } 

        if ($category == null) {
            $category = Category::create( ['name' => $request->get('category_name')] );

        } 

        if ($publisher == null) {
            $publisher = Publisher::create( ['name' => $request->get('publisher_name')] );
        } 

        $product = Product::create($request->except('_token') + ['platform_id' => $platform->id, 'publisher_id' => $publisher->id]);
        $product->categories()->attach($category->id);
        $product->stock()->create( ['amount' => $request->get('stock_amount')] );
        $product->prices()->create( ['amount' => $request->get('price_amount')] );
        if ($request->has('image')) {
            $this->imageService->storeProductImages($product, $request->file('image'));
        }

        return redirect()->route('products.index');
    }

    public function show($id)
    {   
        $categories = Category::all();
        $product = Product::findOrFail($id);
        $product_cats = $product->categories->pluck('id');

        $products = Product::whereHas('categories', function ($query) use ($product_cats) {
            $query->whereIn('id', $product_cats);
        })->take(4)->get();
        
        return view('products.show', ['productSingle' => $product, 'products' => $products, 'categories' => $categories]);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $platforms = Platform::all();
        $publishers = Publisher::all();
        return view('products.edit', ['product' => $product, 'platforms' => $platforms, 'publishers' => $publishers]);
    }

    public function update(StoreProductsRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update([
            'name' => $request->get('name'),
            'ean' => $request->get('ean'),
            'description' => $request->get('description'),
            'release_date' => $request->get('release_date'),
            'pegi' => $request->get('pegi'),
            'video' => $request->get('video'),
            'platform_id' => $request->get('platform_id'),
            'publisher_id' => $request->get('publisher_id'),
        ]);

        if($product->stock_amount !=  $request->get('stock_amount')) {
            $product->stock()->create( ['amount' => $request->get('stock_amount')] );
        }
        if($product->price_amount !=  $request->get('price_amount')) {
            $product->prices()->create( ['amount' => $request->get('price_amount')] );
        }

        $this->imageService->updateProductImages($product, $request->only(['image_id', 'image', 'featured']));

        return redirect()->route('products.show', $id);

    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $prices_to_delete = $product->prices->pluck('id');
        $stock_to_delete = $product->stock->pluck('id');

        $this->imageService->deleteProductImages($product);
        Price::destroy($prices_to_delete);
        Stock::destroy($stock_to_delete);

        Product::destroy($id);

        return redirect()->route('products.index');
    }
}
