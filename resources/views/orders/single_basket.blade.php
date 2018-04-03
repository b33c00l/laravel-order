@extends('layouts.main', ['title' => 'Single basket'])
@section('content')
    @inject('cartService', "App\Services\CartService")
    <div class="col-10 mt-5">
        <form method="post" action="{{ route('order.product.del_selected') }}">
        @csrf
        @method('delete')
        <!-- Order table -->
            <div class="row">
                <h3>ORDER</h3>
                <table class="table table-sm">
                    <thead class="thead-light">
                    <tr>
                        <th><input type="checkbox" class="selectAll" name="selectAll" value="orders" ></th>
                        <th scope="col">EAN:</th>
                        <th scope="col">Platform:</th>
                        <th scope="col">Name:</th>
                        <th scope="col">Release date:</th>
                        <th scope="col">Publisher:</th>
                        <th scope="col">Price:</th>
                        <th scope="col">Price Total:</th>
                        <th scope="col">Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($products))
                        @foreach($products as $product)
                            <tr>
                                <td class="align-middle"><input type="checkbox" class="orders" name="checkbox[]" value="{{$product->id}}"></td>
                                <td data-label="EAN:" class="align-middle text-right">{{ $product->product->ean }}</td>
                                <td data-label="Platform:" class="align-middle text-right">{{ $product->product->platform->name }}</td>
                                <td data-label="Name:" class="align-middle text-right">{{ $product->product->name }}</td>
                                <td data-label="Release date:" class="align-middle text-right">{{ $product->product->release_date }}</td>
                                <td data-label="Publisher:" class="align-middle text-right">{{ !empty($product->product->publisher) ? $product->product->publisher->name : '' }}</td>
                                <td data-label="Price:" class="align-middle text-right">{{ number_format($product->product->PriceAmount, 2, '.', '') }} €</td>
                                <td id="singlePrice{{ $product->id }}" data-label="Price:" class="align-middle text-right">{{ number_format($cartService->getSingleProductPrice($product), 2, '.', '') }} €</td>
                                <td data-label="Amount:" class="align-middle text-right">
                                    <input data-url="{{ route('order.update',$product->id) }}" class="input setquantity" type="number" name="amount" value="{{ $product->quantity }}" min="1">
                                    <br>
                                    <span id="message{{ $product->id }}" ></span>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td scope="total" colspan="7" class="text-right"><b>Total</b></td>
                            <td class="align-middle text-right totalPrice" rowspan="6" data-label="Total">{{ !empty($products) ? $cartService->getTotalCartPrice($order) : ''}} €</td>
                            <td class="align-middle text-right totalQuantity" data-label="Total quantity">{{ !empty($products) ? $cartService->getTotalCartQuantity($order) : '' }}</td>
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
            @if(!empty($backorders))
                <div class="row">
                    <table class="table table-sm">
                        <h3>BACK-ORDER</h3>
                        <thead class="thead-light">
                        <tr>
                            <th><input type="checkbox" class="selectAll" value="backorders" name="selectAll"></th>
                            <th scope="col">EAN:</th>
                            <th scope="col">Platform:</th>
                            <th scope="col">Name:</th>
                            <th scope="col">Release date:</th>
                            <th scope="col">Publisher:</th>
                            <th scope="col">Price:</th>
                            <th scope="col">Price Total:</th>
                            <th scope="col">Quantity</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($backorders as $B_product)
                            <tr>
                                <td class="align-middle"><input type="checkbox" class="backorders" name="checkbox[]" value="{{$B_product->id}}"></td>
                                <td data-label="EAN:" class="align-middle text-right">{{ $B_product->product->ean }}</td>
                                <td data-label="Platform:" class="align-middle text-right">{{ $B_product->product->platform->name }}</td>
                                <td data-label="Name:" class="align-middle text-right">{{ $B_product->product->name }}</td>
                                <td data-label="Release date:" class="align-middle text-right">{{ $B_product->product->release_date }}</td>
                                <td data-label="Publisher:" class="align-middle text-right">{{ !empty($B_product->product->publisher) ? $B_product->product->publisher->name : '' }}</td>
                                <td data-label="Price:" class="align-middle text-right">{{ number_format($B_product->product->PriceAmount, 2, '.', '') }} €</td>
                                <td id="singlePrice_B{{ $B_product->id }}" data-label="Price:" class="align-middle text-right">{{ number_format($cartService->getSingleProductPrice($B_product), 2, '.', '') }} €</td>
                                <td data-label="Amount:" class="align-middle text-right">
                                    <input data-index="B" min="1" data-url="{{ route('order.update',$B_product->id) }}" class="input setquantity_BP" type="number" name="amount" value="{{ $B_product->quantity }}">
                                    <br>
                                    <span id="message{{ $B_product->id }}" ></span>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td scope="total" colspan="7" class="text-right"><b>Total</b></td>
                            <td class="align-middle text-right" id="totalPrice_B" rowspan="6" data-label="Total">{{ !empty($backorders) ? number_format($cartService->getTotalCartPrice($backorders->first()->order), 2, '.', '') : ''}} €</td>
                            <td class="align-middle text-right" id="totalQuantity_B" data-label="Total quantity">{{ !empty($backorders) ? $cartService->getTotalCartQuantity($backorders->first()->order) : '' }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            @endif
            @if(!empty($preorders))
                <div class="row">
                    <table class="table table-sm">
                        <h3>PRE-ORDER</h3>
                        <thead class="thead-light">
                        <tr>
                            <th><input type="checkbox" class="selectAll" name="selectAll" value="preorders"></th>
                            <th scope="col">EAN:</th>
                            <th scope="col">Platform:</th>
                            <th scope="col">Name:</th>
                            <th scope="col">Release date:</th>
                            <th scope="col">Publisher:</th>
                            <th scope="col">Price:</th>
                            <th scope="col">Price Total:</th>
                            <th scope="col">Quantity</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($preorders as $P_product)
                            <tr>
                                <td class="align-middle"><input type="checkbox" class="preorders" name="checkbox[]" value="{{$P_product->id}}"></td>
                                <td data-label="EAN:" class="align-middle text-right">{{ $P_product->product->ean }}</td>
                                <td data-label="Platform:" class="align-middle text-right">{{ $P_product->product->platform->name }}</td>
                                <td data-label="Name:" class="align-middle text-right">{{ $P_product->product->name }}</td>
                                <td data-label="Release date:" class="align-middle text-right">{{ $P_product->product->release_date }}</td>
                                <td data-label="Publisher:" class="align-middle text-right">{{ !empty($P_product->product->publisher) ? $P_product->product->publisher->name : '' }}</td>
                                <td data-label="Price:" class="align-middle text-right">{{ number_format($P_product->product->PriceAmount, 2, '.', '') }} €</td>
                                <td id="singlePrice_P{{ $P_product->id }}" data-label="Price:" class="align-middle text-right">{{ number_format($cartService->getSingleProductPrice($P_product), 2, '.', '') }} €</td>
                                <td data-label="Amount:" class="align-middle text-right">
                                    <input data-index="P" min="1" data-url="{{ route('order.update',$P_product->id) }}" class="input setquantity_BP" type="number" name="amount" value="{{ $P_product->quantity }}">
                                    <br>
                                    <span id="message{{ $P_product->id }}" ></span>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td scope="total" colspan="7" class="text-right"><b>Total</b></td>
                            <td class="align-middle text-right" id="totalPrice_P" rowspan="6" data-label="Total">{{ !empty($preorders) ? number_format($cartService->getTotalCartPrice($preorders->first()->order), 2, '.', '') : ''}} €</td>
                            <td class="align-middle text-right" id="totalQuantity_P" data-label="Total quantity">{{ !empty($preorders) ? $cartService->getTotalCartQuantity($preorders->first()->order) : '' }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="pull-right">
                        @if(!empty($product))
                            <input type="hidden" name="order_id" value="{{$order->id}}">
                        @endif
                        @if(!empty($backorder))
                            <input type="hidden" name="backorder_id" value="{{$backorder->id}}">
                        @endif
                        @if(!empty($preorder))
                            <input type="hidden" name="preorder_id" value="{{$preorder->id}}">
                        @endif
                        @if(!empty($product) || !empty($backorder) || !empty($preorder))
                            <button class="btn btn-danger" type="submit">Delete</button>
                        @endif
                        <a class="btn btn-dark" href="{{ route('home') }}">Back to Shop</a>
                    </div>
                </div>
            </div>
        </form>
        <!-- Comments and attachments -->
        @if(!empty($order) || !empty($backorder) || !empty($preorder))
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('cart.confirm') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1"><h4>Comments</h4></label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="6"></textarea>
                        </div>
                        @if(!empty($product))
                            <input type="hidden" name="order_id" value="{{$order->id}}">
                        @endif
                        @if(!empty($backorder))
                            <input type="hidden" name="backorder_id" value="{{$backorder->id}}">
                        @endif
                        @if(!empty($preorder))
                            <input type="hidden" name="preorder_id" value="{{$preorder->id}}">
                        @endif
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger btn-lg btn-block" >Confirm your order</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection