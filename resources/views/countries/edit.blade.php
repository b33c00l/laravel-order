@extends('layouts.page')
@section('content')
<div class="col-10 mt-5">
    <form action="{{route('countries.update', ['countries' => $countriesEdit->id])}}" method="post">
        @csrf
        <div class="form-group">
            @if ($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    <p>{{ $error }}</p>
                </div>
            @endforeach
            @endif
            <input type="hidden" name="_method" value="put">
            <div class="form-group no-gutters">
                <label class="col control-label">Country</label>
                <div class="col inputGroupContainer">
                    <div class="input-group">
                        <input  name="name" placeholder="Country name" value="{{ $countriesEdit->name }}" class="form-control"  type="text">
                    </div>
                </div>
            </div>
            <div class="form-group no-gutters">
                <label class="col control-label">Country representative email</label>
                <div class="col inputGroupContainer">
                    <div class="input-group">
                        <input  name="email" placeholder="email" value="{{ $countriesEdit->email }}" class="form-control"  type="email">
                    </div>
                </div>
            </div>
            <div class="form-group no-gutters">
                <label class="col control-label">Country representative phone number</label>
                <div class="col inputGroupContainer">
                    <div class="input-group">
                        <input  name="phone" placeholder="Phone number" value="{{ $countriesEdit->phone }}" class="form-control"  type="text">
                    </div>
                </div>
            </div>
            <div class="form-group no-gutters">
                    <div class="col">
                        <div class="checkbox">
                            <label>
                                <input type="radio" name="default" value="1" {{ $countriesEdit->default == 1 ? 'checked="checked"' : '' }}>Make default
                            </label>
                        </div>
                    </div>
                </div>
            <div class="form-group">
                <button type="submit" class="btn btn-danger">Update</button>
            </div>
        </div>
    </form>
</div>
</div>
@endsection

