@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <table>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Release date</th>
                        <th>Platform</th>
                        <th>Publisher</th>
                        <th>Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->release_date }}</td>
                            <td>{{ $product->platform->name }}</td>
                            <td>{{ $product->publisher->name }}</td>
                            <td><form action="{{ route('orders.store', $product->id) }}" method="post">
                                @csrf
                                <input type="number" name="quantity">
                                <button value="submit" type="submit" class="btn btn-success">Add to basket</button>
                            </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
