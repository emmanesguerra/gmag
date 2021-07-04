@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Code Vault</title>
@endsection

@section('pagetitle')
    <i class="fa fa-folder-open"></i>  CODE VAULT
@endsection

@section('module-content')


<div class="row p-3">
    <div class='col-12 contentheader100'>
        Entry Codes
    </div>
    <div class='col-12 content-container py-3' style='position: relative'>
        @include('common.serverresponse')
        <div class="row">
            <div class="col-12">
                <table id='encashtable' class="table table-hover table-bordered text-center small">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date Created</th>
                            <th>Pincode 1</th>
                            <th>Pincode 2</th>
                            <th>Package Type</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Remarks</th>
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
        
        var table = $('#encashtable').DataTable({
            "ajax": {
                "url": "{{ route('codevault.data', $member->id) }}",
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
                {"data": "id"},
                {
                    data: function ( row, type, set ) {
                        return moment.utc(row.created_at).tz(utimezone).format('MMMM DD, YYYY hh:mm A');
                    }
                },
                {"data": "pincode1"},
                {"data": "pincode2"},
                {"data": "name"},
                {
                    data: function ( row, type, set ) {
                        return Number(row.price).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                },
                {
                    searchable: false,
                    data: function ( row, type, set ) {
                        return (row.is_used) ? 'Used' : 'Available';
                    }
                },
                {
                    data: "remarks",
                    render: function ( data, type, set ) {
                        console.log(data);
                        return data.split("\\n").join("<br/>");
                    }
                },
            ],
            "order": [[ 0, "desc" ]]
        });
        
        $("div.toolbar").html(
            '<label style="float: left;">Display <select id="status" class="custom-select custom-select-sm" onChange="drawTable()">'+
                '<option value="">All</option>'+
                '<option value="0">Available</option>'+
                '<option value="1">Used</option>'+
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