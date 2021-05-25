@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Product Purchase</title>
@endsection

@section('pagetitle')
<i class="fa fa-credit-card"></i>  Product Purchase Form
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
    <div id='payment_form' class='col-12 contentheader100'>
        Purchase Form
    </div>
    <div class='col-12 content-container' style='position: relative'>
        <form id="app" method="POST" action="{{ route('codevault.purchase') }}"  class='no-edit p-2' >
            @csrf
            @include('common.serverresponse')
            <payment-form 
                v-bind:member="memberdata"
                v-bind:model="postdata"
                v-bind:products="products"
                v-bind:wallettypes="wallettypes"
                v-bind:paymentmethods="paymentmethods"
                v-bind:disbursementmethods="disbursementmethods"
                >
            </payment-form>
            
        </form>
    </div>
</div>
@endsection

@section('javascripts')
    <script>
        var postvalue = {
            'product': {!! json_encode( old('product'), JSON_NUMERIC_CHECK ) !!},
            'quantity': {!! json_encode( old('quantity')) !!},
            'total_amount': {!! json_encode( old('total_amount')) !!},
            'payment_method': {!! json_encode( old('payment_method')) !!},
            'source': {!! json_encode( old('source')) !!},
            'source_amount': {!! json_encode( old('source_amount')) !!}
        };
        
        var memberData = {!! json_encode($member) !!};
        var products = {!! json_encode($products) !!};
        var walletTypes = {!! json_encode($walletTypes) !!};
        var paymentMethods = {!! json_encode($paymentMethods) !!};
        var disbursementMethods = {!! json_encode($disbursementMethods) !!};
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection