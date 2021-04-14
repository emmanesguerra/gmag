@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Pairing Lists</title>
@endsection

@section('pagetitle')
    <i class="fa fa-group"></i>   PARTNERS SUMMARY
@endsection

@section('module-content')


<div class="row p-3">
    <div class='col-12 contentheader100'>
        Genealogy List
    </div>
    <div class='col-12 content-container' style='position: relative'>
        
        <div class="row my-3">
            <div class="col-sm-6">
                <form class="form-inline"  method="GET" action="{{ route('gtree.genealogy') }}">
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
                            <th>Member Username</th>
                            <th>Member Name</th>
                            <th>Level</th>
                            <th>Entry Type</th>
                            <th>Sponsor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                        <tr>
                            <td>{{ $member->created_at }}</td>
                            <td>{{ $member->member->username }}</td>
                            <td>{{ $member->member->firstname }} {{ $member->member->lastname }}</td>
                            <td>{{ $member->lvl - $lvl }}</td>
                            <td>{{ $member->product->code }} | {{ $member->product->price }}</td>
                            <td>{{ $member->member->sponsor->username }}</td>
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

@section('javascripts')
@endsection