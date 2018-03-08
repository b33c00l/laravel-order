<a href="{{route('products.create')}}">Create a product</a>

<ul>
    @foreach($products as $product)
        <li>
            <a href="{{ route('products.show', [ 'id' => $product->id ]) }}">{{ $product->name }}</a>
        </li>
    @endforeach
</ul>