@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Switch Account</title>
@endsection

@section('pagetitle')
    <i class="fa fa-group"></i>   ALL ACCOUNTS SUMMARY
@endsection

@section('module-content')

<div class="row p-3">
    <div class='col-12 contentheader100'>
        All Account List
    </div>
    <div class='col-12 content-container py-3' style='position: relative'>
        @include('common.serverresponse')
        <div class="row">
            <div class="col-12">
                <table id="switch-table" class="table table-hover table-bordered text-center small">
                    <thead>
                        <tr>
                            <th>Date Registered</th>
                            <th>ID No.</th>
                            <th>UserName</th>
                            <th>Name</th>
                            <th>Income</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        
    </div>
</div>
@endsection

@section('css')
    <link rel="stylesheet"  href="{{ asset('js/DataTables/datatables.min.css') }}" />
@endsection

@section('javascripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>
    <script>
        $('#switch-table').DataTable({
            "ajax": {
                "url": "{{ route('switch.data') }}"
            },
            serverSide: true,
            responsive: true,
            processing: true,
            "columns": [
                {
                    data: function ( row, type, set ) {
                        return moment(row.created_at).format('MMMM DD, YYYY h:m A');
                    }
                },
                {"data": "id"},
                {"data": "username"},
                {
                    data: function ( row, type, set ) {
                        return row.firstname + " " + row.lastname;
                    }
                },
                {
                    data: function ( row, type, set ) {
                        return Number(row.total_amt).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                },
                {
                    data: function (row, type, set) {
                        return '<a href="/switch-acount/'+row.id+'">Switch</a>';
                    }
                }
            ],
            "order": [[ 1, "desc" ]]
        });
    </script>
@endsection