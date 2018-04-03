@extends('layouts.page', ['title' => 'Categories'])
@section('content')
<div class="col-10 mt-5">
	@include('layouts.partials.messages')
	<a class="btn btn-dark" href="{{route('categories.create')}}">Create new category</a>
	<div class="col-md-12 table-responsive no-gutters">
		<table class="table table-sm table_container">
			<thead class="thead-light">
				<tr>
					<th scope="col" colspan="3">Category:</th>
				</tr>
			</thead>
			<tbody>
				@foreach($categories as $category)
				<tr class="table-tr">
					<td Data-label="Publisher:" class="align-middle text-right">
						<div class="justify-content-end">
							<p>{{ $category->name }}</p>
						</div>
					</td>
					<td class="text-lg-right"><a href="{{route('categories.edit',$category->id)}}" class="btn btn-dark btn-sm">Edit</a>
					</td>
					<td class="text-lg-left">
						<form action="{{route('categories.destroy', $category->id)}}" method="post">
							@csrf
							<div class="form-group">
								<input type="hidden" name="_method" value="delete">
								<button type="submit" class="btn btn-danger btn-sm">Delete</button>
							</div>
						</form>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
</div>
@endsection