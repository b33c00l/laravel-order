<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>Login - Game Star</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GameStar') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid login-container" >
        <div class="row justify-content-center login-row">
            <div class="col-lg-4 col-md-5 col-sm-5 col-10 login-box align-middle">
                <div class="login-form">
                    <div>
                        <img class="mb-3 login_logo" src="{{ asset('images/logo2.png') }}">
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" placeholder="Username" value="{{ old('name') }}" required autofocus>
                        @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                        <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} mt-3" type="password" name="password" placeholder="Password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                        <input class="btn btn-dark mt-3" type="submit" name="submit" value="Login">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
