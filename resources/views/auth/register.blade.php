@extends('layouts.register')

@section('title')
<title>SIGN-UP</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" style='max-width: 680px;'>
            <div class="card" style='box-shadow: 0 0 20px #000000b3;'>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-12">
                                <h3 class='signuph3'>Sign Up</h3>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-12 text-center">
                                <span class='signup100'>ACCOUNT ACCESS</span>
                            </div>
                        </div>

                        <div class="txtb" style='margin-top: 5px'>
                            <label for="exampleFormControlInput1" class='mb-0' >USERNAME:</label>
                            <input id="email" type="text" class="mt-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb">
                            <label for="exampleFormControlInput1" class='mb-0' >PASSWORD:</label>
                            <input id="password" type="password" class="mt-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb">
                            <label for="exampleFormControlInput1" class='mb-0' >CONFIRM PASSWORD:</label>
                            <input id="password-confirm" type="password" class="mt-0 " name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="txtb">
                            <label for="exampleFormControlInput1" class='mb-0' >SPONSOR:</label>
                            <input id="email" type="text" class="mt-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb">
                            <label for="exampleFormControlInput1" class='mb-0' >PLACEMENT:</label>
                            <input id="email" type="text" class="mt-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb">
                            <label for="exampleFormControlInput1" class='mb-0' >POSITION:</label>
                            <input id="email" type="text" class="mt-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group row mb-0 mt-4">
                            <div class="col-12 text-center">
                                <span class='signup100'>ACCOUNT INFORMATION</span>
                            </div>
                        </div>

                        <div class="txtb" style='margin-top: 5px'>
                            <label for="exampleFormControlInput1" class='mb-0' >FIRSTNAME:</label>
                            <input id="email" type="text" class="mt-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb" style='margin-top: 5px'>
                            <label for="exampleFormControlInput1" class='mb-0' >MIDDLENAME:</label>
                            <input id="email" type="text" class="mt-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb" style='margin-top: 5px'>
                            <label for="exampleFormControlInput1" class='mb-0' >LASTNAME:</label>
                            <input id="email" type="text" class="mt-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb" style='margin-top: 5px'>
                            <label for="exampleFormControlInput1" class='mb-0' >ADDRESS:</label>
                            <input id="email" type="text" class="mt-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb" style='margin-top: 5px'>
                            <label for="exampleFormControlInput1" class='mb-0' >EMAIL:</label>
                            <input id="email" type="text" class="mt-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb" style='margin-top: 5px'>
                            <label for="exampleFormControlInput1" class='mb-0' >MOBILE:</label>
                            <input id="email" type="text" class="mt-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group row mb-0 mt-4">
                            <div class="col-12 text-center">
                                <span class='signup100'>ACCOUNT ACCESS CODES</span>
                            </div>
                        </div>

                        <div class="txtb" style='margin-top: 5px'>
                            <label for="exampleFormControlInput1" class='mb-0' style="color:#062c78;">PINCODE 1:</label>
                            <input id="email" type="text" class="mt-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb" style='margin-top: 5px'>
                            <label for="exampleFormControlInput1" class='mb-0' style="color:#062c78;" >PINCODE 2:</label>
                            <input id="email" type="text" class="mt-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check text-center">
                                <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                                <label class="form-check-label" for="invalidCheck">
                                    I agree with Terms and Conditions <a href='#' style='text-decoration: underline; color: #c7a92d;'>click here</a>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary col-12">
                                    {{ __('SIGN UP') }}
                                </button>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <div class="form-check text-right">
                                <label class="form-check-label" for="invalidCheck">
                                    Already Have an Account? <a href='{{ route('login') }}'  style='text-decoration: none; color: #c7a92d;'><i class="fas fa-sign-in-alt" style="font-size:15px;color:#2a7dbf;"></i> SIGN IN</a>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
