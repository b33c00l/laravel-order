@extends('layouts.main', ['categories' => $categories])
@section('content')
<!-- Single page -->

<div class="col-10 mt-5 single-product">
    <div class="row">
        <div class="col-lg-12 col-md-12 text-center">
            <h1>{{ $productSingle->name }}</h1>
        </div>
        @if($productSingle->preorder == App\Product::ENABLED)
        <div class="col-lg-12 col-md-12 text-center">
            <h4 class="single-pre-order">Pre-Order Now</h4>
        </div>
        @endif
    </div>

    <div class="row">
         @admin
        <div class="col-12 d-flex justify-content-center">
            <a href="{{ route('products.edit', $productSingle->id) }}"><button class="btn btn-secondary">Edit</button></a>
            <form action="{{ route('products.destroy', ['id' => $productSingle->id ])}}" method="post">
                @csrf
                @method('delete')
                <div class="form-group">
                    <input type="hidden" name="_method" value="delete">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
         @endadmin
    </div>
    <div class="row slider-mobile-margin">
        <div class="col-lg-5 col-md-12">
            <div class="row">
                <div class="col-12">
                    <div id="gll" class="slider-for">
                        <div class="single-product-image d-flex justify-content-center"><a href="{{ $productSingle->featured_image_url }}"><img class="zoom" src="{{ $productSingle->featured_image_url }}"></a></div>
                        @foreach($productSingle->images as $image)
                        @if($image->featured != 1)
                        <div class="single-product-image d-flex justify-content-center"><a href="{{ $image->url }}"><img class="zoom" src="{{ $image->url }}"></a></div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <div class="slider-nav mt-3">
                        <div class="d-flex justify-content-center"><img class="zoom" src="{{ $productSingle->featured_image_url }}"></div>
                        @foreach($productSingle->images as $image)
                        @if($image->featured != 1)
                        <div class="d-flex justify-content-center"><img class="zoom" src="{{ $image->url }}"></div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-10 mt-5 pl-5 single-info">
                    <p>Category:
                        @for($i=0; count($productSingle->categories) > $i; $i++)
                            @if(count($productSingle->categories) == $i+1)
                                {{$productSingle->categories[$i]->name}}.
                            @else
                                {{$productSingle->categories[$i]->name}}, 
                            @endif
                        @endfor
                    </p>
                    <p>EAN: {{ $productSingle->ean }}</p>
                    <p>Platform: {{ $productSingle->platform->name }}</p>
                    @if (isset($productSingle->publisher->name))
                    <p>Publisher: {{ $productSingle->publisher->name }}</p>
                    @endif
                    <p>Pegi Rating: {{ $productSingle->pegi }}</p>
                    <p>Release date: {{ $productSingle->release_date }}</p>
                </div>
            </div>

        </div>
        <div class="col-lg-7 col-md-12">

            <div class="row">
                <div class="col-lg-12 col-md-12 single-price-block">
                    <div class="row">
                        <div class="col-lg-1 col-md-6">
                            <p>Price:</p>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <h3>€{{ $productSingle->price_amount }}</h3>
                        </div>
                        <div class="col-lg-1 col-md-6">
                            <p>Stock:</p>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <h3>{{ $productSingle->stock_amount }}</h3>
                        </div>
                        <div class="col-lg-6 col-md-12 single-price-block-button">
                            <div class="input-group mb-3 d-flex justify-content-center p-1">
                                <span class="add-to-cart-span" style="display:none; float: right; color: green;margin-right:10px;" id="message{{ $productSingle->id}}">Cart updated</span>
                              <input class="counter-inputas" type="number" id="value{{ $productSingle->id}}" name="amount">
                              <div class="input-group-append">
                                <button class="btn btn-dark add-into-cart-single" data-url="{{ route('order.store', $productSingle->id) }}">To Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-justify mt-3">
                <p>{{ $productSingle->description }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-3">
                <iframe width="100%" height="315" src="{{ $productSingle->video }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
        </div>

    </div>
</div>
<div class="col-12 mt-5">
    <h4>Related products</h4>
</div>
<div class="row mt-3">
    @foreach ($products as $related_prod)
    <div class="col-lg-3 col-md-12 related-products d-flex justify-content-center">
        <div class="related-products-wrap ml-1 mr-1">
        <a href="{{ route('products.show', [ 'id' => $related_prod->id ]) }}"><img src="{{ $related_prod->featured_image_url }}"></a>
    </div>
    </div>
    @endforeach
</div>
</div>
</div>

@endsection

