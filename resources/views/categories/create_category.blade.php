@extends('layouts.page')
@section('content')
<div class="col-10 mt-5">
	<form action="{{route('categories.store')}}" method="post">
		@csrf
		<div class="form-group">
			@if ($errors->get('name'))
				@foreach($errors->get('name') as $error)
					<div class="alert alert-danger" role="alert">
						{{ $error }}
					</div>
				@endforeach
			@endif
			<div class="form-group no-gutters">
				<label class="col control-label">Category name</label>
				<div class="col inputGroupContainer">
					<div class="input-group">
						<input  name="name" placeholder="Category name" value="{{ old('name') }}" class="form-control"  type="text">
					</div>
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-danger">Create</button>
			</div>
		</div>
	</form>
</div>
</div>
@endsection