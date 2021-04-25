@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Cycle Activation</title>
@endsection

@section('pagetitle')
    <i class="fa fa-credit-card"></i>  CYCLE ACTIVATION FORM
@endsection

@section('module-content')

<div class="row p-3">
    <div class='col-12 contentheader100'>
        Activation Form
    </div>
    <div class='col-12 content-container' style='position: relative'>
        <form method="POST" action="{{ route('refresh.store') }}" class='p-2' autocomplete="off" >
            @csrf

            @include('common.serverresponse')
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Current E-Wallet: </label>
                <div class="col-sm-4">
                    <span class="form-control form-control-sm border-0">PHP {{ number_format($member->total_amt, 2) }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Current Package:</label>
                <div class="col-sm-4">
                    <span class="form-control form-control-sm border-0">{{ $member->placement->product->name }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Select a Package:</label>
                <div class="col-sm-4">
                    <select name="product_id" class="form-control form-control-sm col-7 ">
                        @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ ($member->placement->product->id == $product->id) ? 'selected': '' }} >
                            {{ $product->name }} ({{ number_format($product->price) }})
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Select a Payment Method:</label>
                <div class="col-sm-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="ewallet" style='cursor: pointer'>
                        <label class="form-control form-control-sm form-check-label border-0" for="inlineRadio1" style='cursor: pointer'><small>Via E-Wallet</small></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="paynamics" style='cursor: pointer'>
                        <label class="form-control form-control-sm form-check-label border-0" for="inlineRadio2" style='cursor: pointer'><small>Via Paynamics</small></label>
                    </div>
                </div>
            </div>

            <div class="form-group row text-center">
                <div class="col-12 p-3">
                    <button type="submit" class="btn btn-success">
                        {{ __('PROCEED') }}
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection