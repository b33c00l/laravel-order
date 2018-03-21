<div class="row">
	<div class="col-md-6">
<div class="form-group">
			<label class="col control-label">Role</label>
			<div class="col inputGroupContainer">
				<div class="input-group">
			<select name="role" class="custom-select" id="inputGroupSelect01">
				<option selected>Choose...</option>
				<option value="admin">Admin</option>
				<option value="user">User</option>
			</select>
		</div>
	</div>
		</div>
		<div class="form-group">
			<label class="col control-label">User name</label>
			<div class="col inputGroupContainer">
				<div class="input-group">
					<input  name="name" placeholder="User name" class="form-control"  type="text" value="{{old('name', $name)}}">
					</div>
					@include('users.partials.error', ['name' => 'name'])
			</div>
		</div>
		<div class="form-group">
			<label class="col control-label">E-mail</label>
			<div class="col inputGroupContainer">
				<div class="input-group">
					<input  name="email" placeholder="E-mail" class="form-control"  type="email" value="{{old('email', $email)}}">
					</div>
					@include('users.partials.error', ['name' => 'email'])
			</div>
		</div>
		<div class="form-group">
			<label class="col control-label">Password</label>
			<div class="col inputGroupContainer">
				<div class="input-group">
					<input  name="password" placeholder="Password" class="form-control"  type="password">
					</div>
					@include('users.partials.error', ['name' => 'password'])
			</div>
		</div>
		<div class="form-group">
			<label class="col control-label">VAT number</label>
			<div class="col inputGroupContainer">
				<div class="input-group">
					<input  name="vat_number" placeholder="VAT number" class="form-control"  type="text" value="{{old('vat_number', $vat_number)}}">
					</div>
					@include('users.partials.error', ['name' => 'vat_number'])
			</div>
		</div>
		<div class="form-group">
			<label class="col control-label">Registration number</label>
			<div class="col inputGroupContainer">
				<div class="input-group">
					<input  name="registration_number" placeholder="Registration number" class="form-control"  type="text" value="{{old('registration_number', $registration_number)}}">
					</div>
					@include('users.partials.error', ['name' => 'registration_number'])
			</div>
		</div>
		<div class="form-group">
			<label class="col control-label">Payment terms</label>
			<div class="col inputGroupContainer">
				<div class="input-group">
					<input  name="payment_terms" placeholder="Payment terms" class="form-control"  type="text">
					</div>
					@include('users.partials.error', ['name' => 'payment_terms'])
			</div>
		</div>
		<div class="form-group">
			<label class="col control-label">Country</label>
			<div class="col inputGroupContainer">
				<div class="input-group">
					<select name="country_id" class="custom-select">
						@if (!isset($country_id))
							<option disabled selected></option>
							@foreach($countries as $country)
								<option value="{{ $country->id }}">{{ $country->name }}</option>
							@endforeach
						@else
							<option selected value="{{$country_id}}">{{$user->country->name}}</option>
							@foreach($countries as $country)
								@if($country->id != $country_id)
									<option value="{{ $country->id }}">{{ $country->name }}</option>
								@endif
							@endforeach
						@endif
					</select>
				</div>
				@include('users.partials.error', ['name' => 'country_id'])
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="col control-label">Contact person</label>
			<div class="col inputGroupContainer">
				<div class="input-group">
					<input  name="contact_person" placeholder="Contact person" class="form-control"  type="text">
					</div>
					@include('users.partials.error', ['name' => 'contact_person'])
			</div>
		</div>
		<div class="form-group">
			<label class="col control-label">Client name</label>
			<div class="col inputGroupContainer">
				<div class="input-group">
					<input  name="client_name" placeholder="Client name" class="form-control"  type="text">
				</div>
				@include('users.partials.error', ['name' => 'client_name'])
			</div>
		</div>
		<div class="form-group">
			<label class="col control-label">Phone number</label>
			<div class="col inputGroupContainer">
				<div class="input-group">
					<input  name="phone" placeholder="Phone number" class="form-control"  type="text">
					</div>
					@include('users.partials.error', ['name' => 'phone'])
			</div>
		</div>
		<div class="form-group">
			<label class="col control-label">Price coefficient</label>
			<div class="col inputGroupContainer">
				<div class="input-group">
					<input  name="price_coefficient" placeholder="Price coefficient" class="form-control"  type="text" value="{{old('price_coefficient', $price_coefficient)}}">
					</div>
					@include('users.partials.error', ['name' => 'price_coefficient'])
			</div>
		</div>
		<div class="form-group">
			<label class="col control-label">Company address</label>
			<div class="col inputGroupContainer">
				<div class="input-group">
					<textarea class="form-control" name="registration_address" placeholder="Company address" rows="5"></textarea>
				</div>
					@include('users.partials.error', ['name' => 'registration_address'])
			</div>
		</div>
		<div class="form-group">
			<label class="col control-label">Shipping address</label>
			<div class="col inputGroupContainer">
				<div class="input-group">
					<textarea class="form-control" name="shipping_address" placeholder="Shipping address" rows="5">{{old('shipping_address', $shipping_address)}}</textarea>
				</div>
				@include('users.partials.error', ['name' => 'shipping_address'])
			</div>
		</div>
	</div>
</div>
