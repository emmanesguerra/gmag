@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Switch Account</title>
@endsection

@section('pagetitle')
    <i class="fa fa-group"></i>   ALL ACCOUNTS SUMMARY
@endsection

@section('module-content')

<div class="row p-3">
    <div class='col-12 contentheader100'>
        All Account List
    </div>
    <div class='col-12 content-container' style='position: relative'>
        
        <div class="row my-3">
            <div class="col-sm-6">
                <form class="form-inline"  method="GET" action="{{ route('switch.index') }}">
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
        @include('common.serverresponse')
        <div class="row">
            <div class="col-12">
                <table class="table table-hover table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Date Registered</th>
                            <th>ID No.</th>
                            <th>UserName</th>
                            <th>Name</th>
                            <th>Income</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                        <tr>
                            <th>{{ $member->created_at }}</th>
                            <td>{{ $member->id }}</td>
                            <td>{{ $member->username }}</td>
                            <td>{{ $member->firstname }} {{ $member->middlename }} {{ $member->lastname }}</td>
                            <td>{{ number_format($member->total_amt, 2) }}</td>
                            <td><a href="{{ route('switch.account', $member->id) }}">Switch</a></td>
                        </tr>
                        @endforeach 
                    </tbody>
                </table>

                {{ $members->withQueryString()->links() }}
            </div>
        </div>
        
    </div>
</div>
@endsection