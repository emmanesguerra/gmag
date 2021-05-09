@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - Product Info</title>
@endsection

@section('module-content')
  
<form>
    <div class="form-group row pt-0">
        <div class="col-12 form-header">
            <img class="float-left m-1" src="{{ asset('images/info.png') }}" width="35" height="35" /><h2 class="float-left p-0 my-2">PRODUCT: {{ $product->name }}</h2>
        </div>
    </div>
    
    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">PRODUCT TYPE</label>
        <div class="col-sm-3">
            <span class="form-control form-control-sm">{{ ($product->type == 'ACT') ? "ACTIVITION": "PRODUCT" }}</span>
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">PRODUCT CODE</label>
        <div class="col-sm-3">
            <span class="form-control form-control-sm">{{ $product->code }}</span>
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">PRODUCT NAME</label>
        <div class="col-sm-3">
            <span class="form-control form-control-sm">{{ $product->name }}</span>
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">PRODUCT PRICE</label>
        <div class="col-sm-3">
            <span class="form-control form-control-sm">{{ number_format($product->price, 2) }}</span>
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">Points Value</label>
        <div class="col-sm-3">
            <span class="form-control form-control-sm">{{ number_format($product->product_value, 2) }}</span>
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">Flush Bonus</label>
        <div class="col-sm-3">
            <span class="form-control form-control-sm">{{ $product->flush_bonus }}</span>
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">Display Icon</label>
        <div class="col-sm-3">
            <img class="m-1 mb-3" src="{{ asset('images/' . $product->display_icon) }}" />
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">Registration Code Prefix</label>
        <div class="col-sm-1">
            <span class="form-control form-control-sm">{{ $product->registration_code_prefix }}</span>
        </div>
    </div>

    <div class="form-group row text-center">
        <div class="col-12 p-3">
            <a href="{{ route('admin.products.index') }}" class="btn btn-dark">
                {{ __('Go Back to Product list') }}
            </a>
        </div>
    </div>

</form>
@endsection