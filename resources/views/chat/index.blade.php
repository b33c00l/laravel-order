@extends('layouts.main', ['title' => 'Show order chats'])

@section('content')
<div class="col-10">
    <div class="row">
        <div class="col-12 text-center mt-5 mb-5">
            <h2>Topics</h2>
        </div>
        <div class="col-12">
        <ul class="list-group">
            @foreach($chats as $chat)
            <li class="list-group-item">
                Created by : {{$chat->user->name}} on {{$chat->created_at}} <br>
                <a href="{{route('chat.show', $chat->id)}}">
                    <h3>
                        @if($chat->admin_id === null)
                        {{$chat->topic}}
                        @else
                        {{$chat->topic}}
                        @endif
                    </h3>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
</div>
</div>
@endsection