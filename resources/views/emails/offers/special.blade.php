@inject('pricingService', 'App\Services\PricingService')
<!doctype html>
<html>
<head>
</head>
<body style="">
<h1>Special Offer</h1>
<p>You got a special offer!</p>
<p>
    Description: {{ $description }}
</p>
<table style="width:300px">
    <tr>
        <th>Game</th>
        <th>Price</th>
    </tr>
    @foreach($products as $product)
    <tr>
        <td>{{ $product->name }}</td>
        <td>{{ $pricingService->getPrice($user,$product) }}</td>
    </tr>
    @endforeach
</table>
<p>
    Expiration date: {{ $expiration_date }}
</p>
</body>
</html>