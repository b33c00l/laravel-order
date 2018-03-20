<form action="{{route('countries.store')}}" method="post">
    @csrf
    <div class="form-group">
        @if ($errors->get('name'))
            @foreach($errors->get('name') as $error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
            @endforeach
        @endif
        <label for="name">Name:</label>
        <br>
        <input type="text" name="name" class="form-control" placeholder="Country name" value="{{old('name')}}">
        <br>
        <label for="email">Email:</label>
        <br>
        <input type="text" name="email" class="form-control" placeholder="Email" value="{{old('email')}}">
        <br>
        <label for="phone">Phone:</label>
        <br>
        <input type="text" name="phone" class="form-control" placeholder="Phone number" value="{{old('phone')}}">
        <br>
        <button type="submit" class="btn btn-secondary">Submit</button>
    </div>
</form>