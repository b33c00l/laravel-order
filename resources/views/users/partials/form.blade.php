<label>User</label><br>
<input class="from-control" value="{{old('name', $name)}}" type="text" name="name" placeholder="name"><br>
<input class="from-control"  type="password" name="password" placeholder="password"><br>
<select class="from-control" name="role"><br>
    <option value="user">User</option><br>
    <option value="admin">Admin</option>
</select><br>
<input class="from-control" value="{{old('price_coefficient', $price_coefficient)}}" type="number" step="0.01" name="price_coefficient" placeholder="price_coefficient"><br>
<label>Client</label><br>
<input class="from-control" value="{{old('vat_number', $vat_number)}}" type="text" name="vat_number" placeholder="vat_number"><br>
<input class="from-control" value="{{old('registration_number', $registration_number)}}" type="text" name="registration_number" placeholder="registration_number"><br>
<input class="from-control" value="{{old('registration_address', $registration_address)}}" type="text" name="registration_address" placeholder="registration_address"><br>
<input class="from-control" value="{{old('shipping_address', $shipping_address)}}" type="text" name="shipping_address" placeholder="shipping_address"><br>
<input class="from-control" value="{{old('email', $email)}}" type="email" name="email" placeholder="email"><br>
<input class="from-control" value="{{old('contact_person', $contact_person)}}" type="text" name="contact_person" placeholder="contact_person"><br>
<input class="from-control" value="{{old('phone', $phone)}}" type="text" name="phone" placeholder="phone"><br>
<input class="from-control" value="{{old('payment_terms', $payment_terms)}}" type="text" name="payment_terms" placeholder="payment_terms"><br>