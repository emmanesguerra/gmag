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
                            <th>Disbursement Method</th>
                            <th>Amount</th>
                            <th>Fullname</th>
                            <th>Tracking No</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        
    </div>
    
    <div class="modal fade in" id="detail-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h4 class="modal-title">Transaction Detail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body" id="transaction-content">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link href="{{ asset('css/bootstrap.min.css') }}"  rel="stylesheet">
    <link href="{{ asset('css/daterangepicker.css') }}"  rel="stylesheet">
    <link rel="stylesheet"  href="{{ asset('js/DataTables/datatables.min.css') }}" />
    <style>
        div.dataTables_length,
        div.dataTables_info,
        div.paging_simple_numbers,
        div.dataTables_filter {
            float: right;
        }
        div.dataTables_info,
        div.paging_simple_numbers {
            width: 50%;
        }
        div.dataTables_length {
            float: left;
            width: 20%;
        }
        div.toolbar.dataTables_filter {
            width: 55%;
            float: left;
        }
        div.toolbar select {
            width: auto;
            display: inline-block;
        }
    </style>
@endsection

@section('javascripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/daterange.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>
    <script>
        
        var start = moment('{{ env('GO_LIVE') }}');
        var end = moment();
        
        var table = $('#encashtable').DataTable({
            "ajax": {
                "url": "{{ route('wallet.history.data', $member->id) }}",
                data: function ( d ) {
                    d.status = $('#status').val();
                    d.start_date = start.format('Y-MM-DD');
                    d.end_date = end.format('Y-MM-DD');
                }
            },
            serverSide: true,
            responsive: true,
            processing: true,
            "dom": 'l<"toolbar dataTables_filter">frtpi',
            "columns": [
                {"data": "id"},
                {
                    data: function ( row, type, set ) {
                        return moment(row.created_at).format('MMMM DD, YYYY hh:mm A');
                    }
                },
                {"data": "disbursement_method"},
                {"data": "amount"},
                {
                    data: function ( row, type, set ) {
                        return row.firstname + ' ' + row.lastname;
                    }
                },
                {"data": "tracking_no"},
                {
                    data: function ( row, type, set ) {
                        var stat = "";
                        switch(row.status) {
                            case "WA":
                                stat = "<span onclick='displayInfo("+row.id+")' style='cursor:pointer; text-decoration: underline' class='text-primary' >Waiting</span>";
                                break;
                            case "C":
                                stat = "<span onclick='displayInfo("+row.id+")' style='cursor:pointer; text-decoration: underline' class='text-success'>Confirmed</span>";
                                break;
                            case "CC":
                                stat = "<span onclick='displayInfo("+row.id+")' style='cursor:pointer; text-decoration: underline' class='text-success'>Completed</span>";
                                break;
                            case "XX":
                                stat = "<span onclick='displayInfo("+row.id+")' style='cursor:pointer; text-decoration: underline' class='text-danger'>Failed</span>";
                                break;
                            default:
                                stat = "<span onclick='displayInfo("+row.id+")' style='cursor:pointer; text-decoration: underline' class='text-danger'>Cancelled</span>";
                                break;
                        }
                        return stat;
                    }
                }
            ]
        });
        
        $("div.toolbar").html(
            '<label style="float: left;">Display <select id="status" class="custom-select custom-select-sm" onChange="drawTable()">'+
                '<option value="">All</option>'+
                '<option value="C">Confirmed</option>'+
                '<option value="WA">Waiting</option>'+
                '<option value="X">Cancelled</option>'+
            '</select></label>' +
            '<div id="reportrange" class="btn" style="margin-top: -4px">'+
                '<i class="fa fa-calendar"></i>&nbsp;'+
                '<span></span> <i class="fa fa-caret-down"></i>'+
            '</div>'
        );
    
        function drawTable() {
            table.ajax.reload();
        }
        
        function displayInfo(id) {
            $.ajax({
                url: '{{ route("wallet.history.details") }}',
                type: "get",
                data: {
                    id: id
                },
                beforeSend: function() {
                    $('#detail-modal').modal('show');
                    $('#transaction-content').html('<div class="col-12 text-center"><img src="{{ asset('images/loader.svg') }}" height="40" widht="40" class="m-5"></div>');
                }, 
            }).done(function(response) {
                console.log(response);
                $('#transaction-content').html(response.html);
            }).fail(function(XHR) {
                alert('Unable to retrieve data');
                $('#detail-modal').modal('hide');
            });
        }
    </script>
@endsection