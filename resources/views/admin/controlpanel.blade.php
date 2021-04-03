@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - CONTROL PANEL</title>
@endsection

@section('module-content')
  
<form method="POST" action="{{ route('admin.controlpanel.store') }}" autocomplete="off" >
    @csrf
    <div class="form-group row pt-0">
        <div class="col-12 form-header">
            <img class="float-left m-1" src="{{ asset('images/info.png') }}" width="35" height="35" /><h2 class="float-left p-0 my-2">CONTROL PANEL</h2>
        </div>
    </div>
    
    @include('common.serverresponse')
    
    <div class="form-group row">
        <div class="col-12 head">
            Bonuses
        </div>
    </div>
    <div class="form-group row field">
        <label for="staticEmail" class="col-sm-3 col-form-label">Direct Referral Bonus</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="direct_referral_bonus" value="{{ old('direct_referral_bonus', $data['model']['direct_referral_bonus']) }}">
        </div>
        <small class="col-sm-6 col-form-label small">{{ $data['model']['direct_referral_bonus'] * 100 }}% of 100</small>
    </div>
    <div class="form-group row field">
        <label for="staticEmail" class="col-sm-3 col-form-label">Encoding Bonus</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="encoding_bonus" value="{{ old('encoding_bonus', $data['model']['encoding_bonus']) }}">
        </div>
        <small class="col-sm-6 col-form-label small">{{ $data['model']['encoding_bonus'] * 100 }}% of 100</small>
    </div>
    
    <div class="form-group row">
        <div class="col-12 head">
            Encashment Settings
        </div>
    </div>
    <div class="form-group row field">
        <label for="staticEmail" class="col-sm-3 col-form-label">Encashment Status</label>
        <div class="col-sm-9">
            <select name="encash_status" class="form-control form-control-sm col-2 ">
                <option {{ 'ACTIVE' == old('encash_status', $data['model']['encash_status']) ? 'selected' : '' }}>ACTIVE</option>
                <option {{ 'INACTIVE' == old('encash_status', $data['model']['encash_status']) ? 'selected' : '' }}>INACTIVE</option>
            </select>
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Admin Fee</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="admin_fee" value="{{ old('admin_fee', $data['model']['admin_fee']) }}">
        </div>
        <small class="col-sm-6 col-form-label small">{{ $data['model']['admin_fee'] * 100 }}% of 100</small>
    </div>
    <div class="form-group row">
        <div class="col-12 head">
            Product UNILEVEL Settings
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Personal Unilevel</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="unilvl_personal" value="{{ old('unilvl_personal', $data['model']['unilvl_personal']) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 1</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="unilvl_1" value="{{ old('unilvl_1', $data['model']['unilvl_1']) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 2</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="unilvl_2" value="{{ old('unilvl_2', $data['model']['unilvl_2']) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 3</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="unilvl_3" value="{{ old('unilvl_3', $data['model']['unilvl_3']) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 4</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="unilvl_4" value="{{ old('unilvl_4', $data['model']['unilvl_4']) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 5</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="unilvl_5" value="{{ old('unilvl_5', $data['model']['unilvl_5']) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 6</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="unilvl_6" value="{{ old('unilvl_6', $data['model']['unilvl_6']) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 7</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="unilvl_7" value="{{ old('unilvl_7', $data['model']['unilvl_7']) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 8</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="unilvl_8" value="{{ old('unilvl_8', $data['model']['unilvl_8']) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 9</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="unilvl_9" value="{{ old('unilvl_9', $data['model']['unilvl_9']) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 10</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="unilvl_10" value="{{ old('unilvl_10', $data['model']['unilvl_10']) }}">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-12 head">
            InDirenct Settings
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 1</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="indirect_1" value="{{ old('indirect_1', $data['model']['indirect_1']) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 2</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="indirect_2" value="{{ old('indirect_2', $data['model']['indirect_2']) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 3</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="indirect_3" value="{{ old('indirect_3', $data['model']['indirect_3']) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 4</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="indirect_4" value="{{ old('indirect_4', $data['model']['indirect_4']) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 5</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="indirect_5" value="{{ old('indirect_5', $data['model']['indirect_5']) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 6</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="indirect_6" value="{{ old('indirect_6', $data['model']['indirect_6']) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label for="inputPassword" class="col-sm-3 col-form-label">Income on Level 7</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="indirect_7" value="{{ old('indirect_7', $data['model']['indirect_7']) }}">
        </div>
    </div>

    <div class="form-group row text-center">
        <div class="col-12 p-3">
            <button type="submit" class="btn btn-success">
                {{ __('Save Settings') }}
            </button>
        </div>
    </div>

</form>
@endsection