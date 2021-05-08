@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - ENCASHMENT REQUESTS</title>
@endsection

@section('module-content')

@include('common.serverresponse')
<div class="row py-3">
    <div class="col-12">
        <table id="encashtable" class="table table-hover table-striped text-center">
            <thead>
                <tr>
                    <th>Date Request</th>
                    <th>Username</th>
                    <th>Request Type</th>
                    <th>Fullname</th>
                    <th>Mobile</th>
                    <th>Request Amount</th>
                    <th>Tracking No</th>
                    <th>Status</th>
                    <th>Remarks</th>
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
                encashtable.ajax.reload();
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
                encashtable.ajax.reload();
            }).fail(function(XHR) {
                var error = getAjaxErrorMessage(XHR);
                $('#reject_resp').html(error);
                $('#reject_resp').css('display', 'block');
            });;
        });
        
        var encashtable = $('#encashtable').DataTable({
            "ajax": {
                "url": "{{ route('admin.encashment.data') }}"
            },
            serverSide: true,
            processing: true,
            "columns": [
                {
                    data: function ( row, type, set ) {
                        return moment(row.created_at).format('MMMM DD, YYYY hh:mm A');
                    }
                },
                {"data": "username"},
                {"data": "req_type"},
                {"data": "name"},
                {"data": "mobile"},
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
                },
                {"data": "remarks"},
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
    </script>
@endsection