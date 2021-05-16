@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - Member Info</title>
@endsection

@section('module-content')

<div class="row p-3">
    <div class='col-12 contentheader100'>
        My Profile
        
        <span style='float: right; margin-right: 10px;'><a href='{{ route('admin.member.edit', $member->id) }}' class="btn btn-sm btn-success">Edit Profile</a></span>
    </div>
    <div class='col-6 content-container' style='position: relative'>
        <form class='p-2' autocomplete="off" onsubmit="return false;" >
            <div class="form-group row field">
                <label class="col-sm-4 col-form-label">My Referral Link:</label>
                <div class="col-sm-6">
                    <input type="text" id="copylink" class="form-control form-control-sm text-primary" value="{{ route('register', ['ref' => $member->referral_code]) }}" />
                </div>
                <div class="col-sm-2 ml-0 pl-0">
                    <button type="button" class="btn btn-dark btn-sm" onclick="Copy()">Copy</button>
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
                    <span class="form-control form-control-lg border-0" style="margin-top: -8px;"><strong>PHP {{ number_format($member->total_amt, 2) }}</strong></span>
                </div>
            </div>
            @if($member->has_credits)
            <div class="form-group row field">
                <label  class="col-sm-6 col-form-label">Credit Balance:</label>
                <div class="col-sm-6">
                    <span class="form-control form-control-sm border-0 text-danger"><strong>PHP {{ number_format($member->honorary->credit_amount, 2) }}</strong></span>
                </div>
            </div>
            @endif
            <div class="form-group row field">
                <label  class="col-sm-6 col-form-label">Current Cycle:</label>
                <div class="col-sm-6">
                    @if($member->pair_cycle)
                    <span class="form-control form-control-sm border-0">{{ date('F d, Y', strtotime($member->pair_cycle->start_date)) }} to Present</span>
                    @else
                    <span class="form-control form-control-sm border-0">No cycle assigned</span>
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
                url: "{{ route('admin.member.cycle', $member->id) }}",
                data: function ( d ) {
                    d.cycle_id = $('#cycle_id').val();
                }
            },
            "columns": [
                {
                    data: function ( row, type, set ) {
                        return moment(row.transaction_date).format('MMMM DD, YYYY, h:mm:ss a');
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
                "url": "{{ route('admin.member.purchased', $member->id) }}"
            },
            serverSide: true,
            responsive: true,
            processing: true,
            "columns": [
                {
                    data: function ( row, type, set ) {
                        return moment(row.transaction_date).format('MMMM DD, YYYY');
                    }
                },
                {"data": "transaction_no"},
                {"data": "transaction_type"},
                {"data": "product_code"},
                {
                    data: function ( row, type, set ) {
                        return Number(row.product_price).toLocaleString("en", {minimumFractionDigits: 2});
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
        
        @if($member->honorary)
            $('#creditTable').DataTable({
                "ajax": {
                    "url": "{{ route('admin.member.credits', $member->id) }}"
                },
                serverSide: true,
                responsive: true,
                processing: true,
                "columns": [
                    {
                        data: function ( row, type, set ) {
                            return moment(row.created_at).format('MMMM DD, YYYY');
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