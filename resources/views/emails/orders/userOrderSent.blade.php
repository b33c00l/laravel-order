<!doctype html>
<html>
<head>
</head>
<body style="">
<h1>Good choice!</h1>
@isset($orderProducts)
<h1>Order received</h1>
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
Order total: {{ $totalOrder }}
@endisset()

@isset($backOrderProducts)
    <h1>Back-order received</h1>
    @foreach($backOrderProducts as $product)
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
    Back-Order Total: {{ $totalBackOrder }}
@endisset()

@isset($preOrderProducts)
    <h1>Pre-order received</h1>
    @foreach($preOrderProducts as $product)
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
    Pre-Order Total: {{ $totalPreOrder }}
@endisset()

</body>
</html>