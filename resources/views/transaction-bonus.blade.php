@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Transaction Bonus</title>
@endsection

@section('pagetitle')
    <i class="fa fa-chart-bar"></i>   BONUSES SUMMARY
@endsection

@section('module-content')

<div class="row p-3">
    <div class='col-12 contentheader100'>
        Incentives List
    </div>
    <div class='col-12 content-container py-3' style='position: relative'>
        
        @include('common.serverresponse')
        <div class="row">
            <div class="col-12">
                <table id="bonus-table" class="table table-hover table-bordered text-center small">
                    <thead>
                        <tr>
                            <th>Transaction Date</th>
                            <th>Transaction No</th>
                            <th>Bonus From</th>
                            <th>Bonus Type</th>
                            <th>Acquired Amount</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        
    </div>
</div>
@endsection

@section('css')
    <link href="{{ asset('css/daterangepicker.css') }}"  rel="stylesheet">
    <link rel="stylesheet"  href="{{ asset('js/DataTables/datatables.min.css') }}" />
    <style>
        div.dataTables_length,
        div.dataTables_info,
        div.paging_simple_numbers,
        div.dataTables_filter {
            float: right;
        }
        div.dataTables_info,
        div.paging_simple_numbers {
            width: 50%;
        }
        div.dataTables_length {
            float: left;
            width: 20%;
        }
        div.toolbar.dataTables_filter {
            width: 55%;
            float: left;
        }
        div.toolbar select {
            width: auto;
            display: inline-block;
        }
    </style>
@endsection

@section('javascripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/daterange.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>
    <script>
        
        var start = moment('{{ GmagHelpers::getStartingDate() }}');
        var end = moment();
        
        var table = $('#bonus-table').DataTable({
            "ajax": {
                "url": "{{ route('transactions.bonusdata', $memberId) }}",
                data: function ( d ) {
                    d.status = $('#status').val();
                    d.start_date = start.format('Y-MM-DD');
                    d.end_date = end.format('Y-MM-DD');
                }
            },
            serverSide: true,
            responsive: true,
            processing: true,
            "dom": 'l<"toolbar dataTables_filter">frtpi',
            "columns": [
                {
                    data: function ( row, type, set ) {
                        return moment.utc(row.created_at).tz(utimezone).format('MMMM DD, YYYY hh:mm A');
                    }
                },
                { data: "transaction_no"},
                {
                    data: function ( row, type, set ) {
                        if(row.type == 'MP' || row.type == 'FP') {
                            return row.field1 +'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+ row.field2 ;
                        } else {
                            return row.field1;
                        }
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
                            case "EB":
                                return 'Encoding Bonus';
                                break;
                            case "DR":
                                return 'Direct Referral';
                                break;
                        }
                    }
                },
                {
                    data: function ( row, type, set ) {
                        return Number(row.acquired_amt).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                },
            ],
            "order": [[ 0, "desc" ]]
        });
        
        $("div.toolbar").html(
            '<label style="float: left;">Display <select id="status" class="custom-select custom-select-sm" onChange="drawTable()">'+
                '<option value="">All</option>'+
                '<option value="DR">Direct Referral</option>'+
                '<option value="EB">Encoding Bonus</option>'+
                '<option value="MP">Matching Pair</option>'+
                '<option value="FP">Flush Pair</option>'+
            '</select></label>' +
            '<div id="reportrange" class="btn" style="margin-top: -4px">'+
                '<i class="fa fa-calendar"></i>&nbsp;'+
                '<span></span> <i class="fa fa-caret-down"></i>'+
            '</div>'
        );
    
        function drawTable() {
            table.ajax.reload();
        }
    </script>
@endsection