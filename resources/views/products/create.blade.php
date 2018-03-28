@extends('layouts.page', ['title' => 'Create product'])
@section('content')
<div class="col-10">
    <div class="row">
<div class="col-12 text-center mt-5 mb-5">
    <h2>Create product</h2>
</div>
<div class="col-12">
<form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="row">
            <div class="col-lg-6 col-md-12">

                <div class="form-group">
                    <label class="col control-label">Pre-order?</label>
                    <div class="col">
                        <div class="radio">
                            <label>
                                <input class="yes" type="radio" name="preorder" value="1" /> Yes
                            </label>
                            <label>
                                <input class="no" type="radio" name="preorder" value="0" /> No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col control-label">Order deadline</label>
                    <div class="col inputGroupContainer">
                        <div class="input-group">
                            <input  name="deadline" placeholder="Order deadline" class="form-control deadline" disabled="true"  type="date">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col control-label">Name</label>
                    <div class="col inputGroupContainer">
                        <div class="input-group">
                            <input id="name" name="name" placeholder="Product name" class="form-control"  type="text" value="{{ old('name') }}">
                        </div>
                        @if ($errors->has('name'))
                        <span class="create-product-error">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col control-label">EAN</label>
                    <div class="col inputGroupContainer">
                        <div class="input-group">
                            <input type="number"  name="ean" placeholder="EAN" class="form-control"  type="text" value="{{ old('ean') }}">
                        </div>
                        @if ($errors->has('ean'))
                        <span class="create-product-error">
                            <strong>{{ $errors->first('ean') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col control-label">Select a platform</label>
                    <div class="col selectContainer">
                        <div class="input-group">
                            <input data-autocomplete="{{ $platforms }}" class="form-control autocomplete" type="text" name="platform_name" value="{{ old('platform_name') }}">
                        </div>
                        @if ($errors->has('platform_name'))
                        <span class="create-product-error">
                            <strong>{{ $errors->first('platform_name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col control-label">Select a category</label>
                    <div class="col selectContainer">
                        <div class="input-group-prepend input_cat">
                            <button class="btn btn-dark add_cat" type="button">Add</button>
                            @if(old('category_name') != null)
                                @foreach (old('category_name') as $category)
                                <input data-autocomplete="{{ $categories }}" class="form-control autocomplete" type="text" name="category_name[]" value="{{$category}}">
                                @endforeach
                            @else
                                <input data-autocomplete="{{ $categories }}" class="form-control autocomplete" type="text" name="category_name[]" value="{{ old('publisher_name') }}">
                            @endif
                            
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col control-label">Select a publisher</label>
                    <div class="col selectContainer">
                        <div class="input-group">
                            <input data-autocomplete="{{ $publishers }}" class="form-control autocomplete" type="text" name="publisher_name" value="{{ old('publisher_name') }}">
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <label class="col control-label">Release date</label>
                    <div class="col inputGroupContainer">
                        <div class="input-group">
                            <input  name="release_date" placeholder="Release date" class="form-control"  type="date" value="{{ old('release_date') }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col control-label">PEGI</label>
                    <div class="col inputGroupContainer">
                        <div class="input-group">
                            <input  name="pegi" placeholder="PEGI" class="form-control"  type="number" value="{{ old('video') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col control-label">Video URL</label>
                    <div class="col inputGroupContainer">
                        <div class="input-group">
                            <input  name="video" placeholder="Video URL" class="form-control"  type="text" value="{{ old('video') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col control-label">Images</label>
                    <div class="col inputGroupContainer">
                        <div class="input-group">
                            <input type="file" class="form-control-file" name="image" id="image">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col control-label">Price</label>
                    <div class="col inputGroupContainer">
                        <div class="input-group">
                            <input  name="price_amount" placeholder="Price" class="form-control"  type="text" value="{{ old('price_amount') }}">
                        </div>
                        @if ($errors->has('price_amount'))
                        <span class="create-product-error">
                            <strong>{{ $errors->first('price_amount') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col control-label">Stock</label>
                    <div class="col inputGroupContainer">
                        <div class="input-group">
                            <input  name="stock_amount" placeholder="Stock" class="form-control"  type="text" value="{{ old('stock_amount') }}">
                        </div>
                        @if ($errors->has('stock_amount'))
                        <span class="create-product-error">
                            <strong>{{ $errors->first('stock_amount') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col control-label">Synapsis</label>
                    <div class="col inputGroupContainer">
                        <div class="input-group">
                            <textarea class="form-control" name="description" placeholder="Synapsis" rows="2">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 form-group">
                <div class="col">
                    <button type="submit" class="btn btn-danger btn-block" >Create</button>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
</div>
</div>
</div
@endsection