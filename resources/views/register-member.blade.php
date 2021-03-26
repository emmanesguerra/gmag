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
                    <input type="text" class="form-control form-control-sm "  name="username" value="{{ old('username') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Sponsor username: </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="sponsor" value="{{ old('sponsor') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">First name:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="firstname" value="{{ old('firstname') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Middle name:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm"  name="middlename" value="{{ old('middlename') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Last name:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm"  name="lastname" value="{{ old('lastname') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Address:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm"  name="address" value="{{ old('address') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Email:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="email" value="{{ old('email') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Mobile:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="mobile" value="{{ old('mobile') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Pincode 1:</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm "  name="pincode1" value="{{ old('pincode1') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Pincode 2:</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control form-control-sm "  name="pincode2" value="{{ old('pincode2') }}">
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