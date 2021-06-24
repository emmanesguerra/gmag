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
        <form id="app" method="POST" action="{{ route('wallet.post') }}"  class='no-edit p-2' >
            @csrf
            @include('common.serverresponse')
            <cashout-form 
                v-bind:member="memberdata"
                v-bind:model="postdata"
                v-bind:disbursementmethods="disbursementmethods"
                >
            </cashout-form>
        </form>
    </div>
</div>
@endsection

@section('javascripts')
    <script>
        var postvalue = {
            'source': {!! json_encode( old('source'), JSON_NUMERIC_CHECK ) !!},
            'amount': {!! json_encode( old('amount')) !!},
            'minimum_req': {!! json_encode($minimum_req) !!},
            'disbursement_method': {!! json_encode( old('disbursement_method')) !!},
            'firstname': {!! json_encode( old('firstname', $member->firstname)) !!},
            'middlename': {!! json_encode( old('middlename', $member->middlename)) !!},
            'lastname': {!! json_encode( old('lastname', $member->lastname)) !!},
            'address1': {!! json_encode( old('address1', $member->address1)) !!},
            'address2': {!! json_encode( old('address2', $member->address2)) !!},
            'city': {!! json_encode( old('city', $member->city)) !!},
            'state': {!! json_encode( old('state', $member->state)) !!},
            'country': {!! json_encode( old('country', $member->country)) !!},
            'zip': {!! json_encode( old('zip', $member->zip)) !!},
            'email': {!! json_encode( old('email', $member->email)) !!},
            'mobile': {!! json_encode( old('mobile', $member->mobile)) !!}
        };
        
        var memberData = {!! json_encode($member) !!};
        var products = '';
        var walletTypes = '';
        var paymentMethods = '';
        var payinMethods = '';
        var disbursementMethods = {!! json_encode($disbursementmethods) !!};
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection