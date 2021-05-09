@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - Entry Codes</title>
@endsection

@section('module-content')

@include('common.serverresponse')
<div class="row">
    <div class="col-12 py-3">
        <table id="entrycodes-table" class="table table-hover table-striped text-center small">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date Created</th>
                    <th>Assigned To</th>
                    <th>Pincode 1</th>
                    <th>Pincode 2</th>
                    <th>Created By</th>
                    <th>Package Type</th>
                    <th>Price</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('css')
    <link rel="stylesheet"  href="{{ asset('js/DataTables/datatables.min.css') }}" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('javascripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>
    <script>
        $('#entrycodes-table').DataTable({
            "ajax": {
                "url": "{{ route('admin.entrycodes.data') }}"
            },
            serverSide: true,
            responsive: true,
            processing: true,
            "columns": [
                {"data": "id"},
                {
                    data: function ( row, type, set ) {
                        return moment(row.created_at).format('MMMM DD, YYYY hh:mm A');
                    }
                },
                {"data": "assignto"},
                {"data": "pincode1"},
                {"data": "pincode2"},
                {"data": "creator"},
                {"data": "name"},
                {
                    data: function ( row, type, set ) {
                        return Number(row.price).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                },
                {
                    data: "remarks",
                    render: function ( data, type, set ) {
                        return data.split("\\n").join("<br/>");
                    }
                },
                {
                    searchable: false,
                    orderable: false,
                    data: function ( row, type, set ) {
                        return '<a href="#" onclick="showdeletemodal(\''+row.id+'\', \'\', \'/admin/entry-codes/'+row.id+'\')" >Delete</a>';
                    }
                }
            ],
            "order": [[ 0, "desc" ]]
        });
    </script>
@endsection