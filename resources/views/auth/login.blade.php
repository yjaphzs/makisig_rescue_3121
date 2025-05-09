@extends('layouts.auth')

@section('content')
<div id="login-section">
    <div id="banner">
        <div class="image-container">
            <a class="app_dl" href="{{ asset('application/mr3121_client_v2.apk') }}"><div>Mobile Client</div><div>Download</div></a>
            <img src="{{  asset('images/common/banner.jpg') }}">
            <!--
            <div id="links">
                <a class="btn btn-link @if(Route::is('login'))active @endif" href="{{ route('login') }}">
                    {{ __('Login') }}
                </a>
                <a class="btn btn-link" href="{{ route('register') }}">
                    {{ __('Register') }}
                </a>
            </div>
            -->
        </div>
    </div>
    <div id="form">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h1>Makisig <span>Rescue</span></h1>
            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('') }}</label>

                <div class="col-md-6">
                    <input id="username" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus placeholder="Username">

                    @if ($errors->has('username'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <!--
            <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>
            -->

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <!--
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                    -->
                    
                     <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
