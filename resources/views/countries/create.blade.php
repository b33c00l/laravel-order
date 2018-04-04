@extends('layouts.page')
@section('content')
<div class="col-10 mt-5">
    <form action="{{ route('countries.store') }}" method="post">
        @csrf
        <div class="form-group">
            @if ($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    <p>{{ $error }}</p>
                </div>
            @endforeach
            @endif
            <div class="form-group no-gutters">
                <label class="col control-label">Country</label>
                <div class="col inputGroupContainer">
                    <div class="input-group">
                        <input  name="name" placeholder="Country name" value="{{ old('name') }}" class="form-control"  type="text">
                    </div>
                </div>
            </div>
            <div class="form-group no-gutters">
                <label class="col control-label">Email</label>
                <div class="col inputGroupContainer">
                    <div class="input-group">
                        <input  name="email" placeholder="email" value="{{ old('email') }}" class="form-control"  type="email">
                    </div>
                </div>
            </div>
            <div class="form-group no-gutters">
                <label class="col control-label">Phone number</label>
                <div class="col inputGroupContainer">
                    <div class="input-group">
                        <input  name="phone" placeholder="Phone number" value="{{ old('phone') }}" class="form-control"  type="text">
                    </div>
                </div>
            </div>
            <div class="form-group no-gutters"
                    <div class="col">
                        <div class="checkbox">
                            <label>
                                <input type="radio" name="default" value="1" />Make default
                            </label>
                        </div>
                    </div>
                </div>
            <div class="form-group">
                <button type="submit" class="btn btn-danger">Create</button>
            </div>
        </div>
    </form>
</div>
</div>
@endsection

