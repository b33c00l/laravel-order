<div class="col-10">
    <div class="row">
        <div class="col-12 text-center mt-5 mb-5">
            <h2>Create password</h2>
        </div>
        <div class="col-12">
            <form class="form-group" method="post" action="{{ route('complete.store', ['token' => $token]) }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col control-label">Password</label>
                    <div class="col inputGroupContainer">
                        <div class="input-group">
                            <input name="password" placeholder="Password" class="form-control" type="password">
                        </div>
                        @include('users.partials.error', ['name' => 'password'])
                    </div>
                </div>
                <div class="form-group">
                    <label class="col control-label">Repeat Password</label>
                    <div class="col inputGroupContainer">
                        <div class="input-group">
                            <input name="password_confirmation" placeholder="Password" class="form-control"
                                   type="password">
                        </div>
                        @include('users.partials.error', ['name' => 'password'])
                    </div>
                </div>
                <div class="col-12 form-group">
                    <div class="col">
                        <button type="submit" class="btn btn-danger btn-block">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>