<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlatformRequest;
use App\Platform;

class PlatformController extends Controller
{

    public function index()
    {
        $platforms = Platform::all();
        return view('platforms.index', ['platforms' => $platforms]);
    }


    public function create()
    {
        return view('platforms.create');
    }


    public function store(StorePlatformRequest $request)
    {
        Platform::create($request->except('_token'));
        return redirect()->route('platforms.index');
    }


    public function single($id)
    {
        $platform = Platform::findOrFail($id);
        return view('platforms.single', ['platformSingle' => $platform]);
    }


    public function edit($id)
    {
        $platform = Platform::findOrFail($id);
        return view('platforms.edit', ['platformEdit' => $platform]);
    }


    public function update(StorePlatformRequest $request, $id)
    {
        Platform::findOrFail($id)->update(['name' => $request->get('name')]);
        return redirect()->route('platforms.single', $id);
    }


    public function destroy($id)
    {
        Platform::destroy($id);
        return redirect()->route('platforms.index');
    }
}
