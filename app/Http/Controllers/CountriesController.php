<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Requests\StoreCountryRequest;
use Illuminate\Http\Request;

class CountriesController extends Controller
{

    public function index()
    {
        $countries = Country::all();
        return view('countries.index', ['countries' => $countries]);
    }


    public function create()
    {
        return view('countries.create');
    }


    public function store(StoreCountryRequest $request)
    {
        if($request->default == 1) {
            $default_country = Country::where('default', 1)->first();
            if($default_country) {
                $default_country->update(['default' => 0]);
            }
        }
       Country::create($request->only('name', 'email', 'phone', 'default'));

        return redirect()->route('countries.index');
    }

    public function show($id)
    {
        $country = Country::findOrFail($id);
        return view('countries.show', ['countriesSingle' => $country]);
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);
        return view('countries.edit', ['countriesEdit' => $country]);
    }


    public function update(StoreCountryRequest $request, $id)
    {
        $arr = $request->only('name', 'email', 'phone') + [ 'default'=> 1];
        if($request->default == 1) {
            Country::where('default', 1)->update(['default' => 0]);
        }else{
            $arr['default']=0;
        }
        Country::findOrFail($id)->update($arr);
        return redirect()->route('countries.show', $id);
    }

    public function destroy($id)
    {
        Country::destroy($id);
        return redirect()->route('countries.index');
    }
}
