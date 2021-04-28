@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - PRODUCTS</title>
@endsection

@section('module-content')

<div class="row my-3">
    <div class="col-sm-6">
        <form class="form-inline"  method="GET" action="{{ route('admin.member.index') }}">
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
                    <input class="form-control col-12" type="search" name="search" value='{{ Request::get('search') }}' placeholder="Search" aria-label="Search" onChange="this.form.submit()">
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
                    <th>ID</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Sponsor</th>
                    <th>Matching Pair</th>
                    <th>Direct Referral</th>
                    <th>Encoding Bonus</th>
                    <th>Total Amount</th>
                    <th>Flush Points</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                <tr>
                    <th>{{ $member->id }}</th>
                    <td style="text-align: left">{{ $member->username }}</td>
                    <td style="text-align: left">{{ $member->firstname }} {{ $member->lastname }}</td>
                    <td style="text-align: left">{{ ($member->sponsor) ? $member->sponsor->username: "" }}</td>
                    @if($member->matching_pairs > 0)
                    <td>{{ number_format($member->matching_pairs, 2) }}</td>
                    @else
                    <td>0</td>
                    @endif
                    @if($member->direct_referral > 0)
                    <td>{{ number_format($member->direct_referral, 2) }}</td>
                    @else
                    <td>0</td>
                    @endif
                    @if($member->encoding_bonus > 0)
                    <td>{{ number_format($member->encoding_bonus, 2) }}</td>
                    @else
                    <td>0</td>
                    @endif
                    @if($member->total_amt > 0)
                    <td>{{ number_format($member->total_amt, 2) }}</td>
                    @else
                    <td>0</td>
                    @endif
                    <td>{{$member->flush_pts}}</td>
                    <td><a href='#'>View</a> | <a href='#'>Edit</a></td>
                </tr>
                @endforeach 
            </tbody>
        </table>

        {{ $members->withQueryString()->links() }}
    </div>
</div>
@endsection