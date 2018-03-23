@extends('layouts.main')
@section('content')
@inject('cartService', "App\Services\CartService")
<div class="col-10 mt-5">
    <!-- Order table -->
    <div class="row">
        <h3>ORDER</h3>
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
                    <td scope="total" colspan="6" class="text-right"><b>Total</b></td>
                    <td class="align-middle text-right totalPrice" rowspan="6" data-label="Total">{{ !empty($products) ? $cartService->getTotalCartPrice($order) : ''}} €</td>
                    <td class="align-middle text-right totalQuantity" data-label="Total quantity">{{ !empty($products) ? $cartService->getTotalCartQuantity($order) : '' }}</td>
                    <td></td>
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
                @foreach($backorders as $B_product)
                    <tr>
                        <td data-label="EAN:" class="align-middle text-right">{{ $B_product->product->ean }}</td>
                        <td data-label="Platform:" class="align-middle text-right">{{ $B_product->product->platform->name }}</td>
                        <td data-label="Name:" class="align-middle text-right">{{ $B_product->product->name }}</td>
                        <td data-label="Release date:" class="align-middle text-right">{{ $B_product->product->release_date }}</td>
                        <td data-label="Publisher:" class="align-middle text-right">{{ !empty($B_product->product->publisher) ? $B_product->product->publisher->name : '' }}</td>
                        <td data-label="Price:" class="align-middle text-right">{{ number_format($B_product->product->PriceAmount, 2, '.', '') }} €</td>
                        <td id="singlePrice{{ $B_product->id }}" data-label="Price:" class="align-middle text-right">{{ number_format($cartService->getSingleProductPrice($B_product), 2, '.', '') }} €</td>
                        <td data-label="Amount:" class="align-middle text-right">
                            <input data-url="{{ route('order.update',$B_product->id) }}" class="input setquantity_BP" type="number" name="amount" max="50" value="{{ $B_product->quantity }}">
                            <br>
                            <span id="message{{ $B_product->id }}" ></span>
                        </td>
                        <td class="align-middle text-right">
                            <form action="{{route('order.product.delete', $B_product->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td scope="total" colspan="6" class="text-right"><b>Total</b></td>
                    <td class="align-middle text-right" id="totalPrice_B" rowspan="6" data-label="Total">{{ !empty($backorders) ? number_format($cartService->getTotalCartPrice($backorders->first()->order), 2, '.', '') : ''}} €</td>
                    <td class="align-middle text-right" id="totalQuantity_B" data-label="Total quantity">{{ !empty($backorders) ? $cartService->getTotalCartQuantity($backorders->first()->order) : '' }}</td>
                    <td class="total"></td>
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
                @foreach($preorders as $P_product)
                    <tr>
                        <td data-label="EAN:" class="align-middle text-right">{{ $P_product->product->ean }}</td>
                        <td data-label="Platform:" class="align-middle text-right">{{ $P_product->product->platform->name }}</td>
                        <td data-label="Name:" class="align-middle text-right">{{ $P_product->product->name }}</td>
                        <td data-label="Release date:" class="align-middle text-right">{{ $P_product->product->release_date }}</td>
                        <td data-label="Publisher:" class="align-middle text-right">{{ !empty($P_product->product->publisher) ? $P_product->product->publisher->name : '' }}</td>
                        <td data-label="Price:" class="align-middle text-right">{{ number_format($P_product->product->PriceAmount, 2, '.', '') }} €</td>
                        <td id="singlePrice{{ $P_product->id }}" data-label="Price:" class="align-middle text-right">{{ number_format($cartService->getSingleProductPrice($P_product), 2, '.', '') }} €</td>
                        <td data-label="Amount:" class="align-middle text-right">
                            <input data-url="{{ route('order.update',$P_product->id) }}" class="input setquantity_BP" type="number" name="amount" value="{{ $P_product->quantity }}">
                            <br>
                            <span id="message{{ $P_product->id }}" ></span>
                        </td>
                        <td class="align-middle text-right">
                            <form action="{{route('order.product.delete', $P_product->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td scope="total" colspan="6" class="text-right"><b>Total</b></td>
                    <td class="align-middle text-right" id="totalPrice_P" rowspan="6" data-label="Total">{{ !empty($preorders) ? number_format($cartService->getTotalCartPrice($preorders->first()->order), 2, '.', '') : ''}} €</td>
                    <td class="align-middle text-right" id="totalQuantity_P" data-label="Total quantity">{{ !empty($preorders) ? $cartService->getTotalCartQuantity($preorders->first()->order) : '' }}</td>
                    <td class="total"></td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif
	<div class="row">
		<div class="col-12">
			<div class="pull-right">
				<a class="btn btn-dark" href="{{ route('home') }}">Back to Shop</a>
			</div>
		</div>
	</div>

    <!-- Comments and attachments -->
    @if(!empty($products) || !empty($backorders) || !empty($preorders))
    <div class="row">
        <div class="col-12">
            <form action="{{ route('cart.confirm') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlTextarea1"><h4>Comments</h4></label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="6"></textarea>
                </div>
                <input type="hidden" name="order_id" value="{{!empty($products) ? $products->first()->order->id : ''}}">
                <input type="hidden" name="backorder_id" value="{{!empty($backorders) ? $backorders->first()->order->id : ''}}">
                <input type="hidden" name="preorder_id" value="{{!empty($preorders) ? $preorders->first()->order->id : ''}}">
                <div class="form-group">
                    <button type="submit" class="btn btn-danger btn-lg btn-block" >Confirm your order</button>
                </div>
             </form>
        </div>
    </div>
    @endif
</div>

@endsection