@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - Transactions</title>
@endsection

@section('module-content')

@include('common.serverresponse')
<div class="row">
    <div class="col-12 py-3">
        <table id="transaction-table" class="table table-hover table-striped text-center small">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Product Code</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>Transaction Date</th>
                    <th>Transaction Type</th>
                    <th>Payment Method</th>
                    <th>Package Claimed</th>
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
        $('#transaction-table').DataTable({
            "ajax": {
                "url": "{{ route('admin.transactions.data') }}"
            },
            serverSide: true,
            responsive: true,
            processing: true,
            "columns": [
                {"data": "id"},
                {
                    data: function ( row, type, set ) {
                        return row.firstname + ' ' + row.lastname;
                    }
                },
                {"data": "product_code"},
                {
                    data: function ( row, type, set ) {
                        return Number(row.product_price).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                },
                {"data": "quantity"},
                {
                    data: function ( row, type, set ) {
                        return Number(row.total_amount).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                },
                {
                    data: function ( row, type, set ) {
                        return moment(row.transaction_date).format('MMMM DD, YYYY hh:mm A');
                    }
                },
                {"data": "transaction_type"},
                {
                    data: function ( row, type, set ) {
                        if(row.payment_method == 'ewallet') {
                            return row.payment_method + ': ' + row.payment_source.replace('_', ' ');
                        } else {
                            return row.payment_method;
                        }
                    }
                },
                {
                    data: function ( row, type, set ) {
                        return (row.package_claimed) ? 'Yes' : 'No';
                    }
                }
            ],
            "order": [[ 0, "desc" ]]
        });
    </script>
@endsection