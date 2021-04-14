@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Edit Profile</title>
@endsection

@section('pagetitle')
    <i class="fa fa-credit-card"></i>  ACCOUNT INFORMATION
@endsection

@section('module-content')

<div class="row p-3">
    <div class='col-12 contentheader100'>
        Edit Profile
    </div>
    <div class='col-12 content-container' style='position: relative'>
        <form method="POST" action="{{ route('profile.update', $member->id) }}" class='p-2' autocomplete="off" >
            @csrf
            @method('PUT')

            @include('common.serverresponse')
            <div class="form-group row field">
                <label class="col-sm-3 col-form-label">My Referral Link:</label>
                <div class="col-sm-4">
                    <input type="text" id="copylink" class="form-control form-control-sm text-primary" value="{{ route('register', ['ref' => $member->referral_code]) }}" />
                </div>
                <div class="col-sm-4 ml-0 pl-0">
                    <button type="button" class="btn btn-dark btn-sm" onclick="Copy()">Copy Link</button>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">First Name: </label>
                <div class="col-sm-4">
                    <span class="form-control form-control-sm border-0">{{ $member->firstname }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Middle Name:</label>
                <div class="col-sm-4">
                    <span class="form-control form-control-sm border-0">{{ $member->middlename }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Last Name:</label>
                <div class="col-sm-4">
                    <span class="form-control form-control-sm border-0">{{ $member->lastname }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Date Joined:</label>
                <div class="col-sm-4">
                    <span class="form-control form-control-sm border-0">{{ $member->updated_at }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Entry Type:</label>
                <div class="col-sm-4">
                    <span class="form-control form-control-sm border-0">{{ $member->placement->product->code }} | {{ $member->placement->product->price }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Birth Date:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm " name="birthdate" id='birthdate' value="{{ old('birthdate', $member->birthdate) }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Email:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="email" id='email' value="{{ old('email', $member->email) }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Mobile Number:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="mobile" id='mobile' value="{{ old('mobile', $member->mobile) }}">
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Address:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control form-control-sm "  name="address" id='address' value="{{ old('address', $member->address) }}">
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

@section('javascripts')
    <link href="{{ asset('js/jquery-ui-1.12.1.datepicker/jquery-ui.min.css') }}"  rel="stylesheet">
    <script src="{{ asset('js/jquery-ui-1.12.1.datepicker/jquery-ui.min.js') }}"></script>
    <script>
        $(function() {
            $("#birthdate").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: '1960:+0',
                dateFormat: 'yy-mm-dd'
            });
        });
        
        function Copy() {
            var copyText = document.getElementById("copylink");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            alert("Link copied to clipboard");
        }
    </script>
@endsection