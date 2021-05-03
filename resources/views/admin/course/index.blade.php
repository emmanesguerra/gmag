@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - ENCASHMENT REQUESTS</title>
@endsection

@section('module-content')

@include('common.serverresponse')
<div class="row py-3">
    <div class="col-12">
        <table id="coursetable" class="table table-hover table-striped text-center">
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
    <link rel="stylesheet"  href="{{ asset('js/DataTables/datatables.min.css') }}" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('javascripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>
    <script>
        
        var coursetable = $('#coursetable').DataTable({
            "ajax": {
                "url": "{{ route('admin.course.data') }}"
            },
            serverSide: true,
            processing: true,
            "columns": [
                {
                    data: function ( row, type, set ) {
                        return moment(row.created_at).format('MMMM DD, YYYY h:m A');
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
    </script>
@endsection