@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - Encashment Requests</title>
@endsection

@section('module-content')

@include('common.serverresponse')
<div class="row py-3">
    <div class="col-12">
        <table id="encashtable" class="table table-hover table-striped text-center small">
            <thead>
                <tr>
                    <th>Date Requested</th>
                    <th>Username</th>
                    <th>Disbursement Method</th>
                    <th>Requested Amount</th>
                    <th>Tracking No</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
    
    <div class="modal fade in" id="approve-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h4 class="modal-title">Confirmation Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form accept-charset="UTF-8" style="display:inline">
                        <div id="approve_resp" class="alert alert-danger" style="display:none;"></div>
                        <p>Please insert the tracking number to confirm</p>
                        <input type='text' class='form-control form-control-lg' name='tracking_no' id='tracking_no' placeholder="Tracking Number" />
                        
                        <textarea name="remarks" id="approve_remarks"  class='form-control form-control-lg mt-1' placeholder="Remarks" rows="3"></textarea>
                        
                        <input type='hidden' name="approve_id" id="approve_id" />
                        
                        <input id="confirm" class="btn btn-outline text-success" type="button" value="Confirm">
                    </form>
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade in" id="reject-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="reject_resp" class="alert alert-danger" style="display:none;"></div>
                    <p>You are about to reject this request. Do you wish to continue?</p>

                    <form accept-charset="UTF-8" style="display:inline" class="center">
                        <textarea name="remarks" id="reject_remarks"  class='form-control form-control-lg mt-1' placeholder="Remarks" rows="3"></textarea>
                        
                        <input type='hidden' name="reject_id" id="reject_id" />
                        <input id="reject" class="btn btn-outline text-danger" type="button" value="Reject">
                        <button type="button" class="btn btn-outline" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
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
        
        var showApproveModal = function (id) {
            $('#approve_id').val(id);
            $('#tracking_no').val('');
            $('#approve_remarks').val('');
            $('#approve_resp').css('display', 'none');
            $('#approve-modal').modal('show');
        }
        
        var showRejectModal = function (id) {
            $('#reject_id').val(id);
            $('#approve_remarks').val('');
            $('#reject_resp').css('display', 'none');
            $('#reject-modal').modal('show');
        }
        
        $('#confirm').click(function() {
            $.ajax({
                url: '{{ route("admin.encashment.approve") }}',
                method: 'POST',
                data: {
                    id: $('#approve_id').val(),
                    tracking_no: $('#tracking_no').val(),
                    remarks: $('#approve_remarks').val()
                }
            }).done(function(response) {
                $('#approve-modal').modal('hide');
                table.ajax.reload();
            }).fail(function(XHR) {
                var error = getAjaxErrorMessage(XHR);
                $('#approve_resp').html(error);
                $('#approve_resp').css('display', 'block');
            });
        });
        
        $('#reject').click(function() {
            $.ajax({
                url: '{{ route("admin.encashment.reject") }}',
                method: 'DELETE',
                data: {
                    id: $('#reject_id').val(),
                    remarks: $('#reject_remarks').val()
                }
            }).done(function(response) {
                $('#reject-modal').modal('hide');
                table.ajax.reload();
            }).fail(function(XHR) {
                var error = getAjaxErrorMessage(XHR);
                $('#reject_resp').html(error);
                $('#reject_resp').css('display', 'block');
            });;
        });
        
        var start = moment('{{ GmagHelpers::getStartingDate() }}');
        var end = moment();
        
        var table = $('#encashtable').DataTable({
            "ajax": {
                "url": "{{ route('admin.encashment.data') }}",
                data: function ( d ) {
                    d.status = $('#status').val();
                    d.start_date = start.format('Y-MM-DD');
                    d.end_date = end.format('Y-MM-DD');
                }
            },
            serverSide: true,
            processing: true,
            "dom": 'l<"toolbar dataTables_filter">frtpi',
            "columns": [
                {
                    data: function ( row, type, set ) {
                        return moment(row.created_at).format('MMMM DD, YYYY hh:mm A');
                    }
                },
                {"data": "username"},
                {"data": "disbursement_method"},
                {
                    data: function ( row, type, set ) {
                        return Number(row.amount).toLocaleString("en", {minimumFractionDigits: 2});
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
                },
                {
                    data: function ( row, type, set ) {
                        if(row.status == 'WA') {
                            return '<a href="#" onclick="showApproveModal(' + row.id + ')">Confirm</a> | <a href="#" onclick="showRejectModal(' + row.id + ')" class="text-danger">Cancel</a>';
                        }
                        return '';
                    }
                }
            ]
        });
        
        $("div.toolbar").html(
            '<label style="float: left;">Display <select id="status" class="custom-select custom-select-sm" style="font-size: 13px;" onChange="drawTable()">'+
                '<option value="">All</option>'+
                '<option value="C">Confirmed</option>'+
                '<option value="CC">Completed</option>'+
                '<option value="WA">Waiting</option>'+
                '<option value="X">Cancelled</option>'+
                '<option value="XX">Failed</option>'+
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