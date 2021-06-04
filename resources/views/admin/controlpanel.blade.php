@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - Control Panel</title>
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
            Pairings
        </div>
    </div>
    <div class="form-group row field">
        <label for="staticEmail" class="col-sm-3 col-form-label">Maximum Pairs Per Cycle</label>
        <div class="col-sm-3">
            <input type="numeric" class="form-control form-control-sm"  name="max_pairing_ctr" value="{{ old('max_pairing_ctr', $data['model']['max_pairing_ctr']) }}">
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-12 head">
            Cashout
        </div>
    </div>
    <div class="form-group row field">
        <label for="staticEmail" class="col-sm-3 col-form-label">Expiration Day Count</label>
        <div class="col-sm-3">
            <input type="numeric" class="form-control form-control-sm"  name="expiry_day" value="{{ old('expiry_day', $data['model']['expiry_day']) }}">
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