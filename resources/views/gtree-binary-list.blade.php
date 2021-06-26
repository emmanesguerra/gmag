@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Binary Lists</title>
@endsection

@section('pagetitle')
<i class="fa fa-sitemap"></i>   PARTNERS SUMMARY
@endsection

@section('module-content')

<div class="row pt-3 px-3">
    <div id="reportrange" class='float-right btn btn-sm btn-dark small' style='margin-top: -4px'>
        <i class="fa fa-calendar"></i>&nbsp; 
        <span></span> <i class="fa fa-caret-down"></i>
    </div>
</div>

<div class="row p-3">
    <div class='col-6 pl-0'>
        <div class="col-12 contentheader100">
            LEFT Member List
        </div>
        <div class='col-12 content-container py-3' style='position: relative'>
            <div class="row">
                <div class="col-12">
                    <table id="leftTable" class=" datatables table table-hover table-bordered text-center small">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Username</th>
                                <th>Entry Type</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class='col-6 pl-0 pr-0'>
        <div class="col-12 contentheader100">
            RIGHT Member List
        </div>
        <div class='col-12 content-container py-3' style='position: relative'>
            <div class="row">
                <div class="col-12">
                    <table id="rightTable" class=" datatables table table-hover table-bordered text-center small">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Username</th>
                                <th>Entry Type</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link href="{{ asset('css/daterangepicker.css') }}"  rel="stylesheet">
    <link rel="stylesheet"  href="{{ asset('js/DataTables/datatables.min.css') }}" />
@endsection

@section('javascripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>
    <script>
        
        var start = moment('{{ GmagHelpers::getStartingDate() }}');
        var end = moment();
        
        var lefttable = $('#leftTable').DataTable({
            "ajax": {
                "url": "{{ route('gtree.binary.left') }}",
                data: function ( d ) {
                    d.start_date = start.format('Y-MM-DD');
                    d.end_date = end.format('Y-MM-DD');
                }
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
                {"data": "username"},
                {
                    data: function ( row, type, set ) {
                        return row.code + " | " + Number(row.price).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                }
            ]
        });
        
        var righttable = $('#rightTable').DataTable({
            "ajax": {
                "url": "{{ route('gtree.binary.right') }}",
                data: function ( d ) {
                    d.start_date = start.format('Y-MM-DD');
                    d.end_date = end.format('Y-MM-DD');
                }
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
                {"data": "username"},
                {
                    data: function ( row, type, set ) {
                        return row.code + " | " + Number(row.price).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                }
            ]
        });
        
        $(function() {

            function cb(start, end) {
                if(start.format('MMMM D, YYYY') == end.format('MMMM D, YYYY')) {
                    $('#reportrange span').html('Display records: ' + start.format('MMMM D, YYYY'));
                }else {
                    $('#reportrange span').html( 'Display records from ' + start.format('MMMM D, YYYY') + ' to ' + end.format('MMMM D, YYYY'));
                }
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                alwaysShowCalendars: true,
                autoApply: false,
                linkedCalendars: false,
                minDate: start,
                ranges: {
                   'Lifetime': [start, moment()],
                   'Today': [moment(), moment()],
                   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                   'This Month': [moment().startOf('month'), moment().endOf('month')],
                   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);
            $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
                start = picker.startDate;
                end = picker.endDate;

                lefttable.ajax.reload();
                righttable.ajax.reload();
            });

            cb(start, end);
        });
    </script>
@endsection