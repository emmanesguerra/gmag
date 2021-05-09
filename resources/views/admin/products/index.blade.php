@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - Products</title>
@endsection

@section('module-content')

@include('common.serverresponse')
<div class="row">
    <div class="col-12 py-3">
        <table id="product-table" class="table table-hover table-striped text-center small">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Product Value</th>
                    <th>Flush Bonus Pts</th>
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
        $('#product-table').DataTable({
            "ajax": {
                "url": "{{ route('admin.products.data') }}"
            },
            serverSide: true,
            responsive: true,
            processing: true,
            "columns": [
                {"data": "id"},
                {"data": "code"},
                {"data": "name"},
                {
                    data: function ( row, type, set ) {
                        return Number(row.price).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                },
                {"data": "product_value"},
                {"data": "flush_bonus"},
                {
                    data: function ( row, type, set ) {
                        return "<a href='/admin/products/"+row.slug+"'>View</a> | <a href='/admin/products/"+row.slug+"/edit'>Edit</a>";
                    }
                }
            ],
            "order": [[ 0, "desc" ]]
        });
    </script>
@endsection