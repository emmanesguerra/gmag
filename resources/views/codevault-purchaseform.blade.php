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
        <form method="POST" action="{{ route('codevault.purchase') }}"  class='no-edit p-2' >
            @csrf
            @include('common.serverresponse')
            <div class="form-group row field">
                <label class="col-sm-3 col-form-label">Select a package:</label>
                <div class="col-sm-4">
                    <select class="form-control form-control-sm "  name="package" id='package' onchange="updateTotalAmount(this)">
                        @foreach ($products as $product)
                        <option {{ (old('package') == $product->id) ? 'selected': '' }} value='{{ $product->id }}'>{{ $product->name }} {{ $product->price }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Quantity: </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="quantity" id='quantity' value="{{ old('quantity') }}" onchange="updateTotalAmount(this)">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Total Amount: </label>
                <div class="col-sm-4">
                    <span class="form-control form-control-sm" id='total_amount_s'>{{ old('total_amount') }}</span>
                    <input type="hidden" class="form-control form-control-sm "  name="total_amount" id='total_amount' value="{{ old('total_amount') }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Select a Payment Method:</label>
                <div class="col-sm-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payment_method" id="inlineRadio1" value="ewallet" style='cursor: pointer' {{ (old('payment_method') == 'ewallet') ? 'checked': '' }}>
                        <label class="form-control form-control-sm form-check-label border-0" for="inlineRadio1" style='cursor: pointer'><small>Via E-Wallet</small></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payment_method" id="inlineRadio2" value="paynamics" style='cursor: pointer' {{ (old('payment_method') == 'paynamics') ? 'checked': '' }} >
                        <label class="form-control form-control-sm form-check-label border-0" for="inlineRadio2" style='cursor: pointer'><small>Via Paynamics</small></label>
                    </div>
                </div>
            </div>
            <div class="form-group row field" id="wallter-cont" style="{{ (old('payment_method') == 'paynamics') ? 'visibility: hidden': '' }}">
                <label  class="col-sm-3 col-form-label">Select a Wallet:</label>
                <div class="col-sm-4">
                    <select class="form-control form-control-sm "  name="source" onchange="updatesource(this)">
                        <option {{ (old('source') == 'direct_referral') ? 'selected': '' }} value='direct_referral'>Direct Referral</option>
                        <option {{ (old('source') == 'encoding_bonus') ? 'selected': '' }} value='encoding_bonus'>Encoding Bonus</option>
                        <option {{ (old('source') == 'matching_pairs') ? 'selected': '' }} value='matching_pairs'>Matching Pair</option>
                    </select>
                </div>
            </div>
            <div class="form-group row field" id="wallter-cont2" style="{{ (old('payment_method') == 'paynamics') ? 'visibility: hidden': '' }}">
                <label  class="col-sm-3 col-form-label">Source Amount: </label>
                <div class="col-sm-4">
                    <span class="form-control form-control-sm" id='source_amount_s'>{{ old('source_amount') }}</span>
                    <input type="hidden" class="form-control form-control-sm "  name="source_amount" id='source_amount' value='{{ old('source_amount', $member->direct_referral) }}'>
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
            var value = '';
            switch($(el).val()) {
                case "direct_referral":
                    value = '{{ ($member->direct_referral) ? $member->direct_referral: 0 }}';
                    break;
                case "encoding_bonus":
                    value = '{{ ($member->encoding_bonus) ? $member->encoding_bonus: 0 }}';
                    break;
                case "matching_pairs":
                    value = '{{ ($member->matching_pairs) ? $member->matching_pairs: 0 }}';
                    break;
            }
            $('#source_amount').val(value);
            $('#source_amount_s').html(value);
        }
        
        function updateTotalAmount() {
            var quantity = $('#quantity').val();
            var packageAmt = 0;
            switch($('#package').val()) {
                @foreach ($products as $product)
                case '{{$product->id}}':
                    packageAmt = {{$product->price}};
                    break;
                @endforeach
            }
            var ttl_amt = packageAmt * quantity;
            $('#total_amount').val(ttl_amt);
            $('#total_amount_s').html(ttl_amt);
        }
        
        $('input[type=radio][name=payment_method]').change(function() {
            if (this.value == 'ewallet') {
                $('#wallter-cont').css('visibility', 'visible');
                $('#wallter-cont2').css('visibility', 'visible');
            }
            else if (this.value == 'paynamics') {
                $('#wallter-cont').css('visibility', 'hidden');
                $('#wallter-cont2').css('visibility', 'hidden');
            }
        });
    </script>
@endsection