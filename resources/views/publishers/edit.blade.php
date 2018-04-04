@extends('layouts.page', ['title' => 'Edit publisher'])
@section('content')
<div class="col-10 mt-5">
    <form action="{{ route('publishers.update', ['id' => $publisherEdit->id])}}" method="post">
    @csrf
    <div class="form-group">
        @if ($errors->get('name'))
            @foreach($errors->get('name') as $error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
            @endforeach
        @endif
        <input type="hidden" name="_method" value="put">
        <label for="name">Publisher name:</label>
        <br>
        <input type="text" name="name" class="form-control" placeholder="Publisher name" value="{{ $publisherEdit->name }}">
        <br>
        <button type="submit" class="btn btn-danger">Edit</button>
    </div>
</form>
</div>
</div>
@endsection

