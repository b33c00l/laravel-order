<!doctype html>
<html>
<head>
</head>
<body style="">
<h1>Order received</h1>
<p>Good choice!</p>
@foreach($orderProducts as $orderProduct)
    EAN: {{$orderProduct->product->ean}}
    <br>
    Product name: {{ $orderProduct->product->name }}
    <br>
    Platform name: {{ $orderProduct->product->platform->name }}
    <br>
    Publisher name: {{ $orderProduct->product->publisher->name }}
    <br>
    Quantity: {{ $orderProduct->quantity }}
    <br>
    Price: {{ $orderProduct->price }}
    <br>
    <hr>
@endforeach
Total: {{ $total }}

</body>
</html>