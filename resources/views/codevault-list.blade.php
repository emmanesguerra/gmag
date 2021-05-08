@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Code Vault</title>
@endsection

@section('pagetitle')
    <i class="fa fa-folder-open"></i>  CODE VAULT
@endsection

@section('module-content')


<div class="row p-3">
    <div class='col-12 contentheader100'>
        Entry Codes
    </div>
    <div class='col-12 content-container py-3' style='position: relative'>
        @include('common.serverresponse')
        <div class="row">
            <div class="col-12">
                <table id='encashtable' class="table table-hover table-bordered text-center small">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date Created</th>
                            <th>Pincode 1</th>
                            <th>Pincode 2</th>
                            <th>Package Type</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Remarks</th>
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
        
        $('#encashtable').DataTable({
            "ajax": {
                "url": "{{ route('codevault.data', $member->id) }}"
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
                {"data": "pincode1"},
                {"data": "pincode2"},
                {"data": "name"},
                {
                    data: function ( row, type, set ) {
                        return Number(row.price).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                },
                {
                    searchable: false,
                    data: function ( row, type, set ) {
                        return (row.is_used) ? 'Used' : 'Available';
                    }
                },
                {
                    data: "remarks",
                    render: function ( data, type, set ) {
                        console.log(data);
                        return data.split("\\n").join("<br/>");
                    }
                },
            ],
            "order": [[ 0, "desc" ]]
        });
    </script>
@endsection