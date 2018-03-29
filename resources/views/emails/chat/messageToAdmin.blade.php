<!doctype html>
<html>
<head>
</head>
<body style="">
<h1>You have received a new message</h1>
<p>Dear admin, you have received a new message!</p>
<p style="padding: 10px; background-color: gray; display: inline-block"><i>{{($msg)}}</i></p>
<br>
<a href="{{route('chat.show', $chat_id)}}">Respond to a new message here!</a>
</body>
</html>