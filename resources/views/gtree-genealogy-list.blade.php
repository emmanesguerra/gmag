@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Genealogy Lists</title>
@endsection

@section('pagetitle')
    <i class="fa fa-sitemap"></i>   PARTNERS SUMMARY
@endsection

@section('module-content')


<div class="row p-3">
    <div class='col-12 contentheader100'>
        Genealogy List
    </div>
    <div class='col-12 content-container py-3' style='position: relative'>
        @include('common.serverresponse')
        <div class="row">
            <div class="col-12">
                <table id="geneology-table" class="table table-hover table-bordered text-center small">
                    <thead>
                        <tr>
                            <th>Date Registered</th>
                            <th>Member Username</th>
                            <th>Member Name</th>
                            <th>Level</th>
                            <th>Entry Type</th>
                            <th>Sponsor</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        
    </div>
</div>
@endsection

@section('css')
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
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>
    <script>
        
        var start = moment('{{ env('GO_LIVE') }}');
        var end = moment();
        
        var table = $('#geneology-table').DataTable({
            "ajax": {
                "url": "{{ route('gtree.genealogydata', $member->id) }}",
                data: function ( d ) {
                    d.start_date = start.format('Y-MM-DD');
                    d.end_date = end.format('Y-MM-DD');
                }
            },
            serverSide: true,
            responsive: true,
            processing: true,
            "dom": 'l<"toolbar dataTables_filter">frtpi',
            "columns": [
                {
                    data: function ( row, type, set ) {
                        return moment(row.created_at).format('MMMM DD, YYYY hh:mm A');
                    }
                },
                {"data": "username"},
                {
                    data: function ( row, type, set ) {
                        return row.firstname + " " + row.lastname;
                    }
                },
                {
                    data: function ( row, type, set ) {
                        return row.lvl - {{ $lvl }};
                    }
                },
                {
                    data: function ( row, type, set ) {
                        return row.name + " | " + Number(row.price).toLocaleString("en", {minimumFractionDigits: 2});
                    }
                },
                {"data": "sponsor"}
            ]
        });
        
        $("div.toolbar").html(
            '<div id="reportrange" class="btn" style="margin-top: -4px">'+
                '<i class="fa fa-calendar"></i>&nbsp;'+
                '<span></span> <i class="fa fa-caret-down"></i>'+
            '</div>'
        );
    
        function drawTable() {
            table.ajax.reload();
        }
        
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
                minDate: moment('{{ env('GO_LIVE') }}'),
                ranges: {
                   'Lifetime': [moment('{{ env('GO_LIVE') }}'), moment()],
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
                
                table.ajax.reload();
            });

            cb(start, end);
        });
    </script>
@endsection