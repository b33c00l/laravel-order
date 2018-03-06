@extends('layouts.app')
@section('content')
	<form action="{{route('categories.store')}}" method="post">
		@csrf
		<label for="">Category name</label>
		<input type="text" name="name">
		<button type="submit">Save</button>
	</form>
	@if(!empty($errors->first('name')))
		<div class="alert alert-success" role="alert">
			{{$errors->first('name')}}
		</div>
	@endif
@endsection
