@extends("layouts.app")
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 mx-auto">
                <form class="form-group" method="post" action="{{route('users.store')}}">
                    {{csrf_field()}}
                    @include('users.partials.form', [
                            'name' => "",
                        'price_coefficient' => "",
                        'vat_number' => "",
                        'registration_number' => "",
                        'registration_address' => "",
                        'shipping_address' => "",
                        'email' => "",
                        'contact_person' => "",
                        'payment_terms' => "",
                        'phone' =>"",
                        ])
                    <button class="btn btn-primary" type="submit">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection