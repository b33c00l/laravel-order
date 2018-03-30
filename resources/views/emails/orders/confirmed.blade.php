<!doctype html>
<html>
<head>
</head>
<body style="">
<h1>{{$order->orderType}} Confirmed</h1>
<p>Congratulations! Your {{strtolower($order->orderType)}} was confirmed!</p>
<a href="{{route('order.products',$order->id)}}">View your order here!</a>
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
{{$order->orderType}} total: {{ $totalOrder }}


</body>
</html>