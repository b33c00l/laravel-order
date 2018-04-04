@extends('layouts.page', ['title' => 'Edit category'])
@section('content')
<div class="col-10 mt-5">
    <form action="{{route('categories.update', $category->id)}}" method="post">
    @csrf
    <div class="form-group">
        <input type="hidden" name="_method" value="put">
        <label for="name">Category name:</label>
        <br>
        <input type="text" name="name" class="form-control" placeholder="Category name" value="{{$category->name}}">
        <br>
        <button type="submit" class="btn btn-danger">Edit</button>
    </div>
</form>
</div>
</div>
@endsection

