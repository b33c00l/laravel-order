<a href="{{route('countries.create')}}">Create country</a>

<ul>
    @foreach($countries as $country)
        <li>
            <a href="{{ route('countries.show', [ 'id' => $country->id ]) }}">{{ $country->name}}  {{($country->default == 1)? ' - default country' : '' }}</a>
        </li>
    @endforeach
</ul>