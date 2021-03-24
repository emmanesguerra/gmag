@extends('layouts.app')

@section('title')
<title>LOGIN</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 mt-3" style='max-width: 418px'>
            <div class='text-center'>
                <img src='{{ asset('images/goal.png') }}' width='230' height="200">
            </div>            
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
            <div class="my-4">
                <h3 class='login-title'>SIGN IN</h3>
            </div>

            <div class="mb-0">
                <label for="exampleFormControlInput1" class="txt1 form-label">USERNAME</label>
                <input id="username" type="text" class="input100 form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="mb-0">
                <label for="exampleFormControlTextarea1" class="txt1 form-label">PASSWORD</label>
                <input id="password" type="password" class="input100 form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-12 text-right">
                    @if (Route::has('password.request'))
                    <a class="txt3 btn btn-link pr-0" href="{{ route('password.request') }}">
                        {{ __('Forgot Password?') }}
                    </a>
                    @endif
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-12 text-left">
                    <button type="submit" class="login100-form-btn btn btn-primary">
                        {{ __('Login') }}
                    </button>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-12 text-left">
                    <a class="nav-link pl-0" style='color:#333;' href="{{ route('register') }}">{{ __('Create an Account') }}</a>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
