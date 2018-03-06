@extends("layouts.app")
@section('content')
<form method="post" action="{{route('users.store')}}">

    {{csrf_field()}}
    <label>User</label><br>
    <input type="text" name="name" placeholder="name"><br>
    <input type="password" name="password" placeholder="password"><br>
    <select name="role"><br>
        <option value="user">User</option><br>
        <option value="admin">Admin</option>
    </select><br>
    <input type="number" step="0.01" name="price_coefficient" placeholder="price_coefficient"><br>
    <label>Client</label><br>
    <input type="text" name="vat_number" placeholder="vat_number"><br>
    <input type="text" name="registration_number" placeholder="registration_number"><br>
    <input type="text" name="registration_address" placeholder="registration_address"><br>
    <input type="text" name="shipping_address" placeholder="shipping_address"><br>
    <input type="email" name="email" placeholder="email"><br>
    <input type="text" name="contact_person" placeholder="contact_person"><br>
    <input type="text" name="phone_number" placeholder="phone_number"><br>
    <input type="text" name="payment_terms" placeholder="payment_terms"><br>
    <button type="submit">Submit</button>
</form>
    @endsection