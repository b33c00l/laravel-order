<a href="{{route('products.create')}}">Create a product</a>

<ul>
    @foreach($products as $product)
        <li>
            <a href="{{ route('products.show', [ 'id' => $product->id ]) }}">{{ $product->name }}</a>
            <br>
            <img src="{{ $product->featured_image_url }}">
        </li>
    @endforeach
</ul>