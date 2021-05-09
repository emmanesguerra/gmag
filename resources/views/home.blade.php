@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Dashboard</title>
@endsection

@section('pagetitle')
<i class="fas fa-user-circle"></i>  Dashboard
@endsection

@section('module-content')

<div class="row pb-0 px-3 pt-3">
    <div class='col-12 p-0' style="background-image: linear-gradient(to bottom right, #fff , #fff , #edebb1); border-radius: 6px;">
        <div class='col-12 contentheader100'>
            Current E-Wallet Amount
            
            <div id="reportrange" class='float-right btn btn-sm btn-dark small' style='margin-top: -4px'>
                <i class="fa fa-calendar"></i>&nbsp; 
                <span></span> <i class="fa fa-caret-down"></i>
            </div>
        </div>
        <div class='col-12 contentbody100 p-3'>
            <span class="dashamount" id='curr_amount'>{{ number_format($member->total_amt, 2) }} <sup>PHP</sup></span>
            <i class="fa fa-university pb-1" style="color: #bba701"></i>
        </div>
    </div>
</div>

<div class="row pb-0 px-3 pt-3">
    <div class='col-4 pl-0'>
        <div class='col-12 contentheader100'>
            Direct Referral
        </div>
        <div class='col-12 contentbody100 p-3' style="background-image: linear-gradient(to bottom right, #fff , #fff , #fadcae); border-radius: 0 0 6px 6px;">
            <span class="dashamount" id='direct_referral'>{{ number_format($member->direct_referral, 2) }} <sup>PHP</sup></span>
            <i class="fa fa-users pb-1" style="color: #f9bd61"></i>
        </div>
    </div>
    <div class='col-4 px-0'>
        <div class='col-12 contentheader100'>
            Encoding Bonus <small>(Qualified)</small>
        </div>
        <div class='col-12 contentbody100 p-3' style="background-image: linear-gradient(to bottom right, #fff , #fff , #f8daab); border-radius: 0 0 6px 6px;">
            <span class="dashamount" id='encoding_bonus'>{{ number_format($member->encoding_bonus, 2) }} <sup>PHP</sup></span>
            <i class="fa fa-edit pb-1" style="color: #f89c0e"></i>
        </div>
    </div>
    <div class='col-4 pr-0'>
        <div class='col-12 contentheader100'>
            Sales Match Bonus
        </div>
        <div class='col-12 contentbody100 p-3' style="background-image: linear-gradient(to bottom right, #fff , #fff , #ee907d); border-radius: 0 0 6px 6px;">
            <span class="dashamount" id='sales_match_bonus'>{{ number_format($member->matching_pairs, 2) }} <sup>PHP</sup></span>
            <i class="fa fa-star pb-1" style="color: #e63816"></i>
        </div>
    </div>
</div>

<div class="row pb-0 px-3 pt-3">
    <div class='col-4 pl-0'>
        <div class='col-12 contentheader100'>
            Transactions Paid via E-Wallet
        </div>
        <div class='col-12 contentbody100 p-3' style="background-image: linear-gradient(to bottom right, #fff , #fff , #f6e8c4); border-radius: 0 0 6px 6px;">
            <span class="dashamount" id='ewallet_purchased'>{{ number_format($member->purchased, 2) }} <sup>PHP</sup></span>
            <i class="fa fa-shopping-bag pb-1" style="color: #f4d070"></i>
        </div>
    </div>
    <div class='col-4 px-0 '>
        <div class='col-12 contentheader100'>
            Total Earnings
        </div>
        <div class='col-12 contentbody100 p-3' style="background-image: linear-gradient(to bottom right, #fff , #fff , #ba9b85); border-radius: 0 0 6px 6px;">
            <span class="dashamount" id='total_earnings'>{{ number_format($member->total_amt + $member->purchased, 2) }} <sup>PHP</sup></span>
            <i class="fas fa-gift pb-1" style="color: #c46626"></i>
        </div>
    </div>
    <div class='col-4 pr-0'>
        <div class='col-12 contentheader100'>
            Flush Points
        </div>
        <div class='col-12 contentbody100 p-3' style="background-image: linear-gradient(to bottom right, #fff , #fff , #ccc); border-radius: 0 0 6px 6px;">
            <span class="dashamount" id='flush_points'>{{ ($member->flush_pts) ? $member->flush_pts: 0 }} <sup>POINTS</sup></span>
            <i class="fas fa-cubes pb-1" style="color: #999"></i>
        </div>
    </div>
</div>

<div class="row p-3">
    <div id='binary_status' class='col-12 contentheader100'>
        Account Binary Status
    </div>
    <div class='col-12 content-container' style='position: relative'>
        <form class='no-edit p-2' >
            @include('common.serverresponse')
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
                    <span class="form-control form-control-lg border-0">No cycle assigned &nbsp; <a href="{{ route('refresh.index') }}" class="btn btn-sm btn-success">Refresh Account</a></span>
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


@section('css')
    <link href="{{ asset('css/daterangepicker.css') }}"  rel="stylesheet">
@endsection

@section('javascripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script>
        
        $(function() {
        
            var start = moment();
            var end = moment();

            function cb(start, end) {
                if(start.format('MMMM D, YYYY') == end.format('MMMM D, YYYY')) {
                    $('#reportrange span').html('Display Earnings as of ' + start.format('MMMM D, YYYY'));
                }else {
                    $('#reportrange span').html( 'Display Earnings from ' + start.format('MMMM D, YYYY') + ' to ' + end.format('MMMM D, YYYY'));
                }
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                alwaysShowCalendars: true,
                autoApply: false,
                linkedCalendars: false,
                ranges: {
                   'Today': [moment(), moment()],
                   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                   'This Month': [moment().startOf('month'), moment().endOf('month')],
                   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);
            $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
                $.ajax({
                    url: '{{ route("home.earnings") }}',
                    data: {
                        start: picker.startDate.format('YYYY-MM-DD'),
                        end: picker.endDate.format('YYYY-MM-DD'),
                        member_id: {{ $member->id }}
                    }
                }).done(function(response) {
                    $('#curr_amount').html(Number(response.curr).toLocaleString("en", {minimumFractionDigits: 2}) + ' <sup>PHP</sup>' );
                    $('#direct_referral').html(Number(response.dr).toLocaleString("en", {minimumFractionDigits: 2}) + ' <sup>PHP</sup>');
                    $('#encoding_bonus').html(Number(response.eb).toLocaleString("en", {minimumFractionDigits: 2}) + ' <sup>PHP</sup>');
                    $('#sales_match_bonus').html(Number(response.mp).toLocaleString("en", {minimumFractionDigits: 2}) + ' <sup>PHP</sup>');
                    $('#ewallet_purchased').html(Number(response.ewallet_purchased).toLocaleString("en", {minimumFractionDigits: 2}) + ' <sup>PHP</sup>');
                    $('#total_earnings').html(Number(response.te).toLocaleString("en", {minimumFractionDigits: 2}) + ' <sup>PHP</sup>' );
                    $('#flush_points').html(response.fp + ' <sup>POINTS</sup>');
                });
            });

            cb(start, end);
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