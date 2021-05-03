@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - Create Course</title>
@endsection

@section('module-content')

<form method="POST" action="{{ route('admin.course.store') }}" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="form-group row pt-0">
        <div class="col-12 form-header">
            <img class="float-left m-1" src="{{ asset('images/info.png') }}" width="35" height="35" /><h2 class="float-left p-0 my-2"> Create Courses</h2>
        </div>
    </div>
    
    @include('common.serverresponse')

    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">Title :</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm" name="title" value="{{ old('title') }}">
        </div>
    </div>
    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">Link :</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm" name="link" value="{{ old('link') }}">
        </div>
    </div>
    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">Upload File :</label>
        <div class="col-sm-3">
            <input type="file" class="form-control form-control-sm" name="fileToUpload" style="border: 0">
        </div>
    </div>

    <div class="form-group row text-center">
        <div class="col-12 p-3">
            <button type="submit" class="btn btn-success">
                {{ __('Submit') }}
            </button>
        </div>
    </div>

</form>
@endsection