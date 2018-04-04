@extends('layouts.page')
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
                            <td data-label="EAN:"
                                class="align-middle text-right text-lg-center">{{$product->product->ean}}</td>
                            <td data-label="Platform:"
                                class="align-middle text-right text-lg-center">{{$product->product->platform->name}}</td>
                            <td data-label="Name:"
                                class="align-middle text-right text-lg-center">{{$product->product->name}}</td>
                            <td data-label="Release date:"
                                class="align-middle text-right text-lg-center">{{$product->product->release_date}}</td>
                            <td data-label="Publisher:"
                                class="align-middle text-right text-lg-center">{{ $product->product->has('publisher') ? $product->product->publisher->name : '-'}}</td>
                            <td data-label="Price:" class="align-middle text-right text-lg-center">
                                @admin
                                <input data-url="{{ route('order.update', $product->id) }}"
                                       class="input updateP text-right text-lg-center" type="number"
                                       value="{{ $product->price }}" name="amount"> €
                                <span style="display: none; color: green" class="align-middle text-right text-lg-center"
                                      id="Pmessage{{ $product->id }}"></span>
                                @else
                                    {{ number_format($product->product->priceamount, 2, '.', '')}} €
                                    @endadmin
                            </td>
                            <td data-label="Price Total:" class="align-middle text-right text-lg-center"
                                id="singlePrice{{ $product->id }}">{{ number_format($cartService->getSingleProductPrice($product), 2, '.', '')}}
                                €
                            </td>
                            <td data-label="Amount:" class="align-middle text-right text-lg-center">
                                @admin
                                <input data-url="{{ route('order.update', $product->id) }}"
                                       class="input updateQ align-middle text-right text-lg-center" type="number"
                                       value="{{$product->quantity}}" name="amount">
                                <br>
                                <span style="display: none; color: red" class="align-middle"
                                      id="Qmessage{{ $product->id }}"></span>
                                @else
                                    {{ $product->quantity}}
                                    @endadmin
                            </td>
                            @admin
                            <td class="align-middle text-right text-lg-center">
                                    <button class="btn btn-danger btn-sm delete" data-html="{{ route('order.orders') }}" data-url="{{ route('order.product.delete', $product->id) }}">Delete</button>
                            </td>
                            @endadmin
                        </tr>
                    @endforeach
                    <tr>
                        <td class="total text-right text-lg-center" colspan="6" scope="Total"><b>Total</b></td>
                        <td data-label="Total" class="text-right text-lg-center"
                            id="totalPrice">{{!empty($products)?number_format($cartService->getTotalCartPrice($order), 2,'.',''):""}}
                            €
                        </td>
                        <td data-label="Total quantity" class="text-right text-lg-center"
                            id="totalQuantity">{{!empty($products)?$cartService->getTotalCartQuantity($order):""}}</td>
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
                <div class="col-lg-6 col-12">
                    <div class="form-group">
                        <label for="invoice"><h4>Invoice</h4></label>
                        <input class="form-control" id="invoice" type="file" name="invoice">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <input type="submit" name="action" role="button" class="btn btn-dark btn-block" value="Confirm">
                </div>
                <div class="col-6">
                    <input type="submit" name="action" role="button" class="btn btn-danger btn-block" value="Reject">
                </div>
            </div>
        </form>
        @endadmin
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
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
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
            @elseif ($chat->isActive() && ($chat->admin_id === Auth::id() || $chat->admin_id === null || $order->user_id === Auth::id()))
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
@endsection