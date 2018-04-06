@extends('layouts.main')

@section('content')
<div class="col-10">
    <div class="row pl-4 pr-4">
        <div class="col-12 text-center mt-5 mb-5">
            @if(session ('status') == 'success')
            <div class="alert alert-success">
                {{ session('msg') }}
            </div>
            @elseif(session('status') == 'danger')
            <div class="alert alert-danger">
                {{ session('msg') }}
            </div>
            @endif
            <h2>Special user offer</h2>
        </div>
    </div>
    <div class="row pl-4 pr-4">
        <div class="col-lg-12 col-md-12">
            <label>Filter by platform and publisher</label>
            <form action="{{ route('special.user.filter') }}" method="post" class="form-inline">
                @csrf
                <div class="input-group">
                    <select name="platform" class="custom-select" id="inputGroupSelect04">
                        <option value="0"></option>
                        @foreach($platforms as $platform)
                        <option {{$selectedPlatform == $platform->id ? 'selected="selected"' : '' }} value="{{ $platform->id }}">{{ $platform->name }}</option>
                        @endforeach
                    </select>
                    <select name="publisher" class="custom-select" id="inputGroupSelect04">
                        <option value="0"></option>
                        @foreach($publishers as $publisher)
                        <option {{$selectedPublisher == $publisher->id ? 'selected="selected"' : '' }} value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                        @endforeach
                    </select>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search" name="search">
                        <div class="input-group-append">
                            <button class="btn btn-outline-dark" type="submit" value="filter">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row pl-4 pr-4">
        <div class="col-12">
            <form action="{{ route('special.user.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 special-offers-clients-select">
                        <label>Clients</label>
                        <div class="input-group mb-3">
                            <select class="custom-select clients_select" name="client_id">
                                <option value="0"></option>
                                @foreach($clients as $client)
                                <option value="{{$client->id}}">{{$client->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pl-4 pr-4">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <h4 class="mt-4">Products list</h4>
                    </div>
                </div>
                <div class="row pt-3 pb-3">
                    <div class="col-12">
                        <input class="select-all-products-special-offers" type="checkbox" name="select_all">
                        <label class="form-check-label" for="defaultCheck1">
                            Select all
                        </label>
                    </div>
                </div>
                <div class="row ml-1">
                    @foreach($products as $product)
                    <div style="margin-right: auto" class="col-lg-6 col-md-12">
                        <input class="form-check-input gamescheckall" name="games[]" type="checkbox"
                        value="{{ $product->id }}">
                        <label class="form-check-label" for="defaultCheck1">
                            {{ $product->name }} ({{ $product->platform->name }})
                        </label>
                        <input name="specialProductPrice[{{$product->id}}]" placeholder="price" style="width: 50px; float: right;" type="number" step="any" value={{$product->base_price}}>
                    </div>
                    @endforeach
                </div>
                @if ($errors->has('games'))
                <div class="alert alert-danger" role="alert">
                    <p>{{ $errors->first('games') }}</p>
                </div>
                @endif
            </div>
        </div>

    <div class="row pl-4 pr-4">
        <div class="col-12">
            <button class="btn btn-dark btn-block mt-5" type="submit" value="submit">Submit</button>
        </div>
    </div>
</form>
</div>
</div>
@endsection