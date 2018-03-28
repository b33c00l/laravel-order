@extends('layouts.main', ['title' => 'Single order'])
@section('content')
@inject('cartService',"App\Services\CartService")
<div class="col-10 mt-5">

    <!-- Order table -->
    <div class="row">
        <div class="col-md-12 table-responsive">
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
                    <th scope="col">Amount</th>
                    @admin
                    <th scope="col"></th>
                    @endadmin
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td data-label="EAN:" class="align-middle">{{$product->product->ean}}</td>
                        <td data-label="Platform:" class="align-middle">{{$product->product->platform->name}}</td>
                        <td data-label="Name:" class="align-middle">{{$product->product->name}}</td>
                        <td data-label="Release date:" class="align-middle">{{$product->product->release_date}}</td>
                        <td data-label="Publisher:" class="align-middle">{{ $product->product->has('publisher') ? $product->product->publisher->name : '-'}}</td>

                        <td data-label="Price:" class="align-middle">
                            @admin
                                <input data-url="{{ route('order.update', $product->id) }}" class="input updateP" type="number" value="{{ $product->price }}" name="amount"> €
                                <br>
                                <span style="display: none; color: green" id="Pmessage{{ $product->id }}"></span>
                            @else
                                <p>{{ number_format($product->product->priceamount, 2, '.', '')}} €</p>
                            @endadmin
                        </td>
                        <td data-label="Price Total:" class="align-middle" id="singlePrice{{ $product->id }}">{{ number_format($cartService->getSingleProductPrice($product), 2, '.', '')}} €</td>
                        <td data-label="Amount:" class="align-middle">
                            @admin
                                <input data-url="{{ route('order.update', $product->id) }}" class="input updateQ" type="number" value="{{$product->quantity}}" name="amount">
                                <br>
                                <span style="display: none; color: red" id="Qmessage{{ $product->id }}"></span>
                            @else
                                <p>{{ $product->quantity}}</p>
                            @endadmin
                        </td>
                        @admin
                        <td class="align-middle">
                            <form action="{{route('order.product.delete', $product->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                            </form>
                        </td>
                        @endadmin
                    </tr>
                @endforeach
                <tr>
                    <td class="total"></td>
                    <td class="total"></td>
                    <td class="total"></td>
                    <td class="total"></td>
                    <td class="total"></td>
                    <td class="total" scope="Total"><b>Total</b></td>
                    <td data-label="Total" id="totalPrice">{{!empty($products)?number_format($cartService->getTotalCartPrice($order), 2,'.',''):""}} €</td>
                    <td data-label="Total quantity" id="totalQuantity">{{!empty($products)?$cartService->getTotalCartQuantity($order):""}}</td>
                    @admin
                    <td class="total"></td>
                    @endadmin
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Comments and attachments -->
    @admin
    <form method="post" action="{{route('order.action', $order->id)}}" enctype="multipart/form-data">
    <div class="row">

            @csrf
            @method('PUT')
            <div class="col-6">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1"><h4>Comments</h4></label>
                        <textarea class="form-control" name="text" id="exampleFormControlTextarea1" rows="6"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="action" role="button" class="btn btn-primary" value="confirm">
                        <input type="submit" name="action" role="button" class="btn btn-danger" value="reject">
                    </div>
            </div>
            <div class="col-6">
                    <div class="form-group">
                        <label for="invoice"><h4>Invoice</h4></label>
                        <input class="form-control" id="invoice" type="file" name="invoice">
                    </div>
            </div>

    </div>
    </form>
    @endadmin
</div>
@endsection