<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\StoreSpecialOfferRequest;
use App\Platform;
use App\Price;
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
        $selectedPlatform = null;
        $selectedPublisher = null;

        return view('special_offers.index', compact('products', 'publishers', 'platforms', 'selectedPlatform', 'selectedPublisher', 'clients'));
    }

    public function store(StoreSpecialOfferRequest $request)
    {
        $clients = $request->get('client_id');
        $file = $request->filename;
        $filename = $this->imageService->uploadImage($file);
        $specialOffer = SpecialOffer::create(['filename' => $filename] + $request->only('expiration_date', 'description'));
        foreach ($clients as $client_id) {
            $client = Client::findOrFail($client_id);
            $specialOffer->users()->attach($client->user->id);
        }

        $games = $request->get('games');

        foreach ($games as $game) {
            dd($request->specialProductPrice);
            $product = Product::FindOrFail($game);
            $price = $product->prices()->where('special_offer_id', null)->where('user_id', null)->orderBy('date', 'DESC')->first();
            $specialOffer->prices()->create(['amount' => $request->get('price_coef') * $price->amount, 'product_id' => $game]);
        }
        return redirect()->back()->with('status', 'Success');
    }

    public function filter(Request $request)
    {
        $publishers = Publisher::all();
        $platforms = Platform::all();
        $clients = Client::all();
        $selectedPlatform = $request->get('platform');
        $selectedPublisher = $request->get('publisher');

        $products = new Product;

        if (strlen($request->get('search')) > 0) {
            $ids = $products->search('*' . $request->get('search') . '*')->get()->pluck('id');
            $products = Product::whereIn('id', $ids);
        }

        if ($request->get('platform') > 0) {
            $products = $products->where('platform_id', $request->get('platform'));
        }

        if ($request->get('publisher') > 0) {
            $products = $products->where('publisher_id', $request->get('publisher'));
        }

        $products = $products->get();

        return view('special_offers.index', compact('products', 'publishers', 'platforms', 'selectedPublisher', 'selectedPlatform', 'clients'));
    }

    public function show($id)
    {
        $specialOffer = SpecialOffer::FindOrFail($id);

        return view('special_offers.show', compact('specialOffer'));
    }
}
