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
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($specialPrices as $specialPrice)
                        <tr>
                            <td>
                                {{$specialPrice->products->name}}
                            </td>
                            <td id="edit">
                                {{$specialPrice->amount}}
                            </td>
                            <td id="update">
                                    <input  name="price"  value="{{ $specialPrice->amount }}" class="form-control"  type="number" step="any">
                                    <button data-url="{{route ('special.user.update', ['id' => $specialPrice->id])}}" type="submit" class="btn updateSpecialPrice btn-warning">Update</button>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm editPrice">Edit price</button>
                            </td>
                            <td>
                                <button data-url="{{ route('special.user.delete', ['id' => $specialPrice->id])}}" type="submit" class="btn deleteSpecialPrice btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection