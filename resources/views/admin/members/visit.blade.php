@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - Access logs</title>
@endsection

@section('module-content')
@include('common.serverresponse')
<div class="row">
    <div class="col-12 py-3">
        <table id="visit-table" class="table table-hover table-striped text-center small">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Login Date</th>
                    <th>Ip Address</th>
                    <th>Username</th>
                </tr>
            </thead>
        </table>
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
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/daterange.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>
    <script>
        
        var start = moment('{{ env('GO_LIVE') }}');
        var end = moment();
        
        var table = $('#visit-table').DataTable({
            "ajax": {
                "url": "{{ route('admin.member.visitdata') }}",
                data: function ( d ) {
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
                        return moment(row.log_in).format('MMMM DD, YYYY hh:mm A');
                    }
                },
                {"data": "ip_address"},
                {"data": "username"}
            ],
            "order": [[ 0, "desc" ]]
        });
        
        $("div.toolbar").html(
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