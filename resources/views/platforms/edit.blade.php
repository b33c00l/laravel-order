<form action="{{route('platforms.update', ['platform' => $platformEdit->id])}}" method="post">
    @csrf
    <div class="form-group">
        <label for="name">Name:</label>
        <br>
        <input type="text" name="name" class="form-control" placeholder="Platform name" value="{{ $platformEdit->name }}">
        <br>
        <button type="submit" class="btn btn-secondary">Submit</button>
    </div>
</form>