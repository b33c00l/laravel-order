<?php

namespace App\Http\Controllers;

use App\Client;
use App\Platform;
use App\Price;
use App\Product;
use App\Publisher;
use App\User;
use Illuminate\Http\Request;

class SpecialUserPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        $products = Product::all();
        $publishers = Publisher::all();
        $platforms = Platform::all();
        $selectedPlatform = null;
        $selectedPublisher = null;

        return view('special_user_price.index', compact('products', 'publishers', 'platforms', 'selectedPlatform', 'selectedPublisher', 'clients'));
    }

    public function store(Request $request)
    {
        $client_id = $request->get('client_id');
        $user_id = Client::findOrFail($client_id)->user->id;

        $games = $request->get('games');

        foreach ($games as $game) {
            $product = Product::FindOrFail($game);
            $specialProductPrice = $request->get('specialProductPrice');
            if ($product->base_price != $specialProductPrice[$game]){
               Price::create(['amount' => $specialProductPrice[$game], 'product_id' => $game, 'user_id' => $user_id]);
                $status = 'success';
                $msg = 'Special user offer has been made successfully';
            } else {
                $status = 'danger';
                $msg = 'Special user offer has not been made. Product prices was not changed';
            }
        }
        return redirect()->back()->with(['status' =>$status, 'msg'=>$msg]);
    }

    public function show()
    {
        $specialUsers = User::whereHas('price')->get();

        return view('special_user_price.show', compact('specialUsers'));
    }

    public function showSingle($user_id)
    {
        $specialPrices = Price::where('user_id', $user_id)->get();

        return view('special_user_price.single', compact('specialPrices'));
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


    public function delete()
    {

    }

    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
