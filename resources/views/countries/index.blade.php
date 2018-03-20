<a href="{{route('countries.create')}}">Create country</a>

<ul>
    @foreach($countries as $country)
        <li>
            <a href="{{ route('countries.show', [ 'id' => $country->id ]) }}">{{ $country->name }}</a>
        </li>
    @endforeach
</ul>