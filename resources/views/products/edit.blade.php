@extends('layouts.page')
@section('content')
<div class="col-10">
    <div class="row">
        <div class="col-12 text-center mt-5 mb-5">
            <h2>Edit product</h2>
        </div>
        <div class="col-12">
            <form action="{{ route('products.update', ['id' => $product->id]) }}" method="post" enctype="multipart/form-data">
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
                    <input type="hidden" name="_method" value="put">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">

                            <div class="form-group">
                                <label class="col control-label">Pre-order?</label>
                                <div class="col">
                                    <div class="radio">
                                        @if($product->preorder == 1)
                                            <label>
                                                <input class="yes" checked type="radio" name="preorder" value="1" /> Yes
                                            </label>
                                            <label>
                                                <input class="no" type="radio" name="preorder" value="0" /> No
                                            </label>
                                        @else
                                            <label>
                                                <input class="yes" type="radio" name="preorder" value="1" /> Yes
                                            </label>
                                            <label>
                                                <input class="no" checked  type="radio" name="preorder" value="0" /> No
                                            </label>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col control-label">Order deadline</label>
                                <div class="col inputGroupContainer">
                                    <div class="input-group">
                                        @if($product->preorder == 1)
                                            <input  name="deadline" placeholder="Order deadline" class="form-control deadline" type="date" value="{{ old('deadline', $product->deadline) }}">
                                        @else
                                            <input disabled  name="deadline" placeholder="Order deadline" class="form-control deadline" type="date" value="{{ old('deadline', $product->deadline) }}">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col control-label">Name</label>
                                <div class="col inputGroupContainer">
                                    <div class="input-group">
                                        <input id="name" name="name" placeholder="Product name" class="form-control"  type="text" value="{{ old('name', $product->name) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col control-label">EAN</label>
                                <div class="col inputGroupContainer">
                                    <div class="input-group">
                                        <input type="number"  name="ean" placeholder="EAN" class="form-control"  type="text" value="{{ old('ean', $product->ean) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col control-label">Select a platform</label>
                                <div class="col selectContainer">
                                    <div class="input-group">
                                        <input data-autocomplete="{{ $platforms }}" class="form-control autocomplete" type="text" name="platform_name" value="{{ old('platform', $product->platform->name) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col control-label">Select a category</label>
                                <div class="col selectContainer">
                                    <div class="input-group-prepend input_cat">
                                        <button class="btn btn-dark add_cat" type="button">Add</button>
                                        @if($product->categories->isNotEmpty())
                                        @foreach($product->categories as $category)
                                            <input data-autocomplete="{{ $categories }}" class="form-control autocomplete" type="text" name="category_name[]" value="{{$category->name}}">
                                        @endforeach
                                        @else
                                            <input data-autocomplete="{{ $categories }}" class="form-control autocomplete" type="text" name="category_name[]" placeholder="Select a category">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col control-label">Select a publisher</label>
                                <div class="col selectContainer">
                                    <div class="input-group ">
                                        @if($product->publisher != null)
                                        <input data-autocomplete="{{ $publishers }}" class="form-control autocomplete" type="text" name="publisher_name" value="{{ old('publisher', $product->publisher->name) }}">
                                        @else
                                        <input data-autocomplete="{{ $publishers }}" class="form-control autocomplete" type="text" name="publisher_name" value="">
                                        @endif
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

                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label class="col control-label">Release date</label>
                                <div class="col inputGroupContainer">
                                    <div class="input-group">
                                        <input  name="release_date" placeholder="Release date" class="form-control"  type="date" value="{{  old('release_date', $product->release_date) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col control-label">PEGI</label>
                                <div class="col inputGroupContainer">
                                    <div class="input-group">
                                        <input  name="pegi" placeholder="PEGI" class="form-control"  type="number" value="{{ old('pegi', $product->pegi) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col control-label">Video URL</label>
                                <div class="col inputGroupContainer">
                                    <div class="input-group">
                                        <input  name="video" placeholder="Video URL" class="form-control"  type="text" value="{{ old('video', $product->video) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col control-label">Price</label>
                                <div class="col inputGroupContainer">
                                    <div class="input-group">
                                        <input  name="price_amount" placeholder="Price" class="form-control"  type="text" value="{{ old('price_amount', $product->price_amount) }}">
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
                                        <input  name="stock_amount" placeholder="Stock" class="form-control"  type="text" value="{{ old('stock_amount', $product->stock_amount) }}">
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
                                        <textarea class="form-control" name="description" placeholder="Synapsis" rows="4">{{ old('description', $product->description) }}</textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="col">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="col control-label">Select featured image:</label>
                                        @foreach ($product->images as $image)
                                            <div style="width: 100px; height: 50px; display: inline-block;">
                                                <a target="_blank" href="{{ $image->url }}"><img style="width: 100%;" src="{{ $image->url }}"></a>
                                            </div>
                                        <input class="form-radio-input" name="featured" type="radio" value="{{ $image->id }}" id="{{ $image->filename }}"
                                        @if (old('featured', $product->featured_image->id) == $image->id) checked @endif>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="col">
                                <div class="form-group">
                                    <label class="col control-label">Select images to remove:</label>
                                    @foreach ($product->images as $image)
                                        <div style="width: 100px; height: 50px; display: inline-block;">
                                            <a target="_blank" href="{{ $image->url}}"><img style="width: 100%;" src="{{ $image->url}}"></a>
                                        </div>
                                        <input class="form-radio-input" name="image_id[]" type="checkbox" value="{{ $image->id }}" id="{{ $image->filename }}"
                                    @if ((is_array(old('image_id'))) && in_array($image->id, old('image_id'))) checked
                                    @endif>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12 form-group">
                            <div class="col">
                                <button type="submit" class="btn btn-danger btn-block" >Edit</button>
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

