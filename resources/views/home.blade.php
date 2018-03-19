@extends('layouts.main')
@section('content')

    <!-- Table filters -->
    <div class="col-lg-10 col-md-12">
        <div id="radioboxes" class="row justify-content-around">
            <div class="col-12 checkboxes">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="show_preorders">
                    <label class="form-check-label" for="defaultCheck1">
                        Hide Pre-orders
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="show_backorders">
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
            <!-- Product table -->
            <div class="col-md-12 table-responsive">
                <table class="table table-sm table_container">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="ean">EAN:<i class="fa fa-sort-down"></i></th>
                            <th scope="col" class="title">Title:<i class="fa fa-sort-down title"></i></th>
                            <th scope="col" class="platform">Platform:</th>
                            <th scope="col" class="release">Release:<i class="fa fa-sort-down"></i></th>
                            <th scope="col" class="preorders">Order deadline:<i class="fa fa-sort-down"></i></th>
                            <th scope="col" class="publisher">Publisher:<i class="fa fa-sort-down"></i></th>
                            <th scope="col" class="stock">Stock:<i class="fa fa-sort-down"></i></th>
                            <th scope="col" class="price">Price:<i class="fa fa-sort-down"></i></th>
                            <th scope="col">Amount<i class="fa fa-sort-down"></i></th>
                            <th scope="col"></th>
                            <th scope="col" class="packshots"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($errors->first()))
                        {{ $errors->first() }}
                        @endif
                        @foreach($products as $product)
                        <tr class="table-tr">
                            <td Data-label="EAN:" class="align-middle text-right" >{{$product->ean}}</td>
                            <td Data-label="Title:" class="align-middle text-right"><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></td>
                            <td Data-label="Platform:" class="align-middle text-right">{{ $product->platform->name }}</td>
                            <td Data-label="Release date:" class="align-middle text-right release">{{ $product->release_date }}</td>
                            <td Data-label="Order deadline:" class="align-middle text-right preorders">2018-03-15</td>
                            <td Data-label="Publisher:" class="align-middle text-right publisher">{{ !empty($product->publisher) ? $product->publisher->name : '' }}</td>
                            <td Data-label="Stock:" class="align-middle text-right">{{$product->stockamount}}</td>
                            <td Data-label="Price:" class="align-middle text-right">{{ number_format($product->priceamount, 2, '.', '')}}</td>
                            <td Data-label="Amount" class="align-middle text-right">
                                <input class="input" type="number" id="value{{ $product->id }}" name="amount">
                                <span style="display: none; color: green" id="message{{ $product->id }}" ></span>
                            </td>
                            <td class="align-middle text-right product-image-mobile-center">
                                <button class="btn btn-dark btn-sm add-into-cart" data-url="{{ route('order.store', $product->id) }}">To cart</button>
                            </td>
                            <td class="align-middle product-image-mobile-center packshots">
                                <div class="packshot">
                                    <img src="{{ $product->featured_image_url}}">
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="pagination" class="row justify-content-center">
                {{$products->links()}}
            </div>
        </div>
    </div>
</div>
@endsection