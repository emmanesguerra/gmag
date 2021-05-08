@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Binary Lists</title>
@endsection

@section('pagetitle')
<i class="fa fa-sitemap"></i>   PARTNERS SUMMARY
@endsection

@section('module-content')


<div class="row p-3">
    <div class='col-6 pl-0'>
        <div class="col-12 contentheader100">
            LEFT Member List
        </div>
        <div class='col-12 content-container py-3' style='position: relative'>
            <div class="row">
                <div class="col-12">
                    <table id="leftTable" class=" datatables table table-hover table-bordered text-center small">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Username</th>
                                <th>Entry Type</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class='col-6 pl-0 pr-0'>
        <div class="col-12 contentheader100">
            RIGHT Member List
        </div>
        <div class='col-12 content-container py-3' style='position: relative'>
            <div class="row">
                <div class="col-12">
                    <table id="rightTable" class=" datatables table table-hover table-bordered text-center small">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Username</th>
                                <th>Entry Type</th>
                            </tr>
                        </thead>
                    </table>
                </div>
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
        $('#leftTable').DataTable({
            "ajax": {
                "url": "{{ route('gtree.binary.left') }}"
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
                        return row.code + " | " + Number(row.price).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                }
            ]
        });
        
        $('#rightTable').DataTable({
            "ajax": {
                "url": "{{ route('gtree.binary.right') }}"
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
                        return row.code + " | " + Number(row.price).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                }
            ]
        });
    </script>
@endsection