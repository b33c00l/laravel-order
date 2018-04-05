@extends('layouts.main')

@section('content')
    <div class="col-10">
        <div class="row">
            <div class="col-12 text-center mt-5 mb-5">

                <table class="table">
                    <thead>
                    <tr>
                        <th>Products</th>
                        <th>Prices</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($specialPrices as $specialPrice)
                        <tr>
                            <td>
                                {{$specialPrice->products->name}}
                            </td>
                            <td>
                                {{$specialPrice->amount}}
                            </td>
                            @admin
                                <td class="align-middle text-right text-lg-center">
                                    <button class="btn btn-danger btn-sm delete">Delete</button>
                                </td>
                            @endadmin
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection