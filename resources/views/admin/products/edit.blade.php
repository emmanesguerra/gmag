@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - Products</title>
@endsection

@section('module-content')
  
<form method="POST" action="{{ route('admin.products.update', $product->id) }}" autocomplete="off" >
    @csrf
    @method('PUT')
    <input type="hidden" name="id" value="{{$product->id}}">
    
    <div class="form-group row pt-0">
        <div class="col-12 form-header">
            <img class="float-left m-1" src="{{ asset('images/info.png') }}" width="35" height="35" /><h2 class="float-left p-0 my-2">EDIT PRODUCT: {{ $product->name }}</h2>
        </div>
    </div>
    
    @include('common.serverresponse')
    
    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">PRODUCT TYPE</label>
        <div class="col-sm-9">
            <select name="type" class="form-control form-control-sm col-2 ">
                <option value='ACT' {{ 'ACT' == old('type', $product->type) ? 'selected' : '' }}>ACTIVATION</option>
                <option value='PROD' {{ 'PROD' == old('type', $product->type) ? 'selected' : '' }}>PRODUCT</option>
            </select>
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">PRODUCT CODE</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm text-uppercase"  name="code" value="{{ old('code', $product->code) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">PRODUCT NAME</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm text-uppercase"  name="name" value="{{ old('name', $product->name) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">PRODUCT PRICE</label>
        <div class="col-sm-3">
            <input type="number" class="form-control form-control-sm"  name="price" value="{{ old('price', $product->price) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">Product value</label>
        <div class="col-sm-3">
            <input max="16777215" type="number" class="form-control form-control-sm"  name="product_value" value="{{ old('product_value', $product->product_value) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">Flush bonus</label>
        <div class="col-sm-3">
            <input max="255" type="number" class="form-control form-control-sm"  name="flush_bonus" value="{{ old('flush_bonus', $product->flush_bonus) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">Display Icon</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="display_icon" value="{{ old('display_icon', $product->display_icon) }}">
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">Registration Code Prefix</label>
        <div class="col-sm-1">
            <input maxlength="2" type="text" class="form-control form-control-sm text-uppercase"  name="registration_code_prefix" value="{{ old('registration_code_prefix', $product->registration_code_prefix) }}">
        </div>
    </div>

    <div class="form-group row text-center">
        <div class="col-12 p-3">
            <button type="submit" class="btn btn-success">
                {{ __('Edit Product') }}
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-dark">
                {{ __('Go Back to Product list') }}
            </a>
        </div>
    </div>

</form>
@endsection