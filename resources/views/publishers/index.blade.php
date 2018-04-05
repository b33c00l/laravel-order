@extends('layouts.page', ['title' => 'Publishers'])
@section('content')
<div class="col-10 mt-5">
	@include('layouts.partials.messages')
	<a class="btn btn-dark" href="{{route('publishers.create')}}">Create new publisher</a>
	<div class="col-md-12 table-responsive no-gutters">
		<table class="table table-sm table_container">
			<thead class="thead-light">
				<tr>
					<th scope="col" colspan="3">Publisher:</th>
				</tr>
			</thead>
			<tbody>
				@foreach($publishers as $publisher)
				<tr class="table-tr">
					<td Data-label="Publisher:" class="align-middle text-right">
						<div class="justify-content-end">
							<p>{{ $publisher->name }}</p>
						</div>
					</td>
					<td class="text-lg-right"><a href="{{ route('publishers.edit', ['id' => $publisher->id])}}" class="btn btn-dark btn-sm">Edit</a>
					</td>
					<td class="text-lg-left">
						<form action="{{ route('publishers.destroy', ['id' => $publisher->id])}}" method="post">
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