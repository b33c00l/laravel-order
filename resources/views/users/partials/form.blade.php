<label>User</label>
<input class="form-control" value="{{old('name', $name)}}" type="text" name="name" placeholder="name">
@include('users.partials.error', ['name' => 'name'])
<input class="form-control"  type="password" name="password" placeholder="password">
@include('users.partials.error', ['name' => 'password'])
<select class="form-control" name="role">
    <option value="user">User</option>
    <option value="admin">Admin</option>
</select><br>
@include('users.partials.error', ['name' => 'role'])
<input class="form-control" value="{{old('price_coefficient', $price_coefficient)}}" type="number" step="0.01" name="price_coefficient" placeholder="price_coefficient">
@include('users.partials.error', ['name' => 'price_coefficient'])
<label>Client</label>
<input class="form-control" value="{{old('vat_number', $vat_number)}}" type="text" name="vat_number" placeholder="vat_number">
@include('users.partials.error', ['name' => 'vat_number'])
<input class="form-control" value="{{old('registration_number', $registration_number)}}" type="text" name="registration_number" placeholder="registration_number">
@include('users.partials.error', ['name' => 'registration_number'])
<input class="form-control" value="{{old('registration_address', $registration_address)}}" type="text" name="registration_address" placeholder="registration_address">
@include('users.partials.error', ['name' => 'registration_address'])
<input class="form-control" value="{{old('shipping_address', $shipping_address)}}" type="text" name="shipping_address" placeholder="shipping_address">
@include('users.partials.error', ['name' => 'shipping_address'])
<input class="form-control" value="{{old('email', $email)}}" type="email" name="email" placeholder="email">
@include('users.partials.error', ['name' => 'email'])
<input class="form-control" value="{{old('contact_person', $contact_person)}}" type="text" name="contact_person" placeholder="contact_person">
@include('users.partials.error', ['name' => 'contact_person'])
<input class="form-control" value="{{old('phone', $phone)}}" type="text" name="phone" placeholder="phone">
@include('users.partials.error', ['name' => 'phone'])
<input class="form-control" value="{{old('payment_terms', $payment_terms)}}" type="text" name="payment_terms" placeholder="payment_terms">
@include('users.partials.error', ['name' => 'payment_terms'])