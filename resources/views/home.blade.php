@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Dashboard</title>
@endsection

@section('pagetitle')
<i class="fas fa-tachometer-alt"></i>  Dashboard
@endsection

@section('module-content')

<div class="row pb-0 px-3 pt-3">
    <div class='col-12 p-0' style="background-image: linear-gradient(to bottom right, #fff , #fff , #edebb1); border-radius: 6px;">
        <div class='col-12 contentheader100'>
            Total Earnings
        </div>
        <div class='col-12 contentbody100 p-3'>
            <span class="dashamount">{{ number_format($member->total_amt, 2) }} <sup>PHP</sup></span>
            <i class="fa fa-university pb-1" style="color: #bba701"></i>
        </div>
    </div>
</div>

<div class="row pb-0 px-3 pt-3">
    <div class='col-4 pl-0'>
        <div class='col-12 contentheader100'>
            Indirect Bonus <small>(Not Qualified)</small>
        </div>
        <div class='col-12 contentbody100 p-3' style="background-image: linear-gradient(to bottom right, #fff , #fff , #fadcae); border-radius: 0 0 6px 6px;">
            <span class="dashamount">0.00 <sup>PHP</sup></span>
            <i class="fa fa-group pb-1" style="color: #f9bd61"></i>
        </div>
    </div>
    <div class='col-4 px-0'>
        <div class='col-12 contentheader100'>
            Encoding Bonus <small>(Qualified)</small>
        </div>
        <div class='col-12 contentbody100 p-3' style="background-image: linear-gradient(to bottom right, #fff , #fff , #f8daab); border-radius: 0 0 6px 6px;">
            <span class="dashamount">{{ number_format($member->encoding_bonus, 2) }} <sup>PHP</sup></span>
            <i class="fa fa-pencil-square-o pb-1" style="color: #f89c0e"></i>
        </div>
    </div>
    <div class='col-4 pr-0'>
        <div class='col-12 contentheader100'>
            Sales Match Bonus
        </div>
        <div class='col-12 contentbody100 p-3' style="background-image: linear-gradient(to bottom right, #fff , #fff , #ee907d); border-radius: 0 0 6px 6px;">
            <span class="dashamount">{{ number_format($member->matching_pairs, 2) }} <sup>PHP</sup></span>
            <i class="fa fa-star pb-1" style="color: #e63816"></i>
        </div>
    </div>
</div>

<div class="row pb-0 px-3 pt-3">
    <div class='col-4 pl-0'>
        <div class='col-12 contentheader100'>
            Unilevel Bonus
        </div>
        <div class='col-12 contentbody100 p-3' style="background-image: linear-gradient(to bottom right, #fff , #fff , #f6e8c4); border-radius: 0 0 6px 6px;">
            <span class="dashamount">0.00 <sup>PHP</sup></span>
            <i class="fa fa-shopping-bag pb-1" style="color: #f4d070"></i>
        </div>
    </div>
    <div class='col-4 px-0 '>
        <div class='col-12 contentheader100'>
            Direct Referral
        </div>
        <div class='col-12 contentbody100 p-3' style="background-image: linear-gradient(to bottom right, #fff , #fff , #ba9b85); border-radius: 0 0 6px 6px;">
            <span class="dashamount">{{ number_format($member->direct_referral, 2) }} <sup>PHP</sup></span>
            <i class="fas fa-gift pb-1" style="color: #c46626"></i>
        </div>
    </div>
    <div class='col-4 pr-0'>
        <div class='col-12 contentheader100'>
            Flush Points
        </div>
        <div class='col-12 contentbody100 p-3' style="background-image: linear-gradient(to bottom right, #fff , #fff , #ccc); border-radius: 0 0 6px 6px;">
            <span class="dashamount">{{ ($member->flush_pts) ? $member->flush_pts: 0 }} <sup>POINTS</sup></span>
            <i class="fas fa-cubes pb-1" style="color: #999"></i>
        </div>
    </div>
</div>

<div class="row p-3">
    <div class='col-12 contentheader100'>
        Account Binary Status
    </div>
    <div class='col-12 content-container' style='position: relative'>
        <form class='no-edit p-2' >
            <div class="form-group row field">
                <label class="col-sm-3 col-form-label">My Referral Link:</label>
                <div class="col-sm-4">
                    <input type="text" id="copylink" class="form-control form-control-sm text-primary" value="{{ route('register', ['ref' => $member->referral_code]) }}" />
                </div>
                <div class="col-sm-3 ml-0 pl-0">
                    <button type="button" class="btn btn-dark btn-sm" onclick="Copy()">Copy Link</button>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Today's Pair Count:</label>
                <div class="col-sm-4">
                    <span class="form-control form-control-lg border-0">{{ $counts['tspc'] }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Yesterday's Pair Count:</label>
                <div class="col-sm-4">
                    <span class="form-control form-control-lg border-0">{{ $counts['yspc'] }}</span>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12 head">Current Cycle</div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Cycle Start:</label>
                <div class="col-sm-4">
                    @if($member->pair_cycle)
                    <span class="form-control form-control-lg border-0">{{ date('F d, Y', strtotime($member->pair_cycle->start_date)) }}</span>
                    @else
                    <span class="form-control form-control-lg border-0">No cycle assigned</span>
                    @endif
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Maximum Pairs Per Cycle:</label>
                <div class="col-sm-4">
                    @if($member->pair_cycle)
                    <span class="form-control form-control-lg border-0">{{ $member->pair_cycle->max_pair }}</span>
                    @else
                    <span class="form-control form-control-lg border-0">0</span>
                    @endif
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Match Sales Pair Count:</label>
                <div class="col-sm-4">
                    <span class="form-control form-control-lg border-0">{{ ($member->pair_cycle_ctr) ? $member->pair_cycle_ctr : 0 }}</span>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12 head">Overall Pairs</div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Total Pairs Count: </label>
                <div class="col-sm-4">
                    <span class="form-control form-control-lg border-0">{{ $counts['tpc'] }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Match Sales Pairs Count:</label>
                <div class="col-sm-4">
                    <span class="form-control form-control-lg border-0">{{ $counts['mspc'] }}</span>
                </div>
            </div>
            <div class="form-group row field">
                <label  class="col-sm-3 col-form-label">Flush Pairs Count:</label>
                <div class="col-sm-4">
                    <span class="form-control form-control-lg border-0">{{ $counts['fpc'] }}</span>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection


@section('javascripts')
    <script>
        
        function Copy() {
            var copyText = document.getElementById("copylink");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            alert("Link copied to clipboard");
        }
    </script>
@endsection