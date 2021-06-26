@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - Courses</title>
@endsection

@section('module-content')

@include('common.serverresponse')
<div class="row py-3">
    <div class="col-12">
        <table id="coursetable" class="table table-hover table-striped text-center small">
            <thead>
                <tr>
                    <th>Date Created</th>
                    <th>Title</th>
                    <th>Source</th>
                    <th>Link</th>
                    <th>Filename</th>
                    <th>Action</th>
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
        
        .modal-dialog {
            margin-top: 10rem;
        }
        .fade:not(.show) {
            opacity: 1;
            background: #00000087;
            margin-top: 3;
        }
    </style>
@endsection

@section('javascripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/daterange.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>
    <script>
        
        var start = moment('{{ GmagHelpers::getStartingDate() }}');
        var end = moment();
        
        var table = $('#coursetable').DataTable({
            "ajax": {
                "url": "{{ route('admin.course.data') }}",
                data: function ( d ) {
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
                {"data": "title"},
                {
                    data: function ( row, type, set ) {
                        if(row.source == 1) {
                            return "3rd Party Program";
                        } else {
                            return "File upload";
                        }
                    }
                },
                {"data": "link"},
                {"data": "filename"},
                {
                    searchable: false,
                    orderable: false,
                    data: function ( row, type, set ) {
                        return '<a href="{{ route('admin.course.index') }}/'+row.id+'/edit">Edit</a> | <a href="#" onclick="showdeletemodal(\''+row.id+'\',\''+row.title+'\',\'{{ route('admin.course.index') }}/'+row.id+'\')"  class="text-danger">Delete</a>';
                    }
                }
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
    </script>
@endsection