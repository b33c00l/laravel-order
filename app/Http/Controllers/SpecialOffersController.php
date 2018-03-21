<?php

namespace App\Http\Controllers;

use App\Client;
use App\Platform;
use App\Product;
use App\Publisher;
use App\Services\PricingService;
use App\SpecialOffer;
use App\User;
use Illuminate\Http\Request;

class SpecialOffersController extends Controller
{
    protected $price;

    public function __construct(PricingService $price)
    {
        $this->price = $price;
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
        $special_offer = SpecialOffer::create($request->only('expiration_date'));
        foreach ($clients as $client_id) {
            $client = Client::findOrFail($client_id);
            $special_offer->users()->attach($client->user->id);
        }

        $games = $request->get('games');

        foreach ($games as $game) {
            $special_offer->prices()->create(['amount' => $request->get('price'), 'product_id' => $game]);
        }

        return redirect()->back()->with('Success', 'Special offer created');
    }

    public function getByPlatform(Request $request)
    {
        $clients = Client::all();
        $platform_name = Platform::findOrFail($request->get('platform'));
        $products = Product::where('platform_id', $request->get('platform'))->get();
        $publishers = Publisher::all();
        $platforms = Platform::all();
        return view('special_offers.index', compact('products', 'publishers', 'platforms', 'platform_name', 'clients'));
    }

    public function getByPublisher(Request $request)
    {
        $clients = Client::all();
        $publisher_name = Publisher::findOrFail($request->get('publisher'));
        $products = Product::where('publisher_id', $request->get('publisher'))->get();
        $publishers = Publisher::all();
        $platforms = Platform::all();
        return view('special_offers.index', compact('products', 'publishers', 'platforms', 'publisher_name', 'clients'));
    }




    public function search(Request $request)
    {
        $clients = Client::all();
        $publishers = Publisher::all();
        $platforms = Platform::all();

        if ($request->get('search') == null) {
            $products = Product::all();
        } else {
            $products = Product::search('*' . $request->get('search') . '*')->get();
        }
        return view('special_offers.index', compact('products', 'publishers', 'platforms', 'clients'));
    }
}
