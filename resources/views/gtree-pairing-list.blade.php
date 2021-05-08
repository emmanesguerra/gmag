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
    <link rel="stylesheet"  href="{{ asset('js/DataTables/datatables.min.css') }}" />
@endsection

@section('javascripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/DataTables/datatables.min.js') }}"></script>
    <script>
        $('#pairing-table').DataTable({
            "ajax": {
                "url": "{{ route('gtree.pairing.data', $member->id) }}"
            },
            serverSide: true,
            responsive: true,
            processing: true,
            "columns": [
                {
                    data: function ( row, type, set ) {
                        return moment(row.created_at).format('MMMM DD, YYYY h:m A');
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
    </script>
@endsection