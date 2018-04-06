<a href="{{ route('products.create') }}">Create a product</a>
<form action="{{ route('home') }}" method="GET">
    @csrf
    @if (isset($query))
    <input type="text" name="name" value="{{ old('name', $query) }}">
        @else
        <input type="text" name="name" value="{{ old('name') }}">
    @endif
    <button type="submit">Search!</button>
</form>
<ul>
    @forelse($products as $product)
        <li>
            <a href="{{ route('products.show', [ 'id' => $product->id ]) }}">{{ $product->name }}</a>
            <br>
            <img src="{{ $product->featured_image_url }}">
        </li>
        @empty
        <h2>No products found</h2>
    @endforelse
</ul>