@extends("layouts.page", ['title' => 'Edit user'])
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
                    'role' => $user->role,
                    'price_coefficient' => $user->price_coefficient,
                    'client_name' => $client->name,
                    'vat_number' => $client->vat_number,
                    'registration_number' => $client->registration_number,
                    'shipping_address' => $client->shipping_address,
                    'email' => $client->email,
                    'contact_person' => $client->contact_person,
                    'payment_terms' => $client->payment_terms,
                    'phone' => $client->phone,
                    'country_id' => $user->country_id,
                    'registration_address' => $client->registration_address
                    ])
                @else
                    @include('users.partials.form', [
                    'name' => $user->name,
                    'role' => $user->role,
                    'price_coefficient' => $user->price_coefficient,
                    'client_name' => '',
                    'vat_number' => '',
                    'registration_number' => '',
                    'shipping_address' => '',
                    'email' => '',
                    'contact_person' => '',
                    'payment_terms' => '',
                    'phone' => '',
                    'country_id' => '',
                    'registration_address' => ''
                    ])
                @endif
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