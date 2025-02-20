@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Pairing Lists</title>
@endsection

@section('pagetitle')

@endsection

@section('module-content')

<div class="row p-3">
    <div class='col-12 contentheader100'>
        Pairing List of {{ $member->username }}
        @if(app('request')->input('top'))
        <span style='float: right; margin-right: 10px;'><a href='javascript:history.back()' class="btn btn-sm btn-dark">Back</a></span>
        @endif
        <span style='float: right; margin-right: 10px;'><a href='{{ route('set.yesterdays.pair.type') }}' class="btn btn-sm btn-success">Compute Today's Pair Status</a></span>
    </div>
    <div class='col-12 content-container py-3' style='position: relative'>
        
        <table id="pairing-table" class="table table-hover table-bordered text-center small">
            <thead>
                <tr>
                    <th>Date Paired</th>
                    <th>Parent</th>
                    <th>Left</th>
                    <th>Right</th>
                    <th>Product</th>
                    <th>Status</th>
                </tr>
            </thead>
        </table>
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
    <script src="{{ asset('js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/daterange.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>
    <script>
        
        var start = moment('{{ GmagHelpers::getStartingDate() }}');
        var end = moment();
        
        var table = $('#pairing-table').DataTable({
            "ajax": {
                "url": "{{ route('gtree.pairing.data', $member->id) }}",
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
                {
                    data: function ( row, type, set ) {
                        return moment.utc(row.created_at).tz(utimezone).format('MMMM DD, YYYY hh:mm A');
                    }
                },
                {"data": "parentname"},
                {"data": "leftname"},
                {"data": "rightname"},
                {"data": "name"},
                {
                    data: function ( row, type, set ) {
                        switch(row.type)
                        {
                            case 'MP':
                                return 'Bonus Pair';
                                break;
                            case 'FP':
                                return 'Flush Pair';
                                break;
                            case 'TP':
                                return 'Not yet computed';
                                break;
                            default:
                                return 'Temporary';
                                break;
                        }
                    }
                }
            ]
        });
        
        $("div.toolbar").html(
            '<label style="float: left;">Display <select id="status" class="custom-select custom-select-sm" onChange="drawTable()">'+
                '<option value="">All</option>'+
                '<option value="MP">Bonus Pair</option>'+
                '<option value="FP">Flush Pair</option>'+
                '<option value="TP">Not yet computed</option>'+
                '<option value="null">Temporary</option>'+
            '</select> </label>' +
            '<div id="reportrange" class="btn" style="margin-top: -4px">'+
                '<i class="fa fa-calendar"></i>&nbsp;'+
                '<span></span> <i class="fa fa-caret-down"></i>'+
            '</div>'
        );
    
        function drawTable() {
            table.ajax.reload();
        }
    </script>
@endsection