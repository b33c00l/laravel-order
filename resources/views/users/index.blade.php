@extends('layouts.app')

@section('content')
    <div class="container">
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
@endsection