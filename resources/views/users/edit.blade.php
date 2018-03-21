@extends("layouts.page")
@section('content')
<div class="col-10">
    <div class="row">
        <div class="col-12 mt-5 mb-5 text-center">
            <h2>Edit user</h2>
        </div>
        <div class="col-12">
            <form class="form-group" method="post" action="{{route('users.update', $user->id)}}">
                {{csrf_field()}}
                {{method_field('PATCH')}}
                @if(isset($client))
                @include('users.partials.form', [
                'name' => $user->name,
                'price_coefficient' => $user->price_coefficient,
                'client_name' => $client->name,
                'vat_number' => $client->vat_number,
                'registration_number' => $client->registration_number,
                'registration_address' => $client->registration_address,
                'shipping_address' => $client->shipping_address,
                'email' => $client->email,
                'contact_person' => $client->contact_person,
                'payment_terms' => $client->payment_terms,
                'phone' => $client->phone,
                'country_id' => $user->country_id
                ])
                @else
                @include('users.partials.form', [
                'name' => $user->name,
                'price_coefficient' => $user->price_coefficient,
                'client_name' => '',
                'vat_number' => '',
                'registration_number' => '',
                'registration_address' => '',
                'shipping_address' => '',
                'email' => '',
                'contact_person' => '',
                'payment_terms' => '',
                'phone' => '',
                'country_id' => ''
                ])
                @endif
                <div class="col-12 d-flex justify-content-center user-edit-label">
                <label>Disabled</label><br>
                <input type="hidden" name="disabled" value="0">
                <input type="checkbox" name="disabled" value="1">
            </div>
                <div class="col-12 form-group">
                    <div class="col-12">
                        <button type="submit" class="btn btn-danger btn-block" >Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection