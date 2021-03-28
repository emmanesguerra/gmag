@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Member Registration</title>
@endsection

@section('pagetitle')
<i class="fa fa-user-circle "></i>  Member's Registration
@endsection

@section('module-content')

<div class="row p-3">
    <div class='col-12 contentheader100'>
        Register Form
        @if (env('APP_ENV')=='local')
        <span id='generatevalues' class='btn btn-sm btn-success float-right'>Generate Fake Values</span>
        @endif
    </div>
    <div class='col-12 content-container' style='position: relative'>
        <form method="POST" action="{{ route('register.member.store') }}" class='p-2' autocomplete="off" >
            @csrf
            <input type="hidden" name="placement" value="{{ $username->username }}">
            <input type="hidden" name="position" value="{{ $position }}">
            <input type="hidden" name="targetId" value="{{ $targetId }}">

            @include('common.serverresponse')
            <div class="form-group row field">
                <label class="col-sm-3 col-form-label">Account username:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="username" id='username' value="{{ old('username') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Sponsor username: </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="sponsor" id='sponsor' value="{{ old('sponsor') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">First name:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="firstname" id='firstname' value="{{ old('firstname') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Middle name:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm"  name="middlename" id='middlename' value="{{ old('middlename') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Last name:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm"  name="lastname" id='lastname' value="{{ old('lastname') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Address:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm"  name="address" id='address' value="{{ old('address') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Email:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="email" id='email' value="{{ old('email') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Mobile:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="mobile" id='mobile' value="{{ old('mobile') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Pincode 1:</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm "  name="pincode1" id='pincode1' value="{{ old('pincode1') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Pincode 2:</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm "  name="pincode2" id='pincode2' value="{{ old('pincode2') }}">
                </div>
            </div>

            <div class="form-group row text-center">
                <div class="col-12 p-3">
                    <button type="submit" class="btn btn-success">
                        {{ __('Register Member') }}
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-dark">
                        {{ __('Go Back to Genealogy tree') }}
                    </a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('javascripts')
    @if (env('APP_ENV')=='local')
    <script>
        <?php
        $faker = Faker\Factory::create();
        ?>
        $('#generatevalues').click(function() {
            $('#username').val('{{ $faker->username }}');
            $('#sponsor').val('GOLDENMAGTOP');
            $('#firstname').val('{{ $faker->firstname }}');
            $('#middlename').val('{{ $faker->lastname }}');
            $('#lastname').val('{{ $faker->lastname }}');
            $('#address').val("{{ $faker->streetAddress }}");
            $('#email').val('{{ $faker->email }}');
            $('#mobile').val('{{ $faker->e164PhoneNumber }}');
        });
    </script>
    @endif
@endsection