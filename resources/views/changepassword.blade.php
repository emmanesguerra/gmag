@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Change Password</title>
@endsection

@section('pagetitle')
    <i class="fa fa-credit-card"></i>  PASSWORD SETTINGS
@endsection

@section('module-content')

<div class="row p-3">
    <div class='col-12 contentheader100'>
        Change Password
    </div>
    <div class='col-12 content-container' style='position: relative'>
        <form method="POST" action="{{ route('changepassword.store') }}" class='p-2' autocomplete="off" >
            @csrf

            @include('common.serverresponse')
            <div class="form-group row field">
                <label class="col-sm-3 col-form-label">OLD Password:</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control form-control-sm "  name="current_password" id='current_password' value="{{ old('current_password') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">NEW Password: </label>
                <div class="col-sm-4">
                    <input type="password" class="form-control form-control-sm "  name="password" id='password' value="{{ old('password') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Confirm Password:</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control form-control-sm "  name="confirm_password" id='confirm_password' value="{{ old('confirm_password') }}">
                </div>
            </div>

            <div class="form-group row text-center">
                <div class="col-12 p-3">
                    <button type="submit" class="btn btn-success">
                        {{ __('PROCEED') }}
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('javascripts')
@endsection