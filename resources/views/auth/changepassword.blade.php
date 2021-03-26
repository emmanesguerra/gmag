@extends('layouts.app')

@section('title')
<title>Golden Mag - Change Password</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 mt-2 pt-2" style='max-width: 418px'>        
            
            <!--<form method="POST" action="{{ route('login') }}">-->
            <form method="POST" action='{{ route('changepswd.store') }}'>
                @csrf
                
            <div class="my-4">
                <h3 style="font-family: 'Arial Black', Gadget, sans-serif;font-size: 28px;color: #666;"><small>Welcome to</small><br /> GOLDENMAG</h3>
                <p><small>Please change your password for security purposes.</small></p>
            </div>
                
            <div class="form-group">
                <input type="password" class="input100 form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autofocus placeholder="Enter New Password">
                
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input type="password" class="input100 form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required placeholder="Re-enter New Password">
                
                @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group row">
                <div class="col-md-12 text-left">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Submit and Login') }}
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
