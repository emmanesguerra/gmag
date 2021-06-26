@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - Members</title>
@endsection

@section('module-content')
@include('common.serverresponse')
<div class="row">
    <div class="col-12 py-3">
        <table id="member-table" class="table table-hover table-striped text-center small">
            <thead>
                <tr>
                    <th>Date Created</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Sponsor</th>
                    <th>Matching Pair</th>
                    <th>Direct Referral</th>
                    <th>Encoding Bonus</th>
                    <th>Total Amount</th>
                    <th>Flush Points</th>
                    <th>Action</th>
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
        
        var start = moment('{{ GmagHelpers::getStartingDate() }}');
        var end = moment();
        var indexurl = "{{ route('admin.member.index') }}";
        
        var table = $('#member-table').DataTable({
            "ajax": {
                "url": "{{ route('admin.member.data') }}",
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
                {
                    data: function ( row, type, set ) {
                        return moment(row.created_at).format('MMMM DD, YYYY hh:mm A');
                    }
                },
                {"data": "username"},
                {
                    data: function ( row, type, set ) {
                        return row.firstname + ' ' + row.lastname;
                    }
                },
                {"data": "sponsor"},
                {
                    data: function ( row, type, set ) {
                        return Number(row.matching_pairs).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                },
                {
                    data: function ( row, type, set ) {
                        return Number(row.direct_referral).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                },
                {
                    data: function ( row, type, set ) {
                        return Number(row.encoding_bonus).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                },
                {
                    data: function ( row, type, set ) {
                        return Number(row.total_amt).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                },
                {"data": "flush_pts"},
                {
                    data: function ( row, type, set ) {
                        return "<a href='"+indexurl+'/'+row.id+"'>View</a> | <a href='"+indexurl+'/'+row.id+"/edit'>Edit</a>";
                    }
                }
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