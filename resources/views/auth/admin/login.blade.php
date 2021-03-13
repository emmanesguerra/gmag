@extends('layouts.app')

@section('title')
<title>| ADMIN</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 mt-5 pt-5" style='max-width: 418px'>        
            
            <!--<form method="POST" action="{{ route('login') }}">-->
            <form method="POST" action='{{ url("login/admin") }}' aria-label="{{ __('Login') }}">
                @csrf
            <div class="my-4">
                <h3 style="font-family: 'Arial Black', Gadget, sans-serif;font-size: 28px;color: #666;">AdminPanel</h3>
            </div>

            <div class="form-group">
                <input id="email" type="text" class="input100 form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter ADMIN Username">
                
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password" type="password" class="input100 form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter ADMIN Password">
                
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group row">
                <div class="col-md-12 text-left">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
