@extends('layouts.main')
@section('content')

<div class="col-10 mt-5">
    <!-- Filters -->
    <div class="row">
        <div class="btn-group col-10">
            <button type="button" class="btn btn-dark btn-sm dropdown-toggle filters mr-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                User name
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
            <button type="button" class="btn btn-dark btn-sm dropdown-toggle filters mr-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Status
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>
            <button type="button" class="btn btn-dark btn-sm dropdown-toggle filters mr-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                    <td data-label="Order:" class="align-middle text-right text-lg-center"><a href="{{route('order.products', $order->id)}}">{{$order->id}} </a></td>
                    <td data-label="Date:" class="align-middle text-right text-lg-center">{{$order->date}}</td>
                    <td data-label="User name:" class="align-middle text-right text-lg-center">{{$order->user->name}}</td>
                    <td data-label="Status:" class="align-middle text-right text-lg-center">{{$order->OrderStatus}}</td>
                    <td data-label="Type:" class="align-middle text-right text-lg-center">{{$order->OrderType}}</td>
                    <td data-label="Invoice:" class="align-middle text-right text-lg-center">
                        @if(!empty($order->invoice))
                            <a href="{{ route('order.invoice.download', $order->id) }}"><img width="20px" class="figure-img text-right text-lg-center" src="images/pdf.png"></a>
                        @endif
                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <!-- Export all to Excel -->
    
    <div class="row">
        <div class="col-10">
            <label>
                <h4>Export all to excel:</h4>
            </label> 
        </div>
        <div class="btn-group col-10" role="group" aria-label="export_buttons">
            <a href="{{ route('export', 'order') }}" class="btn btn-danger btn-sm export mr-1">Orders</a>
            <a href="{{ route('export', 'preorder') }}" class="btn btn-danger btn-sm export mr-1">Pre-orders</a>
            <a href="{{ route('export', 'backorder') }}" class="btn btn-danger btn-sm export mr-1">Back-orders</a>
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
</div>
@endsection