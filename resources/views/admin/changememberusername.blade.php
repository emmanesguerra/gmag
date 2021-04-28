@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - Change Member Username</title>
@endsection

@section('module-content')

<form method="POST" action="{{ route('admin.memberusername.store') }}" autocomplete="off" >
    @csrf
    <div class="form-group row pt-0">
        <div class="col-12 form-header">
            <img class="float-left m-1" src="{{ asset('images/info.png') }}" width="35" height="35" /><h2 class="float-left p-0 my-2">CHANGE MEMBER'S USERNAME</h2>
        </div>
    </div>
    
    @include('common.serverresponse')

    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">Old Username</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm" name="old_username" value="{{ old('old_username') }}">
        </div>
    </div>
    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">New Username</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm" name="new_username" value="{{ old('new_username') }}">
        </div>
    </div>

    <div class="form-group row text-center">
        <div class="col-12 p-3">
            <button type="submit" class="btn btn-success">
                {{ __('Change Username') }}
            </button>
        </div>
    </div>

</form>
@endsection