{{--<a href="{{ route('publishers.create')}}">Create a publisher</a>--}}

<ul>
    @foreach($images as $image)
        <li>
            <a href="{{ route('images.show', [ 'id' => $image->id ]) }}">{{ $image->product->name }} </a>
            <br>
            <img src="{{ URL::asset('/storage/image/' . $image->filename) }}">
        </li>
    @endforeach
</ul>