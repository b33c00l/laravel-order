<!doctype html>
<html>
<head>
</head>
<body style="">
<h1>You have received a new message</h1>
<p>Dear {{$clientName}}, you have received a new message!</p>
<p>{{$msg}}</p>
<a href="{{route('chat.show', $chat_id)}}">Respond to your new message here!</a>
</body>
</html>