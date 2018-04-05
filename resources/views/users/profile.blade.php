@extends("layouts.page", ['title' => 'My profile'])
@section('content')
    <div class="col-10">
        <div class="row">
            <div class="col-12 mt-5 mb-5 text-center">
                @if (Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        <strong>Success:</strong> {{Session::get('success')}}
                    </div>
                @endif
                <h2>My profile</h2>
            </div>
            <div class="col-12">
                @admin
                    <div class="alert alert-primary">
                        <strong>Tip!</strong> If you want to change details about yourself, please <a href="{{ route('users.edit', $user->id) }}">edit yourself</a> like a man.
                    </div>
                @else
                    <form class="form-group" method="post" action="{{route('profile')}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col control-label">E-mail</label>
                                    <div class="col inputGroupContainer">
                                        <div class="input-group">
                                            <input  name="email" placeholder="E-mail" class="form-control"  type="email" value="{{old('email', $user->client->email)}}">
                                        </div>
                                        @include('users.partials.error', ['name' => 'email'])
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col control-label">VAT number</label>
                                    <div class="col inputGroupContainer">
                                        <div class="input-group">
                                            <input  name="vat_number" placeholder="VAT number" class="form-control"  type="text" value="{{old('vat_number', $user->client->vat_number)}}">
                                        </div>
                                        @include('users.partials.error', ['name' => 'vat_number'])
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col control-label">Registration number</label>
                                    <div class="col inputGroupContainer">
                                        <div class="input-group">
                                            <input  name="registration_number" placeholder="Registration number" class="form-control"  type="text" value="{{old('registration_number', $user->client->registration_number)}}">
                                        </div>
                                        @include('users.partials.error', ['name' => 'registration_number'])
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col control-label">Payment terms</label>
                                    <div class="col inputGroupContainer">
                                        <div class="input-group">
                                            <input placeholder="Payment terms" class="form-control"  type="text" value="{{$user->client->payment_terms }}" disabled>
                                        </div>
                                        @include('users.partials.error', ['name' => 'payment_terms'])
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col control-label">Contact person</label>
                                    <div class="col inputGroupContainer">
                                        <div class="input-group">
                                            <input  name="contact_person" placeholder="Contact person" class="form-control"  type="text" value="{{old('contact_person', $user->client->contact_person)}}">
                                        </div>
                                        @include('users.partials.error', ['name' => 'contact_person'])
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col control-label">Client name</label>
                                    <div class="col inputGroupContainer">
                                        <div class="input-group">
                                            <input  name="name" placeholder="Client name" class="form-control"  type="text" value="{{old('name', $user->client->name)}}">
                                        </div>
                                        @include('users.partials.error', ['name' => 'name'])
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col control-label">Phone number</label>
                                    <div class="col inputGroupContainer">
                                        <div class="input-group">
                                            <input  name="phone" placeholder="Phone number" class="form-control"  type="text" value="{{old('phone', $user->client->phone)}}">
                                        </div>
                                        @include('users.partials.error', ['name' => 'phone'])
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col control-label">Company address</label>
                                    <div class="col inputGroupContainer">
                                        <div class="input-group">
                                            <input class="form-control" name="registration_address" placeholder="Company address" rows="5" value="{{old('registration_address', $user->client->registration_address)}}">
                                        </div>
                                        @include('users.partials.error', ['name' => 'company_address'])
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col control-label">Shipping address</label>
                                    <div class="col inputGroupContainer">
                                        <div class="input-group">
                                            <textarea class="form-control" name="shipping_address" placeholder="Shipping address" rows="5">{{old('shipping_address', $user->client->shipping_address)}}</textarea>
                                        </div>
                                        @include('users.partials.error', ['name' => 'shipping_address'])
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 form-group">
                            <div class="col-12">
                                <button type="submit" class="btn btn-danger btn-block" >Update</button>
                            </div>
                        </div>
                    </form>
                @endadmin
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-5 mb-5 text-center">
                <h2>Change password</h2>
            </div>
            <div class="col-12">
                <form class="form-group" method="post" action="{{route('profile.password')}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col control-label">Password</label>
                                <div class="col inputGroupContainer">
                                    <div class="input-group">
                                        <input  name="password" placeholder="Password" class="form-control" type="password">
                                    </div>
                                    @include('users.partials.error', ['name' => 'password'])
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col control-label">Password confirmation</label>
                                <div class="col inputGroupContainer">
                                    <div class="input-group">
                                        <input  name="password_confirmation" placeholder="Password confirmation" class="form-control"  type="password">
                                    </div>
                                </div>
                            </div>
                        </div>
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