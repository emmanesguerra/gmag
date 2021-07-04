@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - Payout Accounts</title>
@endsection

@section('module-content')
@include('common.serverresponse')
<div class="row">
    <div class="col-12 py-3">
        <table id="member-table" class="table table-hover table-striped text-center small">
            <thead>
                <tr>
                    <th>Date Created</th>
                    <th>Active</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Email</th>
                    <th>Mobile</th>
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
        
        .modal-dialog {
            margin-top: 10rem;
        }
        .fade:not(.show) {
            opacity: 1;
            background: #00000087;
            margin-top: 3;
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
        
        var payoutindex = '{{ route('payout.accounts.index') }}';
        var start = moment('{{ GmagHelpers::getStartingDate() }}');
        var end = moment();
        
        var table = $('#member-table').DataTable({
            "ajax": {
                "url": "{{ route('payout.accounts.data') }}",
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
                        return moment.utc(row.created_at).tz(utimezone).format('MMMM DD, YYYY hh:mm A');
                    }
                },
                {
                    data: function ( row, type, set ) {
                        return (row.should_use) ? 'Active': '<a href="'+payoutindex+ '/' +row.id+'/active">Set Active</a>';
                    }
                },
                {
                    data: function ( row, type, set ) {
                        return row.firstname + ' ' + row.lastname;
                    }
                },
                {
                    data: function ( row, type, set ) {
                        return row.address1 + ' ' + row.address2;
                    }
                },
                {"data": "city"},
                {"data": "country"},
                {"data": "email"},
                {"data": "mobile"},
                {
                    data: function ( row, type, set ) {
                        return '<a href="'+payoutindex+ '/' +row.id+'/edit">Edit</a> | <a href="#" onclick="showdeletemodal(\''+row.id+'\', \'\', \'/admin/entry-codes/'+row.id+'\')" class="text-danger" >Delete</a>';
                    }
                }
            ],
            "order": [[ 1, "desc" ]]
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