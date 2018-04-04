@extends('layouts.main')
@section('content')
    <div class="col-10 mt-5">
        <!-- Order table -->
        <div class="row">
            <div class="col-md-12 table-responsive">
                @if($orders->count() > 0)
                <table class="table table-sm">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Order ID:</th>
                        <th scope="col">Date:</th>
                        <th scope="col">User name:</th>
                        <th scope="col">Status:</th>
                        <th scope="col">Type:</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td data-label="Order:" class="align-middle text-right text-lg-center"><a
                                        href="{{route('cart.preorder', $order->id)}}">{{$order->id}} </a></td>
                            <td data-label="Date:" class="align-middle text-right text-lg-center">{{$order->date}}</td>
                            <td data-label="User name:"
                                class="align-middle text-right text-lg-center">{{$order->user->name}}</td>
                            <td data-label="Status:"
                                class="align-middle text-right text-lg-center">{{$order->OrderStatus}}</td>
                            <td data-label="Type:"
                                class="align-middle text-right text-lg-center">{{$order->OrderType}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
        </div>
        <!-- Export all to Excel -->
        <!-- Pagination -->
        <div id="pagination" class="row justify-content-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    {{ $orders->links() }}
                </ul>
            </nav>
        </div>
    </div>
@endsection