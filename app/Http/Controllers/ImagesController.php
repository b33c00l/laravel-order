<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\StoreProductsRequest;
use App\Image;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    public function index()
    {
        $images = Image::all();
        return view('images.index', ['images' => $images]);
    }

    public function create()
    {
        return abort(404);
    }

    public function store()
    {
        return abort(404);
    }

    public function show($id)
    {
        $image = Image::findOrFail( $id );
        return view('images.show', [ 'image' => $image ]);
    }

    public function edit()
    {
        return abort(404);
    }

    public function update()
    {
        return abort(404);
    }

    public function destroy()
    {
        return abort(404);
    }
}
