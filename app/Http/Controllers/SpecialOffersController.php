<?php

namespace App\Http\Controllers;

use App\Client;
use App\Platform;
use App\Product;
use App\Publisher;
use App\Services\ImageService;
use App\Services\PricingService;
use App\SpecialOffer;
use App\User;
use Illuminate\Http\Request;

class SpecialOffersController extends Controller
{
    protected $price;
    protected $imageService;
    private $image_dir = 'public/image/';

    public function __construct(PricingService $price, ImageService $image)
    {
        $this->price = $price;
        $this->imageService = $image;
    }

    public function index()
    {
        $clients = Client::all();
        $products = Product::all();
        $publishers = Publisher::all();
        $platforms = Platform::all();
        return view('special_offers.index', compact('products', 'publishers', 'platforms', 'clients'));
    }

    public function store(Request $request)
    {

        $clients = $request->get('client_id');
        if ($request->has('filename')) {

            $file = $request->filename;
            $path = $file->storePublicly($this->image_dir);

            $filename = basename($path);

            $special_offer = SpecialOffer::create(['filename' => $filename] + $request->only('expiration_date', 'description'));
        }else {
            $special_offer = SpecialOffer::create($request->only('expiration_date', 'description'));
        }
        foreach ($clients as $client_id) {
            $client = Client::findOrFail($client_id);
            $special_offer->users()->attach($client->user->id);
        }

        $games = $request->get('games');

        foreach ($games as $game) {
            $special_offer->prices()->create(['amount' => $request->get('price'), 'product_id' => $game]);
        }
        return redirect(route('special.index'));
    }

    public function  filter(Request $request)
    {
        $publishers = Publisher::all();
        $platforms = Platform::all();
        $clients = Client::all();

            if($request->platform == 0 && $request->publisher == 0){
                $products = Product::where('name', 'LIKE', '%'.$request->get('search').'%')->get();
            }
            elseif ($request->platform > 0 && $request->publisher == 0) {
                $products = Product::where('platform_id', $request->get('platform'))->where('name', 'LIKE', '%'.$request->get('search').'%')->get();
            }
            elseif ($request->platform == 0 && $request->publisher > 0){
                $products = Product::where('publisher_id', $request->get('publisher'))->where('name', 'LIKE', '%'.$request->get('search').'%')->get();
            }
            elseif ($request->platform > 0 && $request->publisher > 0){
                $products = Product::where('publisher_id', $request->get('publisher'))->where('platform_id', $request->get('platform'))->where('name', 'LIKE', '%'.$request->get('search').'%')->get();
            }

        return view('special_offers.index', compact('products', 'publishers', 'platforms', 'platform_name', 'publisher_name', 'clients'));
    }

    public function show($id)
    {
        $special_offer = SpecialOffer::FindOrFail($id);

        return view('special_offers.show', compact('special_offer'));
    }
}
