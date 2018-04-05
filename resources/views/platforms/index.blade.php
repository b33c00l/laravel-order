@extends('layouts.page', ['title' => 'Platforms'])
@section('content')
<div class="col-10 mt-5">
	@include('layouts.partials.messages')
	<a class="btn btn-dark" href="{{route('platforms.create')}}">Create new platform</a>
	<div class="col-md-12 table-responsive no-gutters">
		<table class="table table-sm table_container">
			<thead class="thead-light">
				<tr>
					<th scope="col" colspan="3">Platform:</th>
				</tr>
			</thead>
			<tbody>
				@foreach($platforms as $platform)
				<tr class="table-tr">
					<td Data-label="Platform:" class="align-middle text-right">
						<div class="justify-content-end">
							<p>{{ $platform->name }}</p>
						</div>
					</td>
					<td class="text-lg-right"><a href="{{ route('platforms.edit', ['id' => $platform->id])}}" class="btn btn-dark btn-sm">Edit</a>
					</td>
					<td class="text-lg-left">
						<form action="{{ route('platforms.destroy', ['id' => $platform->id])}}" method="post">
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