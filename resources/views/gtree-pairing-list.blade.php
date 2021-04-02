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
    <div class='col-12 content-container' style='position: relative'>
        
        <div class="row my-3">
            <div class="col-sm-6">
                <form class="form-inline"  method="GET" action="{{ route('gtree.pairing') }}">
                    <div class="col-sm-3">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-4 col-form-label">Show</label>
                            <div class="col-sm-6">
                                <select class="form-control" name='show' onChange="this.form.submit()">
                                    @foreach([10,15,20,25] as $ctr)
                                    @if(Request::get('show') == $ctr)
                                    <option selected>{{ $ctr }}</option>
                                    @else 
                                    <option>{{ $ctr }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <table class='table table-striped'>
            <tr>
                <th></th>
                <th>Parent</th>
                <th>Left</th>
                <th>Right</th>
                <th>Product</th>
                <th>Status</th>
                <th>Date Paired</th>
            </tr>
            @foreach($pairs as $ctr => $pair)
            <tr>
                <td>{{ $pair->id }}</td>
                <td>{{ $pair->member->username }}</td>
                <td><a href='{{ route('gtree.pairing', ['top' => $pair->lft_mid]) }}'>{{ $pair->lmember->username }}</a></td>
                <td><a href='{{ route('gtree.pairing', ['top' => $pair->rgt_mid]) }}'>{{ $pair->rmember->username }}</a></td>
                <td>{{ $pair->product->name }}</td>
                @switch($pair->type)
                    @case('MP')
                        <td>Bonus Pair</td>
                        @break
                    @case('FP')
                        <td>Flush Pair</td>
                        @break
                    @case('TP')
                        <td>Not yet computed</td>
                        @break
                    @default
                        <td>Temporary</td>
                        @break
                @endswitch
                <td>{{ $pair->created_at }}</td>
            </tr>
            @endforeach
        </table>
        
        {{ $pairs->withQueryString()->links() }}
    </div>
</div>
@endsection

@section('javascripts')
@endsection