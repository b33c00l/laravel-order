@extends('layouts.main')

@section('content')
    <div class="col-10">
        <div class="row">
            <div class="col-12 text-center mt-5 mb-5">
                <h1>Users with personal prices</h1>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Users</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($specialUsers as $specialUser)
                    <tr>
                        <td>
                            <a href="{{route('special.user.single' , [$specialUser->id])}}">{{$specialUser->name}}</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection