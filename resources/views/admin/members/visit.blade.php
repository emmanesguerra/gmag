@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - PRODUCTS</title>
@endsection

@section('module-content')

<div class="row my-3">
    <div class="col-sm-6">
        <form class="form-inline"  method="GET" action="{{ route('admin.member.visit') }}">
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
            <div class="col-sm-9">
                <div class="form-group row">
                    <input class="form-control col-12" type="search" name="search" value='{{ Request::get('search') }}' placeholder="Search" aria-label="Search" onchange="this.form.submit()">
                </div>
            </div>
        </form>
    </div>
</div>
@include('common.serverresponse')
<div class="row">
    <div class="col-12">
        <table class="table table-hover table-striped text-center">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Login Date</th>
                    <th>Ip Address</th>
                    <th>Username</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                <tr>
                    <th>{{ $member->id }}</th>
                    <td>{{ date('F d, Y h:i:s A', strtotime($member->log_in)) }}</a></td>
                    <td>{{ $member->ip_address }}</td>
                    <td>{{ $member->username }}</td>
                </tr>
                @endforeach 
            </tbody>
        </table>

        {{ $members->withQueryString()->links() }}
    </div>
</div>
@endsection