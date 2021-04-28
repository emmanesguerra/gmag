@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - PRODUCTS</title>
@endsection

@section('module-content')

<div class="row my-3">
    <div class="col-sm-6">
        <form class="form-inline"  method="GET" action="{{ route('admin.transactions.index') }}">
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Product Code</th>
                    <th>Price</th>
                    <th>Transaction Date</th>
                    <th>Package Claimed</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trans as $tran)
                <tr>
                    <th>{{ $tran->id }}</th>
                    <td style="text-align: left">{{ $tran->firstname }} {{ $tran->lastname }}</td>
                    <td style="text-align: left">{{ $tran->email }}</td>
                    <td >{{ $tran->product_code }}</td>
                    @if($tran->product_price > 0)
                    <td>{{ number_format($tran->product_price, 2) }}</td>
                    @else
                    <td>0</td>
                    @endif
                    <td>{{$tran->transaction_date}}</td>
                    <td>{{ ($tran->package_claimed) ? "YES" : "NO" }}</td>
                </tr>
                @endforeach 
            </tbody>
        </table>

        {{ $trans->withQueryString()->links() }}
    </div>
</div>
@endsection