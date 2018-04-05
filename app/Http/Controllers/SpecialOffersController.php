<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\StoreSpecialOfferRequest;
use App\Mail\SpecialOfferMail;
use App\Platform;
use App\Price;
use App\Product;
use App\Publisher;
use App\Services\ImageService;
use App\Services\PricingService;
use App\SpecialOffer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        $special_offer = SpecialOffer::create(['filename' => $filename] + $request->only('expiration_date', 'description'));

        foreach ($clients as $client_id) 
        {
            $client = Client::findOrFail($client_id);

            if($client->user != null)
            {
                $special_offer->users()->attach($client->user->id);
            }
        }

        $games = $request->get('games');

        $check = true;
        $specialProductPrice = $request->get('specialProductPrice');
        foreach ($games as $game) {
            $product = Product::FindOrFail($game);
            $price = $product->base_price;

            if (($request->get('price_coef') != null && $price != $specialProductPrice[$game])) {
                $check = false;
            }
        }
        if ($check == true){
            foreach ($games as $game) {
                $product = Product::FindOrFail($game);
                $price = $product->base_price;

                if ($request->get('price_coef') != null) {
                    $special_offer->prices()->create(['amount' => number_format($request->get('price_coef') * $price, 2, '.', ''), 'product_id' => $game]);
                } else {
                    $special_offer->prices()->create(['amount' => $specialProductPrice[$game], 'product_id' => $game]);
                }
            }
            $status = 'success';
            $msg = 'Special offer has been made successfully';
        }else{
            $status = 'danger';
            $msg = 'Please SELECT special offer with coefficient or make it by changing prices';
        }



        foreach ($special_offer->users as $user) {
            $email = $user->client->email;
            Mail::to($email)->send(new SpecialOfferMail($special_offer, $user));
        }

        return redirect()->back()->with(['status' =>$status, 'msg'=>$msg]);
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
        $special_offer = SpecialOffer::FindOrFail($id);
        $prices = $special_offer->prices()->with('products')->get();
        $products = [];
        foreach ($prices as $price)
        {
            $products[] = $price->products;
        }

        return view('special_offers.show', compact('special_offer', 'products'));
    }
}
