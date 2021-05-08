@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Genealogy Lists</title>
@endsection

@section('pagetitle')
    <i class="fa fa-sitemap"></i>   PARTNERS SUMMARY
@endsection

@section('module-content')


<div class="row p-3">
    <div class='col-12 contentheader100'>
        Genealogy List
    </div>
    <div class='col-12 content-container py-3' style='position: relative'>
        @include('common.serverresponse')
        <div class="row">
            <div class="col-12">
                <table id="geneology-table" class="table table-hover table-bordered text-center small">
                    <thead>
                        <tr>
                            <th>Date Registered</th>
                            <th>Member Username</th>
                            <th>Member Name</th>
                            <th>Level</th>
                            <th>Entry Type</th>
                            <th>Sponsor</th>
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
        $('#geneology-table').DataTable({
            "ajax": {
                "url": "{{ route('gtree.genealogydata', $member->id) }}"
            },
            serverSide: true,
            responsive: true,
            processing: true,
            "columns": [
                {
                    data: function ( row, type, set ) {
                        return moment(row.created_at).format('MMMM DD, YYYY hh:mm A');
                    }
                },
                {"data": "username"},
                {
                    data: function ( row, type, set ) {
                        return row.firstname + " " + row.lastname;
                    }
                },
                {
                    data: function ( row, type, set ) {
                        return row.lvl - {{ $lvl }};
                    }
                },
                {
                    data: function ( row, type, set ) {
                        return row.name + " | " + Number(row.price).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                },
                {"data": "sponsor"}
            ]
        });
    </script>
@endsection