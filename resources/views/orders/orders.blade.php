@extends('layouts.main')
@section('content')

<div class="col-10 mt-5">
    <!-- Filters -->
    <div class="row">
        <div class="btn-group">
            <button type="button" class="btn btn-dark btn-sm dropdown-toggle filters" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                User name
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
            <button type="button" class="btn btn-dark btn-sm dropdown-toggle filters" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Status
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
            <button type="button" class="btn btn-dark btn-sm dropdown-toggle filters" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Type
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
            <button type="button" class="btn btn-danger filters">Filter</button>
        </div>
    </div>
    <!-- Order table -->
    <div class="row">
        <div class="col-md-12 table-responsive">
            <table class="table table-sm">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Order ID:</th>
                    <th scope="col">Date:</th>
                    <th scope="col">User name:</th>
                    <th scope="col">Status:</th>
                    <th scope="col">Type:</th>
                    <th scope="col">Invoice:</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)

                <tr>
                    <td data-label="Order:" class="align-middle"><a href="{{route('order.products', $order->id)}}">{{$order->id}} </a></td>
                    <td data-label="Date:" class="align-middle">{{$order->date}}</td>
                    <td data-label="User name:" class="align-middle">{{$order->user->name}}</td>
                    <td data-label="Status:" class="align-middle">{{$order->OrderStatus}}</td>
                    <td data-label="Type:" class="align-middle">{{$order->OrderType}}</td>
                    <td data-label="Invoice:" class="align-middle">
                        @if(!empty($order->invoice))
                            <a href="{{ route('order.invoice.download', $order->id) }}"><img width="20px" class="figure-img" src="images/pdf.png"></a>
                        @endif
                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <!-- Export all to Excel -->
    <div class="row export">
        <label>
            <h4>Export all to excel:</h4>
        </label>
    </div>
    <div class="row">
        <div class="btn-group" role="group" aria-label="export_buttons">
            <a href="{{ route('export', 'order') }}" class="btn btn-danger btn-sm export m-1">Orders</a>
            <a href="{{ route('export', 'preorder') }}" class="btn btn-danger btn-sm export m-1">Pre-orders</a>
            <a href="{{ route('export', 'backorder') }}" class="btn btn-danger btn-sm export m-1">Back-orders</a>
        </div>
    </div>
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