@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-8 mx-auto">
                <h2>{{ $chat->topic }}</h2>
                @if($chat->order !== null)
                    <h4>This topic is related to <a href="#">order nr. {{ $chat->order->id }}</a></h4>
                @endif
                <ul class="list-group">
                    @foreach($messages as $message)
                        <li class="list-group-item">
                            {{$message->user->name}} on {{$message->created_at}} <br>
                            {{$message->message}}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @if ($chat->status == \App\Chat::ACTIVE && ($chat->admin_id === Auth::id() || $chat->admin_id === null || $chat->user_id === Auth::id()))
            <div class="row">
                <div class="col-sm-8 mx-auto">
                    <form method="post" action="{{ route('chat.store.message') }}">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control" rows="6" type="text" name="message" placeholder="Enter message"></textarea>
                            @include('chat.partials.error', ['name' => 'message'])
                        </div>
                        <button type="submit" class="btn btn-primary">Send message</button>
                    </form>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-sm-8 mx-auto">
                @if (Auth::user()->role == "admin" && $chat->status === 1)
                    <form method="post" action="{{ route('chat.disable') }}">
                        @csrf
                        {{method_field('PATCH')}}
                        <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                        <button class="btn btn-danger mt-3" type="submit">Deactivate chat</button>
                    </form>
                @elseif ($chat->status === \App\Chat::INACTIVE)
                    <h3 class="text-danger">Chat is deactivated!</h3>
                    <form method="post" action="{{ route('chat.enable') }}">
                        @csrf
                        {{method_field('PATCH')}}
                        <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                        <button class="btn btn-success mt-3" type="submit">Activate chat</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection