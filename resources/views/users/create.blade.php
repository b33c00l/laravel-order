@extends("layouts.page")
@section('content')
<div class="col-10">
    <div class="row">
        <div class="col-12 text-center mt-5 mb-5">
            <h2>Create user</h2>
        </div>
        <div class="col-12">
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
                <div class="col-12 form-group">
                    <div class="col">
                        <button type="submit" class="btn btn-danger btn-block" >Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection