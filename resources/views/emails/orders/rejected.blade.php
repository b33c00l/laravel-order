<!doctype html>
<html>
<head>
</head>
<body style="">
<h1>{{$order->orderType}} Rejected</h1>

<a href="{{route('order.products',$order->id)}}">View your {{strtolower($order->orderType)}} here!</a>
<br>
<hr>
@foreach($orderProducts as $product)
    EAN: {{$product->product->ean}}
    <br>
    Product name: {{ $product->product->name }}
    <br>
    Platform name: {{ $product->product->platform->name }}
    <br>
    Publisher name: {{ $product->product->publisher->name }}
    <br>
    Quantity: {{ $product->quantity }}
    <br>
    Price: {{ $product->price }}
    <br>
    <hr>
@endforeach

</body>
</html>