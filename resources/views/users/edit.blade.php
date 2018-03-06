@extends("layouts.app")
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 mx-auto">
                <form class="form-group" method="post" action="{{route('users.update', $user->id)}}">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                    @if(isset($client))
                        @include('users.partials.form', [
                        'name' => $user->name,
                        'price_coefficient' => $user->price_coefficient,
                        'vat_number' => $client->vat_number,
                        'registration_number' => $client->registration_number,
                        'registration_address' => $client->registration_address,
                        'shipping_address' => $client->shipping_address,
                        'email' => $client->email,
                        'contact_person' => $client->contact_person,
                        'payment_terms' => $client->payment_terms,
                        'phone' => $client->phone
                        ])
                    @else
                        @include('users.partials.form', [
                        'name' => $user->name,
                        'price_coefficient' => $user->price_coefficient,
                        'vat_number' => '',
                        'registration_number' => '',
                        'registration_address' => '',
                        'shipping_address' => '',
                        'email' => '',
                        'contact_person' => '',
                        'payment_terms' => '',
                        'phone' => ''
                        ])
                    @endif
                    <label>Disabled</label><br>
                    <input type="hidden" name="disabled" value="0">
                    <input type="checkbox" name="disabled" value="1"><br>
                    <button class="btn btn-primary" type="submit">Edit</button>
                </form>
            </div>
        </div>
    </div>
@endsection