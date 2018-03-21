@extends('layouts.page')

@section('content')
<div class="col-10">
    <div class="row">
        <div class="col-12 mt-5 mb-5 text-center">
            <h2>Users list</h2>
        </div>
    </div>
        <div class="row">
            <div class="col-12">
                <ul class="list-group">
                    @foreach($users as $user)
                    <li class="list-group-item"><a href="{{ route('users.edit', $user->id) }}">{{ $user->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
    @endsection