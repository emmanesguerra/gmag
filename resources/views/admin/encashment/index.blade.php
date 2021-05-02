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
                    <th>Source Amount</th>
                    <th>Request Amount</th>
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
                    <form id="approvemodalform" method="POST" accept-charset="UTF-8" style="display:inline">
                        @csrf
                        <p>Please insert the tracking number to confirm</p>
                        
                        <input type='text' class='form-control form-control-lg' name='tracking_no'>
                        
                        <input class="btn btn-outline text-success" type="submit" value="Confirm">
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
                    <p>You are about to reject this request. Do you wish to continue?</p>

                    <form id="rejectmodalform" method="POST" accept-charset="UTF-8" style="display:inline" class="center">
                        <input name="_method" type="hidden" value="DELETE">
                        @csrf
                        <input class="btn btn-outline text-danger" type="submit" value="Reject">
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
        
        var showApproveModal = function (id, text, url) {
            $('#approvemodalform').attr('action', url);
            $('#approve-modal').modal('show');
        }
        
        var showRejectModal = function (id, text, url) {
            $('#rejectmodalform').attr('action', url);
            $('#reject-modal').modal('show');
        }
        
        $('#encashtable').DataTable({
            "ajax": {
                "url": "{{ route('admin.encashment.data') }}"
            },
            serverSide: true,
            processing: true,
            "columns": [
                {
                    data: function ( row, type, set ) {
                        return moment(row.created_at).format('MMMM DD, YYYY h:m A');
                    }
                },
                {"data": "username"},
                {"data": "req_type"},
                {"data": "name"},
                {"data": "mobile"},
                {
                    data: function ( row, type, set ) {
                        return Number(row.source_amount).toLocaleString("en", {minimumFractionDigits: 2});
                    },
                    "searchable": false,
                    "orderable": false
                },
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
                                stat = "Confirmed";
                                break;
                            default:
                                stat = "Cancelled";
                                break;
                        }
                        return stat;
                    }
                },
                {
                    data: function ( row, type, set ) {
                        if(row.status == 'WA') {
                            return '<a href="#" onclick="showApproveModal(' + row.id + ',\'\', \'{{ route("admin.encashment.reject") }}\')">Confirm</a> | <a href="#" onclick="showRejectModal(' + row.id + ',\'\', \'{{ route("admin.encashment.reject") }}\')" class="text-danger">Cancel</a>';
                        }
                        return '';
                    }
                }
            ]
        });
    </script>
@endsection