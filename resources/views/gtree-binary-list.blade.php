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
                    <table id="leftTable" class=" datatables table table-hover table-bordered text-center">
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
                    <table id="rightTable" class=" datatables table table-hover table-bordered text-center">
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

@section('javascripts')
    <link rel="stylesheet"  href="{{ asset('js/DataTables/datatables.min.css') }}" />
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
                {"data": "created_at"},
                {"data": "username"},
                {
                    data: function ( row, type, set ) {
                        return row.code + " | " + row.price;
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
                {"data": "created_at"},
                {"data": "username"},
                {
                    data: function ( row, type, set ) {
                        return row.code + " | " + row.price;
                    }
                }
            ]
        });
    </script>
@endsection