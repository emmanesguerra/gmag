@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - Edit Course</title>
@endsection

@section('module-content')

<form method="POST" action="{{ route('admin.course.update', $course->id) }}" autocomplete="off" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group row pt-0">
        <div class="col-12 form-header">
            <img class="float-left m-1" src="{{ asset('images/info.png') }}" width="35" height="35" /><h2 class="float-left p-0 my-2"> Edit Courses</h2>
        </div>
    </div>
    
    @include('common.serverresponse')

    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">Title :</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm" name="title" value="{{ old('title', $course->title) }}">
        </div>
    </div>

    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">Short Description :</label>
        <div class="col-sm-5">
            <textarea class="form-control form-control-sm mb-2" name='description'  rows='8'>{{ old('description', $course->description) }}</textarea>
        </div>
    </div>
    @if($course->source == 1)
    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">Link :</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm" name="link" value="{{ old('link', $course->link) }}">
        </div>
    </div>
    @else
    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">Current File :</label>
        <div class="col-sm-3">
            <span class="form-control form-control-sm">{{ $course->filename }}</span>
        </div>
    </div>
    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">Current Thumbnail :</label>
        <div class="col-sm-3">
            <span class="form-control form-control-sm">{{ $course->file_thumbnail }}</span>
        </div>
    </div>
    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">Upload File :</label>
        <div class="col-sm-3">
            <input type="file" class="form-control form-control-sm" name="videoFile" style="border: 0">
        </div>
    </div>
    <div class="form-group row field">
        <label class="col-sm-3 col-form-label">Upload Thumbnail :</label>
        <div class="col-sm-3">
            <input type="file" class="form-control form-control-sm" name="thumbnail" style="border: 0">
        </div>
    </div>
    @endif
    <div class="form-group row text-center">
        <div class="col-12 p-3">
            <button type="submit" class="btn btn-success">
                {{ __('Submit') }}
            </button>
        </div>
    </div>

</form>
@endsection