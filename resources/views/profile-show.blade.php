@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Profile</title>
@endsection

@section('pagetitle')
    <i class="fa fa-credit-card"></i>  ACCOUNT INFORMATION
@endsection

@section('module-content')

<div class="row p-3">
    <div class='col-12 contentheader100'>
        My Profile
        
        <span style='float: right; margin-right: 10px;'><a href='{{ route('profile.edit', $member->id) }}' class="btn btn-sm btn-success">Edit Profile</a></span>
    </div>
    <div class='col-6 content-container' style='position: relative'>
        <form method="POST" action="{{ route('profile.update', $member->id) }}" class='p-2' autocomplete="off" >
            <div class="form-group row field">
                <label class="col-sm-4 col-form-label">My Referral Link:</label>
                <div class="col-sm-6">
                    <input type="text" id="copylink" class="form-control form-control-sm text-primary" value="{{ route('register', ['ref' => $member->referral_code]) }}" />
                </div>
                <div class="col-sm-2 ml-0 pl-0">
                    <button type="button" class="btn btn-dark btn-sm" onclick="Copy()">Copy Link</button>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-4 col-form-label">Member Name: </label>
                <div class="col-sm-6">
                    <span class="form-control form-control-sm border-0">{{ $member->firstname }} {{ $member->middlename }} {{ $member->lastname }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-4 col-form-label">Entry Type:</label>
                <div class="col-sm-6">
                    <span class="form-control form-control-sm border-0">{{ $member->placement->product->code }} | PHP {{ number_format($member->placement->product->price, 2) }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-4 col-form-label">Date Joined:</label>
                <div class="col-sm-6">
                    <span class="form-control form-control-sm border-0">{{ date('F d, Y H:i:s A', strtotime($member->created_at)) }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-4 col-form-label">Birth Date:</label>
                <div class="col-sm-6">
                    @if($member->birthdate)
                    <span class="form-control form-control-sm border-0">{{ date('F d, Y', strtotime($member->birthdate)) }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-4 col-form-label">Email:</label>
                <div class="col-sm-6">
                    <span class="form-control form-control-sm border-0">{{ $member->email }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-4 col-form-label">Mobile Number:</label>
                <div class="col-sm-6">
                    <span class="form-control form-control-sm border-0">{{ $member->mobile }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-4 col-form-label">Address:</label>
                <div class="col-sm-6">
                    <span class="form-control form-control-sm border-0">{{ $member->address }}</span>
                </div>
            </div>

        </form>
    </div>
    <div class='col-6 content-container' style='position: relative'>
        <form method="POST" action="{{ route('profile.update', $member->id) }}" class='p-2' autocomplete="off" >
            <div class="form-group row field">
                <label class="col-sm-6 col-form-label">Sales Matching Bonus:</label>
                <div class="col-sm-6">
                    <span class="form-control form-control-sm border-0">PHP {{ number_format($member->matching_pairs, 2) }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-6 col-form-label">Direct Referral Bonus: </label>
                <div class="col-sm-6">
                    <span class="form-control form-control-sm border-0">PHP {{ number_format($member->direct_referral, 2) }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-6 col-form-label">Encoding Bonus:</label>
                <div class="col-sm-6">
                    <span class="form-control form-control-sm border-0">PHP {{ number_format($member->encoding_bonus, 2) }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-6 pr-0 col-form-label">Package purchased using EWallet:</label>
                <div class="col-sm-6">
                    <span class="form-control form-control-sm border-0">PHP {{ number_format($member->purchased, 2) }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-6 col-form-label">Total Earnings:</label>
                <div class="col-sm-6">
                    <span class="form-control form-control-sm border-0">PHP {{ number_format($member->total_amt + $member->purchased, 2) }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-6 col-form-label">Current E-Wallet Amount:</label>
                <div class="col-sm-6">
                    <span class="form-control form-control-sm border-0">PHP {{ number_format($member->total_amt, 2) }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-6 col-form-label">Current Cycle:</label>
                <div class="col-sm-6">
                    @if($member->pair_cycle)
                    <span class="form-control form-control-sm border-0">{{ date('F d, Y', strtotime($member->pair_cycle->start_date)) }} to Present</span>
                    @else
                    <span class="form-control form-control-sm border-0">No cycle assigned &nbsp; 
                        <a href="{{ route('refresh.index') }}" class="btn btn-sm btn-success" style="margin-top: -3px;">Refresh Account</a>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-6 col-form-label">Current Pairs:</label>
                <div class="col-sm-6">
                    <span class="form-control form-control-sm border-0">{{ $member->pair_cycle_ctr }}</span>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('css')
    <link href="{{ asset('css/daterangepicker.css') }}"  rel="stylesheet">
@endsection

@section('javascripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script>
        $(function() {
            $("#birthdate").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: parseInt(moment().format('YYYY'),10),
                locale: {
                  format: 'YYYY-MM-DD'
                }
            }, function(start, end, label) {
                var years = moment().diff(start, 'years');
                alert("You are " + years + " years old!");
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