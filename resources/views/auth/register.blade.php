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
                            <label class='mb-0' >USERNAME:</label>
                            <input maxlength="50" type="text" class="mt-0 @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required >

                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb">
                            <label class='mb-0' >PASSWORD:</label>
                            <input id="password" type="password" class="mt-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb">
                            <label class='mb-0' >CONFIRM PASSWORD:</label>
                            <input id="password-confirm" type="password" class="mt-0 " name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="txtb">
                            @if($hasSponsor)
                                <label class='mb-0' >SPONSOR:</label>
                                <span class="mt-0" style="color: #000;
                                        width: 100%;
                                        border: none;
                                        border-bottom-color: currentcolor;
                                        border-bottom-style: none;
                                        border-bottom-width: medium;
                                        border-bottom: 0px solid #333;
                                        background: none;
                                        outline: none;
                                        font-size: 18px;">{{ $member->username }}</span>
                                <input type="hidden" class="mt-0" name="referral_code" value="{{ $member->referral_code }}">
                                <input type="hidden" class="mt-0" name="sponsor" value="{{ $member->username }}">
                            @else
                                <label class='mb-0' >SPONSOR:</label>
                                <input type="text" class="mt-0 @error('sponsor') is-invalid @enderror" name="sponsor" value="{{ old('sponsor') }}" required >

                                @error('sponsor')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            @endif
                        </div>

                        <div class="txtb">
                            <label class='mb-0' >PLACEMENT:</label>
                            <input type="text" class="mt-0 @error('placement') is-invalid @enderror" name="placement" value="{{ old('placement') }}" required >

                            @error('placement')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb">
                            <label class='mb-0' >POSITION:</label>
                            
                            <select name='position' class="mt-0 form-control @error('position') is-invalid @enderror">
                                <option value='0'>Select Placement Position</option>
                                <option value='L' {{ 'L' == old('position') ? 'selected' : '' }}>Place to LEFT Position</option>
                                <option value='R' {{ 'R' == old('position') ? 'selected' : '' }}>Place to RIGHT Position</option>
                            </select>
                            
                            @error('position')
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
                            <label class='mb-0' >FIRSTNAME:</label>
                            <input maxlength="35" type="text" class="mt-0 @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required >

                            @error('firstname')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb" style='margin-top: 5px'>
                            <label class='mb-0' >MIDDLENAME:</label>
                            <input maxlength="35" type="text" class="mt-0 @error('middlename') is-invalid @enderror" name="middlename" value="{{ old('middlename') }}" required >

                            @error('middlename')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb" style='margin-top: 5px'>
                            <label class='mb-0' >LASTNAME:</label>
                            <input maxlength="50" type="text" class="mt-0 @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required >

                            @error('lastname')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb" style='margin-top: 5px'>
                            <label class='mb-0' >ADDRESS:</label>
                            <input maxlength="150" type="text" class="mt-0 @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required >

                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb" style='margin-top: 5px'>
                            <label class='mb-0' >EMAIL:</label>
                            <input type="text" class="mt-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required >

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb" style='margin-top: 5px'>
                            <label class='mb-0' >MOBILE:</label>
                            <input maxlength="25" type="text" class="mt-0 @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required >

                            @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div id='accesscodes' class="form-group row mb-0 mt-4">
                            <div class="col-12 text-center">
                                <span class='signup100'>ACCOUNT ACCESS CODES</span>
                            </div>
                        </div>
                        
                        @include('common.serverresponse')

                        <div class="txtb" style='margin-top: 5px'>
                            <label class='mb-0' style="color:#062c78;">PINCODE 1:</label>
                            <input type="text" class="mt-0 @error('pincode1') is-invalid @enderror" name="pincode1" value="{{ old('pincode1') }}" required >

                            @error('pincode1')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="txtb" style='margin-top: 5px'>
                            <label class='mb-0' style="color:#062c78;" >PINCODE 2:</label>
                            <input type="text" class="mt-0 @error('pincode2') is-invalid @enderror" name="pincode2" value="{{ old('pincode2') }}" required >

                            @error('pincode2')
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
                    
                    @if($errors->all())
                        <script>
                            <?php $pageerrors = ""; ?>
                                @foreach ($errors->all() as $error)
                                    <?php $pageerrors .= $error . '\n'; ?>
                                @endforeach
                              alert('{{ $pageerrors }}');
                        </script>
                    @endif
                    
                    @if (session('status-failed'))
                        <script>
                              alert('{{ session('status-failed') }}');
                        </script>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
