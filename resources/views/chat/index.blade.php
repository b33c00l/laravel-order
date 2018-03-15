@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-8 mx-auto"><h1>Topics</h1>
                <ul class="list-group">
                    @foreach($chats as $chat)
                        <li class="list-group-item">
                            Created by : {{$chat->user->name}} on {{$chat->created_at}} <br>
                            <a href="{{route('chat.show', $chat->id)}}">
                                <h3>
                                    @if($chat->admin_id === null)
                                        <b class="text-success">{{$chat->topic}}</b>
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
@endsection