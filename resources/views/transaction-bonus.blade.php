@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Edit Profile</title>
@endsection

@section('pagetitle')
    <i class="fa fa fa-line-chart"></i>   BONUSES SUMMARY
@endsection

@section('module-content')

<div class="row p-3">
    <div class='col-12 contentheader100'>
        Incentives List
    </div>
    <div class='col-12 content-container' style='position: relative'>
        
        <div class="row my-3">
            <div class="col-sm-6">
                <form class="form-inline"  method="GET" action="{{ route('transactions.bonus') }}">
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
                            <th>ID</th>
                            <th colspan="2">Bonus From</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Transaction Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trans as $tran)
                        <tr>
                            <th>{{ $tran->id }}</th>
                            @if (in_array($tran->type, ['MP', 'FP']))
                                <td>{{ $tran->membertype->lmember->firstname }} {{ $tran->membertype->lmember->lastname }}</td>
                                <td >{{ $tran->membertype->rmember->firstname }} {{ $tran->membertype->rmember->lastname }}</td>
                            @else
                                <td  colspan="2">{{ $tran->membertype->username }}</td>
                            @endif
                            @switch ($tran->type)
                                @case('MP')
                                    <td >Matching Pair</td>
                                    @break
                                @case('FP')
                                    <td >Flush Pair</td>
                                    @break
                                @case('EB')
                                    <td >Encoding Bonus</td>
                                    @break
                                @case('DR')
                                    <td >Direct Referral</td>
                                    @break
                            @endswitch
                            @if($tran->acquired_amt > 0)
                            <td>{{ number_format($tran->acquired_amt, 2) }}</td>
                            @else
                            <td>0</td>
                            @endif
                            <td>{{ $tran->created_at }}</td>
                        </tr>
                        @endforeach 
                    </tbody>
                </table>

                {{ $trans->withQueryString()->links() }}
            </div>
        </div>
        
    </div>
</div>
@endsection

@section('javascripts')
    <script>
    </script>
@endsection