@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - Change Admin Password</title>
@endsection

@section('module-content')

<form method="POST" action="{{ route('admin.changepassword.store') }}" autocomplete="off" >
    @csrf
    <div class="form-group row pt-0">
        <div class="col-12 form-header">
            <img class="float-left m-1" src="{{ asset('images/info.png') }}" width="35" height="35" /><h2 class="float-left p-0 my-2">CHANGE ADMINISTRATOR PASSWORD</h2>
        </div>
    </div>
    
    @include('common.serverresponse')

    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">Current Password</label>
        <div class="col-sm-3">
            <input type="password" class="form-control form-control-sm" name="current_password" value="{{ old('current_password') }}">
        </div>
    </div>
    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">New Password</label>
        <div class="col-sm-3">
            <input type="password" class="form-control form-control-sm" name="password" value="{{ old('password') }}">
        </div>
    </div>
    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">Confirm Password</label>
        <div class="col-sm-3">
            <input type="password" class="form-control form-control-sm" name="confirm_password" value="{{ old('confirm_password') }}">
        </div>
    </div>

    <div class="form-group row text-center">
        <div class="col-12 p-3">
            <button type="submit" class="btn btn-success">
                {{ __('Change Password') }}
            </button>
        </div>
    </div>
    <div class="form-group row text-left">
        <div class="col-12">
            <div class="alert alert-warning text-left">
            Note: You will automatically logout to the system after changing your password. 
            </div>
        </div>
    </div>

</form>
@endsection