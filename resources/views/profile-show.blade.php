@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Profile</title>
@endsection

@section('pagetitle')
    <i class="fa fa-user-circle"></i>  ACCOUNT INFORMATION
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
                    <?php 
                    $date2 = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $member->created_at); 
                    $date2->setTimezone($member->timezone);
                    ?>
                    <span class="form-control form-control-sm border-0">{{ $date2->format('F d, Y h:i A') }}</span>
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
                    <span class="form-control form-control-lg border-0" style="margin-top: -8px;"><strong>PHP {{ number_format($member->total_amt, 2) }}</strong></span>
                </div>
            </div>
            @if($member->has_credits)
            <div class="form-group row field">
                <label  class="col-sm-6 col-form-label">Credit Balance:</label>
                <div class="col-sm-6">
                    <span class="form-control form-control-sm border-0 text-danger"><strong>PHP {{ number_format($member->honorary->credit_amount, 2) }}</strong>
                        <a href="{{ route('settle.form') }}" class="btn btn-sm btn-success" style="margin-top: -3px; margin-left: 20px;">Settle Amount</a>
                    </span>
                </div>
            </div>
            @endif
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

<div class="row pt-0 px-3">
    <div class='col-12 pl-0 pr-0'>
        <div class="col-12 contentheader100">
            Cycle Pair List
        </div>
        <div class='col-12 content-container py-3' style='position: relative'>
            <div class="row">
                <div class="col-12">
                    <table id="leftTable" class=" datatables table table-hover table-bordered text-center small">
                        <thead>
                            <tr>
                                <th>Transaction Date</th>
                                <th>Transaction No</th>
                                <th>Left</th>
                                <th>Right</th>
                                <th>Amount</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class='col-12 pl-0 pr-0 py-3'>
        <div class="col-12 contentheader100">
            Purchased List
        </div>
        <div class='col-12 content-container py-3' style='position: relative'>
            <div class="row">
                <div class="col-12">
                    <table id="rightTable" class=" datatables table table-hover table-bordered text-center small">
                        <thead>
                            <tr>
                                <th>Transaction Date</th>
                                <th>Transaction No</th>
                                <th>Transaction Type</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="paynamicsCont" class='col-12 pl-0 pr-0 py-3'>
        <div class="col-12 contentheader100">
            Paynamics Transaction List
        </div>
        <div class='col-12 content-container py-3' style='position: relative'>
            <div class="row">
                <div class="col-12">
                    <table id="paynamicsTable" class=" datatables table table-hover table-bordered text-center small">
                        <thead>
                            <tr>
                                <th>Transaction Date</th>
                                <th>Transaction No</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total Amount</th>
                                <th>Response</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <span id="paynamics"></span>
    </div>
    @if($member->honorary)
    <div class='col-12 pl-0 pr-0 py-3'>
        <div class="col-12 contentheader100">
            Credit Balance
        </div>
        <div class='col-12 content-container py-3' style='position: relative'>
            <div class="row">
                <div class="col-12">
                    <table id="creditTable" class=" datatables table table-hover table-bordered text-center small">
                        <thead>
                            <tr>
                                <th>Transaction Date</th>
                                <th>Transaction No</th>
                                <th>Credit Balance</th>
                                <th>Amount Paid</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('css')
    <link href="{{ asset('css/daterangepicker.css') }}"  rel="stylesheet">
    <link rel="stylesheet"  href="{{ asset('js/DataTables/datatables.min.css') }}" />
    <style>
        #leftTable_filter {
            float: right;
        }
    </style>
@endsection

@section('javascripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>
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
        
        var lefttable = $('#leftTable').DataTable({
            serverSide: true,
            responsive: true,
            processing: true,
            "dom": 'f<"toolbar">rtip',
            "ajax": {
                url: "{{ route('profile.cycle', $member->id) }}",
                data: function ( d ) {
                    d.cycle_id = $('#cycle_id').val();
                }
            },
            "columns": [
                {
                    data: function ( row, type, set ) {
                        return moment.utc(row.transaction_date).tz('{{ $member->timezone }}').format('MMMM DD, YYYY hh:mm A');
                    }
                },
                {"data": "transaction_no"},
                {"data": "lusername"},
                {"data": "rusername"},
                {
                    data: function ( row, type, set ) {
                        return Number(row.acquired_amt).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                },
                {
                    data: function ( row, type, set ) {
                        switch(row.type)
                        {
                            case "MP":
                                return 'Matching Pair';
                                break;
                            case "FP":
                                return 'Flush Pair';
                                break;
                        }
                        return '';
                    }
                },
            ]
        });
        
        $("div.toolbar").html(
            '<select id="cycle_id" class="col-sm-3 form-control form-control-sm" onChange="drawTable()">'+
                @foreach($member->pair_cycles as $cycle)
                        @if ($loop->last)
                            '<option selected value="{{ $cycle->id }}">Cycle date from {{$cycle->start_date}} to {{($cycle->end_date) ? $cycle->end_date: "present"}}</option>'+
                        @else
                            '<option value="{{ $cycle->id }}">Cycle date from {{$cycle->start_date}} to {{($cycle->end_date) ? $cycle->end_date: "present"}}</option>'+
                        @endif
                @endforeach
            '</select>'
        );
    
        function drawTable() {
            lefttable.ajax.reload()
        }
        
        $('#rightTable').DataTable({
            "ajax": {
                "url": "{{ route('profile.purchased', $member->id) }}"
            },
            serverSide: true,
            responsive: true,
            processing: true,
            "columns": [
                {
                    data: function ( row, type, set ) {
                        return moment.utc(row.transaction_date).tz('{{ $member->timezone }}').format('MMMM DD, YYYY hh:mm A');
                    }
                },
                {"data": "transaction_no"},
                {"data": "transaction_type"},
                {"data": "product_code"},
                {
                    data: function ( row, type, set ) {
                        return Number(row.total_amount).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                },
                {
                    data: function ( row, type, set ) {
                        if(row.payment_method == 'ewallet') {
                            return row.payment_method + ': ' + row.payment_source.replace('_', ' ');
                        } else {
                            return row.payment_method;
                        }
                    }
                }
            ]
        });
        
        $('#paynamicsTable').DataTable({
            "ajax": {
                "url": "{{ route('profile.paynamics', $member->id) }}"
            },
            serverSide: true,
            responsive: true,
            processing: true,
            "columns": [
                {
                    data: function ( row, type, set ) {
                        return moment.utc(row.transaction_date).tz('{{ $member->timezone }}').format('MMMM DD, YYYY hh:mm A');
                    }
                },
                {"data": "transaction_no"},
                {"data": "name"},
                {"data": "quantity"},
                {
                    data: function ( row, type, set ) {
                        return Number(row.total_amount).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                },
                {
                    data: function ( row, type, set ) {
                        switch(row.status)
                        {
                            case "WR":
                                return 'Waiting';
                                break;
                            case "S":
                                return 'Status';
                                break;
                            case "F":
                                return 'Failed';
                                break;
                        }
                        return '';
                    }
                },
            ]
        });
        
        @if($member->honorary)
            $('#creditTable').DataTable({
                "ajax": {
                    "url": "{{ route('profile.credits', $member->id) }}"
                },
                serverSide: true,
                responsive: true,
                processing: true,
                "columns": [
                    {
                        data: function ( row, type, set ) {
                            return moment.utc(row.created_at).tz('{{ $member->timezone }}').format('MMMM DD, YYYY hh:mm A');
                        }
                    },
                    {"data": "transaction_no"},
                    {
                        data: function ( row, type, set ) {
                            return Number(row.credit_amount).toLocaleString("en", {minimumFractionDigits: 2});
                        }
                    },
                    {
                        data: function ( row, type, set ) {
                            return Number(row.amount_paid).toLocaleString("en", {minimumFractionDigits: 2});
                        }
                    },
                    {"data": "status"},
                ]
            });
        @endif
    </script>
@endsection