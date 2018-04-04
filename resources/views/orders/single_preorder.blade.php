@extends('layouts.page')
@section('content')
    @inject('cartService', "App\Services\CartService")
    <div class="col-10 mt-5">
        <!-- Order table -->
        @if(!empty($preorders))
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-sm">
                        <h3>PRE-ORDER</h3>
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">EAN:</th>
                            <th scope="col">Platform:</th>
                            <th scope="col">Name:</th>
                            <th scope="col">Release date:</th>
                            <th scope="col" class="preorders">Deadline:</th>
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
                                <td data-label="EAN:" class="align-middle text-right text-lg-center">{{ $P_product->product->ean }}</td>
                                <td data-label="Platform:" class="align-middle text-right text-lg-center">{{ $P_product->product->platform->name }}</td>
                                <td data-label="Name:" class="align-middle text-right text-lg-center">{{ $P_product->product->name }}</td>
                                <td data-label="Release date:" class="align-middle text-right text-lg-center">{{ $P_product->product->release_date }}</td>
                                <td Data-label="Deadline:" class="align-middle text-right text-lg-center">
                                    @if( $P_product->product->deadline != null)
                                        {{ $P_product->product->deadline}}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td data-label="Publisher:" class="align-middle text-right text-lg-center">{{ !empty($P_product->product->publisher) ? $P_product->product->publisher->name : '' }}</td>
                                <td data-label="Price:" class="align-middle text-right text-lg-center">{{ number_format($P_product->product->PriceAmount, 2, '.', '') }} €</td>
                                <td id="singlePrice_P{{ $P_product->id }}" data-label="Price:" class="align-middle text-right text-lg-center">{{ number_format($cartService->getSingleProductPrice($P_product), 2, '.', '') }} €</td>
                                @if($P_product->product->preorder === \App\Product::DISABLED)
                                    <td data-label="Quantity:" class="align-middle text-right text-lg-center">{{ $P_product->quantity }}</td>
                                @else
                                    <td data-label="Quantity:" class="align-middle text-right text-lg-center">
                                        <input data-index="P" min="1" data-url="{{ route('order.update',$P_product->id) }}" class="input setquantity_BP text-right" type="number" name="amount" value="{{ $P_product->quantity }}">
                                        <br>
                                        <span id="message{{ $P_product->id }}" ></span>
                                    </td>
                                @endif
                                <td class="align-middle text-right text-lg-center">
                                    @if($P_product->product->preorder !== \App\Product::DISABLED)
                                    <button class="btn btn-danger btn-sm delete" data-html="{{ route('order.index') }}" data-url="{{ route('order.product.delete', $P_product->id) }}">Delete</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td scope="total" colspan="7" class="text-right"><b>Total</b></td>
                            <td class="align-middle text-right text-lg-center" id="totalPrice_P" rowspan="6" data-label="Total">{{ !empty($preorders) ? number_format($cartService->getTotalCartPrice($preorders->first()->order), 2, '.', '') : ''}} €</td>
                            <td class="align-middle text-right text-lg-center" id="totalQuantity_P" data-label="Total quantity">{{ !empty($preorders) ? $cartService->getTotalCartQuantity($preorders->first()->order) : '' }}</td>
                            <td scope="total"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        <div>
            @if(!empty($preorder))
                <input type="hidden" name="preorder_id" value="{{$preorder->id}}">
            @endif
            @if(!empty($preorder))
                <div class="row mb-2">
                    <div class="col-12">
                        <a class="btn btn-dark btn-block" href="{{ route('home') }}">Back to Shop</a>
                    </div>
                </div>
            @else
                <h3 class="text-center">Your cart is empty</h3>
                <a class="btn btn-dark btn-block" href="{{ route('home') }}">Back to Shop</a>
            @endif
        </div>
        <!-- Comments and attachments -->
        <div class="container">
            <div class="row">
                <div class="col-sm-8 mx-auto">
                    @if($chat !== null)
                        <h4>This topic is related to <a href="#">order nr. {{ $chat->order->id }}</a></h4>
                        <ul class="list-group">
                            @foreach($chat->messages as $chat->message)
                                <li class="list-group-item">
                                    {{$chat->message->user->name}} on {{$chat->message->created_at}} <br>
                                    {{$chat->message->message}}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            @if($chat == null)
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 mx-auto">
                            <form method="post" action="{{ route('chat.store') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" name="order_id" value="{{ $preorder->id }}">
                                </div>
                                <div class="form-group">
                                    <label>Topic</label>
                                    <input type="text" class="form-control" name="topic" placeholder="Enter topic">
                                    @include('chat.partials.error', ['name' => 'topic'])
                                </div>
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea class="form-control" rows="6" type="text" name="message"
                                              placeholder="Enter message"></textarea>
                                    @include('chat.partials.error', ['name' => 'message'])
                                </div>
                                <button type="submit" class="btn btn-primary">Create topic</button>
                            </form>
                        </div>
                    </div>
                </div>
            @elseif ($chat->isActive() && ($chat->admin_id === Auth::id() || $chat->admin_id === null || $preorder->user_id === Auth::id()))
                <div class="row">
                    <div class="col-sm-8 mx-auto">
                        <form method="post" action="{{ route('chat.store.message') }}">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea class="form-control" rows="6" type="text" name="message"
                                          placeholder="Enter message"></textarea>
                                @include('chat.partials.error', ['name' => 'message'])
                            </div>
                            <button type="submit" class="btn btn-primary">Send message</button>
                        </form>
                    </div>
                </div>
            @endif
            @if ($chat !== null)
                <div class="row">
                    <div class="col-sm-8 mx-auto">
                        @if (Auth::user()->role == "admin" && $chat->isActive())
                            <form method="post" action="{{ route('chat.disable') }}">
                                @csrf
                                {{method_field('PATCH')}}
                                <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                                <button class="btn btn-danger mt-3" type="submit">Deactivate chat</button>
                            </form>
                        @elseif (!$chat->isActive())
                            <h3 class="text-danger">Chat is deactivated!</h3>
                            <form method="post" action="{{ route('chat.enable') }}">
                                @csrf
                                {{method_field('PATCH')}}
                                <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                                <button class="btn btn-success mt-3" type="submit">Activate chat</button>
                            </form>
                        @endif
                    </div>
                </div>
        </div>
        @endif
    </div>
    </div>
@endsection