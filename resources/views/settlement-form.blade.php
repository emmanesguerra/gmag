@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Credit Settlement Form</title>
@endsection

@section('pagetitle')
    <i class="fa fa-credit-card"></i>  CREDIT SETTLEMENT FORM
@endsection

@section('module-content')

<div class="row p-3">
    <div class='col-12 contentheader100'>
        Settlement Form
    </div>
    <div class='col-12 content-container' style='position: relative'>
        <form id="app" method="POST" action="{{ route('settle.amount') }}" class='p-2' autocomplete="off" >
            @csrf

            @include('common.serverresponse')
            <settlement-form 
                v-bind:member="memberdata"
                v-bind:model="postdata"
                v-bind:products="products"
                v-bind:wallettypes="wallettypes"
                v-bind:paymentmethods="paymentmethods"
                v-bind:payinmethods="payinmethods"
                >
            </settlement-form>

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
            'source_amount': {!! json_encode( old('source_amount')) !!},
            'payinmethods': {!! json_encode( old('payinmethod_name')) !!}
        };
        
        var memberData = {!! json_encode($member) !!};
        var products = '';
        var walletTypes = {!! json_encode($walletTypes) !!};
        var paymentMethods = {!! json_encode($paymentMethods) !!};
        var payinMethods = {!! json_encode($payinmethods) !!};
        var disbursementMethods = '';
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
@endsection