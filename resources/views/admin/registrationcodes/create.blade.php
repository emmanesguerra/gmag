@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - ENTRY CODES</title>
@endsection

@section('module-content')
  
<form method="POST" action="{{ route('admin.entrycodes.store') }}" autocomplete="off" >
    @csrf
    <div class="form-group row pt-0">
        <div class="col-12 form-header">
            <img class="float-left m-1" src="{{ asset('images/info.png') }}" width="35" height="35" /><h2 class="float-left p-0 my-2">GENERATE PINCODES</h2>
        </div>
    </div>
    
    @include('common.serverresponse')
    
    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">Generate Pincodes for:</label>
        <div class="col-sm-9">
            <select name="product_id" class="form-control form-control-sm col-3 ">
                @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }} ({{ number_format($product->price) }})</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">Number of Codes:</label>
        <div class="col-sm-1">
            <input type="number" class="form-control form-control-sm text-uppercase"  name="code_count" value="{{ old('code_count') }}">
        </div>
    </div>
    <div class="form-group row field">
        <div class="col-sm-12">
            <div class='alert alert-warning small'>Note: If the generated pincode is for a specific member, please encode the member's username</div>
        </div>
        <label  class="col-sm-3 col-form-label">Member's Username: <small>(Optional)</small></label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm text-uppercase"  name="username" value="{{ old('username') }}" />
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">Remarks: <small>(Optional)</small></label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="remarks" value="{{ old('remarks') }}">
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">Administrator's Password:</label>
        <div class="col-sm-3">
            <input type="password" class="form-control form-control-sm"  name="administrator_password" value="{{ old('admin_password') }}">
        </div>
    </div>

    <div class="form-group row text-center">
        <div class="col-12 p-3">
            <button type="submit" class="btn btn-success">
                {{ __('Generate Codes') }}
            </button>
            <a href="{{ route('admin.entrycodes.index') }}" class="btn btn-dark">
                {{ __('Go Back to Entry list') }}
            </a>
        </div>
    </div>

</form>
@endsection