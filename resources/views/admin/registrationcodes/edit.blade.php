@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - ENTRY CODES</title>
@endsection

@section('module-content')
  
<form method="POST" action="{{ route('admin.entrycodes.update', $entrycode->id) }}" autocomplete="off" >
    @csrf
    @method('PUT')
    <input type="hidden" name="id" value="{{$entrycode->id}}">
    
    <div class="form-group row pt-0">
        <div class="col-12 form-header">
            <img class="float-left m-1" src="{{ asset('images/info.png') }}" width="35" height="35" /><h2 class="float-left p-0 my-2">EDIT ENTRY CODE #: {{ $entrycode->id }}</h2>
        </div>
    </div>
    
    @include('common.serverresponse')
    
    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">Product Type:</label>
        <div class="col-sm-3">
            <span class="form-control form-control-sm">{{ $entrycode->product->name }}</span>
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">Amount:</label>
        <div class="col-sm-3">
            <span class="form-control form-control-sm">{{ number_format($entrycode->product->price, 2) }}</span>
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">Assigned To:</label>
        <div class="col-sm-3">
            <span class="form-control form-control-sm">{{ $entrycode->member->username }}</span>
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">Pincode 1:</label>
        <div class="col-sm-3">
            <span class="form-control form-control-sm">{{ $entrycode->pincode1 }}</span>
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">Pincode 2:</label>
        <div class="col-sm-3">
            <span class="form-control form-control-sm">{{ $entrycode->pincode2 }}</span>
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">Status:</label>
        <div class="col-sm-3">
            <select class="form-control" name='is_used'>
                @foreach(['Available','Used'] as $ctr => $value)
                @if( old('is_used', $entrycode->is_used) == $ctr)
                <option value="{{ $ctr }}" selected>{{ $value }}</option>
                @else 
                <option value="{{ $ctr }}">{{ $value }}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row field">
        <label  class="col-sm-3 col-form-label">Remarks:</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm"  name="remarks" value="{{ old('remarks', $entrycode->remarks) }}">
        </div>
    </div>

    <div class="form-group row text-center">
        <div class="col-12 p-3">
            <button type="submit" class="btn btn-success">
                {{ __('Save Changes') }}
            </button>
            <a href="{{ route('admin.entrycodes.index') }}" class="btn btn-dark">
                {{ __('Go Back to Entry list') }}
            </a>
        </div>
    </div>

</form>
@endsection