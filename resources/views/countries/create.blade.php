<form action="{{route('countries.store')}}" method="post">
    @csrf
    <div class="form-group">
        @if ($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    <p>{{ $error }}</p>
                </div>
            @endforeach
        @endif
        <label for="name">Name:</label>
        <br>
        <input type="text" name="name" class="form-control" placeholder="Country name" value="{{old('name')}}">
        <br><br>
        <label for="email">Email:</label>
        <br>
        <input type="text" name="email" class="form-control" placeholder="Email" value="{{old('email')}}">
        <br><br>
        <label for="phone">Phone:</label>
        <br>
        <input type="text" name="phone" class="form-control" placeholder="Phone number" value="{{old('phone')}}">
        <br>
        <input type="checkbox" name="default" class="form-control" value="1">This country will be default
        <br>
        <button type="submit" class="btn btn-secondary">Submit</button>
    </div>
</form>