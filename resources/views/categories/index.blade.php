@extends('layouts.app')
@section('content')
	@if(session('status'))
		<div class="alert alert-success">{{session('status')}}</div>
	@endif
	<a role="button" class="btn btn-primary" href="{{route('categories.create')}}">Create new category</a>
	<table>
		<thead>
			<tr>
				<th>#</th>
				<th>id</th>
				<th>Category name</th>
				<th>Action</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($categories as $category)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{$category->id}}</td>
					<td>{{$category->name}}</td>
					<td><a role="button" class="btn btn-success" href="{{route('categories.edit',$category->id)}}">Edit</a></td>
					<td>
						<form action="{{route('categories.destroy', $category->id)}}" method="post">@csrf @method('DELETE') <button type="submit" class="btn btn-danger" >Delete</button></form>
					</td>
				</tr>
			@endforeach
		</tbody>

	</table>
	<a role="button" class="btn btn-primary" href="{{'categories.create'}}">Create new category</a>
@endsection