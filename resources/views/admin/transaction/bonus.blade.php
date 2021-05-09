@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - Transaction Bonuses</title>
@endsection

@section('module-content')

@include('common.serverresponse')
<div class="row">
    <div class="col-12 py-3">
        <table id="transaction-table" class="table table-hover table-bordered text-center small">
            <thead>
                <tr>
                    <th>Date Created</th>
                    <th>Username</th>
                    <th>Member Name</th>
                    <th>Bonus From</th>
                    <th>Type</th>
                    <th>Amount</th>
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
                "url": "{{ route('admin.transactions.bonusdata') }}"
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
                { data: "username" },
                {
                    data: function ( row, type, set ) {
                        return row.firstname +' '+ row.lastname ;
                    }
                },
                {
                    data: function ( row, type, set ) {
                        if(row.type == 'MP' || row.type == 'FP') {
                            return row.field1 +'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+ row.field2 ;
                        } else {
                            return row.field1;
                        }
                    }
                },
                {
                    data: function ( row, type, set ) {
                        switch(row.type)
                        {
                            case "MP":
                                return 'Matching Pair';
                                break;
                            case "FP":
                                return 'Flush Pair';
                                break;
                            case "EB":
                                return 'Encoding Bonus';
                                break;
                            case "DR":
                                return 'Direct Referral';
                                break;
                        }
                    }
                },
                {
                    data: function ( row, type, set ) {
                        return Number(row.acquired_amt).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                },
            ],
            "order": [[ 0, "desc" ]]
        });
    </script>
@endsection