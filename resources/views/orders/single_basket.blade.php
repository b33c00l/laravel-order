@extends('layouts.main')
@section('content')
@inject('cartService', "App\Services\CartService")
<div class="col-10 mt-5">
    <!-- Order table -->
    <div class="row">
        <table class="table table-sm">
            <thead class="thead-light">
                <tr>
                    <th scope="col">EAN:</th>
                    <th scope="col">Platform:</th>
                    <th scope="col">Name:</th>
                    <th scope="col">Release date:</th>
                    <th scope="col">Publisher:</th>
                    <th scope="col">Price:</th>
                    <th scope="col">Price Total:</th>
                    <th scope="col">Quantity</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($products))
                @foreach($products as $product)
                <tr>
                    <td data-label="EAN:" class="align-middle text-right">{{ $product->product->ean }}</td>
                    <td data-label="Platform:" class="align-middle text-right">{{ $product->product->platform->name }}</td>
                    <td data-label="Name:" class="align-middle text-right">{{ $product->product->name }}</td>
                    <td data-label="Release date:" class="align-middle text-right">{{ $product->product->release_date }}</td>
                    <td data-label="Publisher:" class="align-middle text-right">{{ !empty($product->product->publisher) ? $product->product->publisher->name : '' }}</td>
                    <td data-label="Price:" class="align-middle text-right">{{ number_format($product->product->PriceAmount, 2, '.', '') }} €</td>
                    <td id="singlePrice{{ $product->id }}" data-label="Price:" class="align-middle text-right">{{ number_format($cartService->getSingleProductPrice($product), 2, '.', '') }} €</td>
                    <td data-label="Amount:" class="align-middle text-right">
                        <input data-url="{{ route('order.update',$product->id) }}" class="input setquantity" type="number" name="amount" value="{{ $product->quantity }}">
                        <br>
                        <span id="message{{ $product->id }}" ></span>
                    </td>
                    <td class="align-middle text-right">
                        <form action="{{route('order.product.delete', $product->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td scope="total" colspan="7" class="text-right"><b>Total</b></td>
                    <td class="align-middle text-right" id="totalPrice" rowspan="6" data-label="Total">{{ !empty($products) ? $cartService->getTotalCartPrice($order) : ''}} €</td>
                    <td class="align-middle text-right" id="totalQuantity" data-label="Total quantity">{{ !empty($products) ? $cartService->getTotalCartQuantity($order) : '' }}</td>
                </tr>
                @else
                <tr>
                    <td colspan="9" class="text-center"><b>Your cart is empty</b></td>
                </tr>
                <tr>
                    <td colspan="9"><a class="btn btn-dark" href="{{ route('home') }}">Back to Shop</a></td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <!-- Comments and attachments -->
    @if(!empty($products))
    <div class="row">
        <div class="col-12">
            <form action="{{ route('cart.confirm', $order_id) }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlTextarea1"><h4>Comments</h4></label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="6"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-danger btn-lg btn-block" >Confirm your order</button>
                </div>
            </div>
        </form>
    </div>
    @endif
</div>

@endsection