<?php

namespace App\Http\Controllers;

use App\Country;
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


    public function store(Request $request)
    {
        Country::create($request->only('name', 'email', 'phone'));
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


    public function update(Request $request, $id)
    {
        Country::findOrFail($id)->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
        ]);
        return redirect()->route('countries.show', $id);
    }


    public function destroy($id)
    {
        Country::destroy($id);
        return redirect()->route('countries.index');
    }
}
