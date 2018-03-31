@extends('layouts.main')
@section('content')

<div class="col-10 mt-5">
    <!-- Filters -->
        <div class="form-row align-items-center">
        <form class="form-inline" action="{{route('order.orders')}}" method="get">

            @admin
            <div class=" col-auto my-1">
                <select class="form-control" name="user_id" type="button" class="btn btn-dark btn-sm dropdown-toggle filters" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <option value="-1">User name</option>
                @foreach($users as $user)
                     <option {{($selectedUser == $user->id)?'selected="selected"':''}} value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
                </select>
            </div>
            @endadmin
            <div class=" col-auto my-1">
                <select class="form-control" name="status" type="button" class="btn btn-dark btn-sm dropdown-toggle filters" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <option value="-1">Status</option>
                    <option {{($selectedStatus == App\Order::PENDING)?'selected="selected"':''}} value="{{App\Order::PENDING}}">Pending</option>
                    <option {{($selectedStatus == App\Order::UNCONFIRMED)?'selected="selected"':''}} value="{{App\Order::UNCONFIRMED}}">Unconfirmed</option>
                    <option {{($selectedStatus == App\Order::CONFIRMED)?'selected="selected"':''}} value="{{App\Order::CONFIRMED}}">Confirmed</option>
                    <option {{($selectedStatus == App\Order::REJECTED)?'selected="selected"':''}} value="{{App\Order::REJECTED}}">Rejected</option>
                </select>
            </div>
            <div class=" col-auto my-1">
                <select class="form-control" name="type" type="button" class="btn btn-dark btn-sm dropdown-toggle filters" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <option value="-1">Type</option>
                    <option {{($selectedStatus == App\Order::ORDER)?'selected="selected"':''}} value="{{App\Order::ORDER}}">Order</option>
                    <option {{($selectedStatus == App\Order::PREORDER)?'selected="selected"':''}} value="{{App\Order::PREORDER}}">Preorder</option>
                    <option {{($selectedStatus == App\Order::BACKORDER)?'selected="selected"':''}} value="{{App\Order::BACKORDER}}">Backorder</option>
                </select>
            </div>
            <button type="submit" name="filter" class="btn btn-danger filters">Filter</button>
        </form>
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
                        <img width="20px" class="figure-img" src="images/pdf.png">
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
            <a href="{{ route('export', 'order') }}" class="btn btn-danger btn-sm export">Orders</a>
            <a href="{{ route('export', 'preorder') }}" class="btn btn-danger btn-sm export">Pre-orders</a>
            <a href="{{ route('export', 'backorder') }}" class="btn btn-danger btn-sm export">Back-orders</a>
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