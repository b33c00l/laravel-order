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
                        <th>Prices</th>
                        <th>Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($errors->first()))
                    {{ $errors->first() }}
                    @endif
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->release_date }}</td>
                            <td>{{ $product->platform->name }}</td>
                            <td>{{ $product->publisher->name }}</td>
                            <td>{{ $product->PriceAmount }}</td>
                            <td>
                                <input class="input" type="number" id="value{{ $product->id }}" name="amount">
                                <br>
                                <span style="display: none; color: green" id="messenge{{ $product->id }}" ></span>
                            </td>
                            <td><button class="btn btn-success" onclick="addIntoCart({{ $product->id }})">Add to basket</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
