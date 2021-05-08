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
                    <th>ID</th>
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
    <link rel="stylesheet"  href="{{ asset('js/DataTables/datatables.min.css') }}" />
@endsection

@section('javascripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>
    <script>
        $('#member-table').DataTable({
            "ajax": {
                "url": "{{ route('admin.member.data') }}"
            },
            serverSide: true,
            responsive: true,
            processing: true,
            "columns": [
                {"data": "id"},
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
                        return "<a href='/admin/members/"+row.id+"'>View</a> | <a href='/admin/members/"+row.id+"/edit'>Edit</a>";
                    }
                }
            ],
            "order": [[ 0, "desc" ]]
        });
    </script>
@endsection