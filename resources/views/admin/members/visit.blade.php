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
    <link rel="stylesheet"  href="{{ asset('js/DataTables/datatables.min.css') }}" />
@endsection

@section('javascripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>
    <script>
        $('#visit-table').DataTable({
            "ajax": {
                "url": "{{ route('admin.member.visitdata') }}"
            },
            serverSide: true,
            responsive: true,
            processing: true,
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
    </script>
@endsection