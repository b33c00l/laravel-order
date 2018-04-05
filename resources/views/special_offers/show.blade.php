@extends('layouts.main')
@section('content')
<!-- Table filters -->
<div class="col-lg-10 col-md-12">
    <div class="col-12 text-center mt-5 mb-5">
        <h2>Special offer</h2>
        <div class="mt-3">
            <a><img width="100%" src="{{asset('storage/image/'.$special_offer->filename)}}"/></a>
        </div>
    </div>
    @if ($special_offer->description != null)
        <div class="col-12 text-center mt-5 mb-5">
            <h3>Description:</h3>
            <p>{{$special_offer->description}}</p>
        </div>
    @endif
    @if ($special_offer->expiration_date != null)
        <div class="col-12 text-center mt-5 mb-5">
            <h3>Expiration:</h3>
        <h4>{{$special_offer->expiration_date}}</h4>
    </div>
    @endif
    
    <div id="radioboxes" class="row justify-content-around">
        <div class="col-12 checkboxes">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="show_preorders" @if (isset($preorder) && $preorder == 'hide') checked="checked" @endif>
                <label class="form-check-label" for="defaultCheck1">
                    Hide Pre-orders
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="show_backorders" @if (isset($backorder) && $backorder == 'hide') checked="checked" @endif">
                <label class="form-check-label" for="defaultCheck1">
                    Hide Back-orders
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="show_packshots">
                <label class="form-check-label" for="show_packshots">
                    Show Packshots
                </label>
            </div>
        </div>
        <div class="col-md-12 table-responsive">
            <table class="table table-sm table_container">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="packshots"></th>
                        <th scope="col" class="ean">
                            EAN:
                        </th>
                        <th scope="col" class="title">
                            Title:
                        </th>
                        <th scope="col" class="platform">
                            Pl.:
                        </th>
                        <th scope="col" class="release">
                            Release:
                        </th>
                        <th style="@if (isset($_GET['preorder']) && $_GET['preorder'] == 'hide') display:none; @endif" scope="col" class="preorders">
                            Deadline:
                        </th>
                        <th scope="col" class="publisher">
                            Publisher:
                        </th>
                        <th scope="col" class="stock">
                            Stock
                        </th>
                        <th scope="col" class="price">
                            Price
                        </th>
                        <th scope="col" class="amount">Amount</th>
                        <th scope="col" class="actions"></th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($errors->first()))
                    {{ $errors->first() }}
                    @endif
                    @foreach($products as $product)
                    <tr class="table-tr justify-content-center">
                        <td class="align-middle text-center product-image-mobile-center packshots">
                            <div class="packshot">
                                <a target="_blank" href="{{ $product->featured_image_url }}"><img src="{{ $product->featured_image_url }}"></a>
                            </div>
                        </td>
                        <td Data-label="EAN:" class="align-middle text-right text-lg-center" >{{$product->ean}}</td>
                        <td Data-label="Title:" class="align-middle text-right text-lg-center"><ins><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></ins></td>
                        <td Data-label="Platform:" class="align-middle text-right text-lg-center">{{ $product->platform->name }}</td>
                        <td Data-label="Release date:" class="align-middle text-right text-lg-center">
                            @if( $product->release_date != null)
                            {{ $product->release_date }}
                            @else
                            -
                            @endif
                        </td>
                        <td Data-label="Deadline:" class="align-middle text-right text-lg-center">
                            @if( $product->deadline != null)
                            {{ $product->deadline}}
                            @else
                            -
                            @endif
                        </td>
                        <td Data-label="Publisher:" class="align-middle text-right text-lg-center">{{ !empty($product->publisher) ? $product->publisher->name : '' }}</td>
                        <td Data-label="Stock:" class="align-middle text-right text-lg-center">{{$product->stockamount}}</td>
                        <td Data-label="Price:" class="align-middle text-right text-lg-center">{{ number_format($product->priceamount, 2, '.', '')}}</td>
                        <td Data-label="Amount" class="align-middle text-right text-lg-center">
                            <input class="input" type="number" id="value{{ $product->id }}" name="amount">
                            <span style="display: none; color: green" id="message{{ $product->id }}" ></span>
                        </td>
                        @admin
                        <td Data-label="Actions:" class="align-middle text-right text-lg-center">
                            <div class="dropdown">
                                <button class="btn btn-danger btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <button class="dropdown-item add-into-cart" data-url="{{ route('order.store', $product->id) }}">To cart</button>
                                    <a class="dropdown-item" href="{{ route('products.edit', ['id' => $product->id])}}">Edit</a>
                                    <form action="{{ route('products.destroy', ['id' => $product->id])}}" method="post">
                                        @csrf
                                        <input type="hidden" name="_method" value="delete">
                                        <button type="submit" class="dropdown-item">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        @else
                        <td class="align-middle text-right text-lg-center product-image-mobile-center">
                            <button class="btn btn-dark btn-sm add-into-cart" data-url="{{ route('order.store', $product->id) }}">To cart</button>
                        </td>
                        @endadmin
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection