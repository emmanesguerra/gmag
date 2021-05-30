@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Cashout Form</title>
@endsection

@section('pagetitle')
<i class="fa fa-credit-card"></i>  My E-Wallet
@endsection

@section('module-content')


<div class="row pb-0 px-3 pt-3">
    <div class='col-4 pl-0'>
        <div class='col-12 contentheader100'>
            Direct Referral
        </div>
        <div class='col-12 contentbody100 p-3' style="background-image: linear-gradient(to bottom right, #fff , #fff , #fadcae); border-radius: 0 0 6px 6px;">
            <span class="dashamount" id='direct_referral'>{{ number_format($member->direct_referral, 2) }} <sup>PHP</sup></span>
            <i class="fa fa-users pb-1" style="color: #f9bd61"></i>
        </div>
    </div>
    <div class='col-4 px-0'>
        <div class='col-12 contentheader100'>
            Encoding Bonus <small>(Qualified)</small>
        </div>
        <div class='col-12 contentbody100 p-3' style="background-image: linear-gradient(to bottom right, #fff , #fff , #f8daab); border-radius: 0 0 6px 6px;">
            <span class="dashamount" id='encoding_bonus'>{{ number_format($member->encoding_bonus, 2) }} <sup>PHP</sup></span>
            <i class="fa fa-edit pb-1" style="color: #f89c0e"></i>
        </div>
    </div>
    <div class='col-4 pr-0'>
        <div class='col-12 contentheader100'>
            Sales Match Bonus
        </div>
        <div class='col-12 contentbody100 p-3' style="background-image: linear-gradient(to bottom right, #fff , #fff , #ee907d); border-radius: 0 0 6px 6px;">
            <span class="dashamount" id='sales_match_bonus'>{{ number_format($member->matching_pairs, 2) }} <sup>PHP</sup></span>
            <i class="fa fa-star pb-1" style="color: #e63816"></i>
        </div>
    </div>
</div>

<div class="row pb-0 px-3 pt-3">
    <div class='col-12 p-0' style="background-image: linear-gradient(to bottom right, #fff , #fff , #edebb1); border-radius: 6px;">
        <div class='col-12 contentheader100'>
            Total E-Wallet Amount
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
                <label class="col-sm-3 col-form-label">Select E-Wallet:</label>
                <div class="col-sm-4">
                    <select class="form-control form-control-sm "  name="source" onchange="updatesource(this)">
                        <option {{ (old('source') == 'direct_referral') ? 'selected': '' }} value='direct_referral'>Direct Referral</option>
                        <option {{ (old('source') == 'encoding_bonus') ? 'selected': '' }} value='encoding_bonus'>Encoding Bonus</option>
                        <option {{ (old('source') == 'matching_pairs') ? 'selected': '' }} value='matching_pairs'>Matching Pair</option>
                    </select>
                    <input type="hidden" class="form-control form-control-sm "  name="source_amount" id='source_amount' value='{{ old('source_amount', $member->direct_referral) }}'>
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
                <div class="input-group col-sm-9">
                    <input type="text" class="form-control form-control-sm "  name="firstname" id='firstname' value="{{ old('firstname', $member->firstname) }}">
                    <input type="text" class="form-control form-control-sm "  name="lastname" id='lastname' value="{{ old('lastname',$member->lastname) }}">
                    <input type="text" class="form-control form-control-sm "  name="middlename" id='middlename' value="{{ old('middlename', $member->middlename) }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Address 1:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="address1" id='address1' value="{{ old('address1', $member->address1) }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Address 2:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="address2" id='address2' value="{{ old('address2', $member->address2) }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">City*/ State/ Country*/ Zip:</label>
                <div class="input-group col-sm-9">
                    <input type="text" class="form-control form-control-sm "  name="city" id='city' value="{{ old('city', $member->city) }}">
                    <input type="text" class="form-control form-control-sm "  name="state" id='state' value="{{ old('state', $member->state) }}">
                    <select class="form-control form-control-sm "  name="country" id='country'>
                        <option value="">Select a country</option>
                        <option value="PH" {{ old('country', $member->country) == 'PH' ? "selected": "" }}>Philipines</option>
                        <option value="US" {{ old('country', $member->country) == 'US' ? "selected": "" }}>United States America</option>
                    </select>
                    <input type="text" class="form-control form-control-sm "  name="zip " id='zip ' value="{{ old('zip ', $member->zip ) }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Email:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="email " id='email ' value="{{ old('email ', $member->email ) }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Mobile:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="mobile " id='mobile ' value="{{ old('mobile ', $member->mobile ) }}">
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

@section('javascripts')
    <script>
        function updatesource (el) {
            console.log($(el).val());
            switch($(el).val()) {
                case "direct_referral":
                    $('#source_amount').val('{{ $member->direct_referral }}');
                    break;
                case "encoding_bonus":
                    $('#source_amount').val('{{ $member->encoding_bonus }}');
                    break;
                case "matching_pairs":
                    $('#source_amount').val('{{ $member->matching_pairs }}');
                    break;
            }
            
        }
    </script>
@endsection