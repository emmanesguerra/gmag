@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Cashout Form</title>
@endsection

@section('pagetitle')
<i class="fa fa-credit-card"></i>  My E-Wallet
@endsection

@section('module-content')

<div class="row pb-0 px-3 pt-3">
    <div class='col-12 p-0' style="background-image: linear-gradient(to bottom right, #fff , #fff , #edebb1); border-radius: 6px;">
        <div class='col-12 contentheader100'>
            Current E-Wallet Amount
        </div>
        <div class='col-12 contentbody100 p-3'>
            <span class="dashamount" id='curr_amount'>{{ number_format($member->total_amt, 2) }} <sup>PHP</sup></span>
            <i class="fa fa-university pb-1" style="color: #bba701"></i>
        </div>
    </div>
</div>

<div class="row p-3">
    <div id='binary_status' class='col-12 contentheader100'>
        Request Cashout E-Wallet
    </div>
    <div class='col-12 content-container' style='position: relative'>
        <form method="POST" action="{{ route('wallet.post') }}"  class='no-edit p-2' >
            @csrf
            @include('common.serverresponse')
            <div class="form-group row field">
                <label class="col-sm-3 col-form-label">Current Wallet Amount:</label>
                <div class="col-sm-4">
                    <span class="form-control form-control-lg border-0"><strong>{{ number_format($member->total_amt, 2) }}</strong> PHP</span>
                    <input type="hidden" class="form-control form-control-sm "  name="total_amt" id='total_amt' value="{{ $member->total_amt }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Minimum Request: </label>
                <div class="col-sm-4">
                    <span class="form-control form-control-lg border-0"><strong>{{ $minimum_req }}</strong> PHP</span>
                    <input type="hidden" class="form-control form-control-sm "  name="minimum_req" id='minimum_req' value="{{ $minimum_req }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Amount: </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="amount" id='amount' value="{{ old('amount') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Request Type</label>
                <div class="col-sm-4">
                    <select class="form-control form-control-sm "  name="req_type">
                        <option {{ (old('req_type') == 'Cheque') ? 'selected': '' }}>Cheque</option>
                        <option {{ (old('req_type') == 'Palawan Express') ? 'selected': '' }}>Palawan Express</option>
                        <option {{ (old('req_type') == 'Cebuana Lhuiller') ? 'selected': '' }}>Cebuana Lhuiller</option>
                        <option {{ (old('req_type') == 'Western Union') ? 'selected': '' }}>Western Union</option>
                    </select>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Full Name:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="name" id='name' value="{{ old('name', $member->firstname . ' ' . $member->middlename . ' ' . $member->lastname) }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Mobile Number:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="mobile" id='mobile' value="{{ old('mobile', $member->mobile) }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Password:</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control form-control-sm "  name="password" id='password' value="">
                </div>
            </div>

            <div class="form-group row text-center">
                <div class="col-12 p-3">
                    <button type="submit" class="btn btn-success">
                        {{ __('SUBMIT REQUEST') }}
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection