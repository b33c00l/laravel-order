@extends('layouts.main')
@section('content')
    <div class="col-10">
        <div class="row">
            <div class="col-12 text-center mt-5 mb-5">
                <h1>Special offer</h1>
                <a><img src="{{asset('storage/image/'.$special_offer->filename)}}"/></a>
            </div>
            <div class="col-12 text-center mt-5 mb-5">
                <h2>Description:</h2>
                <h3>{{$special_offer->description}}</h3>
            </div>
            <div class="col-12 text-center mt-5 mb-5">
                <h3>Expiration:</h3>
                <h4>{{$special_offer->expiration_date}}</h4>
            </div>
        </div>
    </div>
@endsection