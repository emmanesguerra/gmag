@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Encashment History</title>
@endsection

@section('pagetitle')
    <i class="fa fa-credit-card"></i>  TRANSACTIONS HISTORY
@endsection

@section('module-content')


<div class="row p-3">
    <div class='col-12 contentheader100'>
        CashOut Transactions
    </div>
    <div class='col-12 content-container py-3' style='position: relative'>
        @include('common.serverresponse')
        <div class="row">
            <div class="col-12">
                <table id='encashtable' class="table table-hover table-bordered text-center small">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date Requested</th>
                            <th>Request Type</th>
                            <th>Amount</th>
                            <th>Fullname</th>
                            <th>Mobile</th>
                            <th>Tracking No</th>
                            <th>Status</th>
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
                "url": "{{ route('wallet.history.data', $member->id) }}"
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
                {"data": "req_type"},
                {"data": "amount"},
                {"data": "name"},
                {"data": "mobile"},
                {"data": "tracking_no"},
                {
                    data: function ( row, type, set ) {
                        var stat = "";
                        switch(row.status) {
                            case "WA":
                                stat = "Waiting";
                                break;
                            case "C":
                                stat = "<span class='text-success'>Confirmed</span>";
                                break;
                            default:
                                stat = "<span class='text-danger'>Cancelled</span>";
                                break;
                        }
                        return stat;
                    }
                }
            ]
        });
    </script>
@endsection