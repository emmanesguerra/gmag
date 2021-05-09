@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Transaction Bonus</title>
@endsection

@section('pagetitle')
    <i class="fa fa-chart-bar"></i>   BONUSES SUMMARY
@endsection

@section('module-content')

<div class="row p-3">
    <div class='col-12 contentheader100'>
        Incentives List
    </div>
    <div class='col-12 content-container py-3' style='position: relative'>
        
        @include('common.serverresponse')
        <div class="row">
            <div class="col-12">
                <table id="bonus-table" class="table table-hover table-bordered text-center small">
                    <thead>
                        <tr>
                            <th>Transaction Date</th>
                            <th>Bonus From</th>
                            <th>Bonus Type</th>
                            <th>Acquired Amount</th>
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
        
        $('#bonus-table').DataTable({
            "ajax": {
                "url": "{{ route('transactions.bonusdata', $memberId) }}"
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