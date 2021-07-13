@extends('layouts.register')

@section('title')
<title>GOLDEN MAG</title>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 my-5" style='max-width: 860px;'>
            <div class="card p-3" style='box-shadow: 0 0 20px #000000b3;'>
                <div class="card-body">
                    
                    <h1>Thank you for purchasing our products.</h1>
                    <br />
                    
                    <p>Below are the details of your purchase</p>
                    <table class='table table-borderless'>
                        <tr>
                            <td width='40%'>Transaction No</td>
                            <td>{{ $trans->transaction_no }}</td>
                        </tr>
                        <tr>
                            <td>Paynamics' Response ID</td>
                            <td>{{ $trans->response_id }}</td>
                        </tr>
                        <tr>
                            <td>Package</td>
                            <td>{{ $trans->product->name }}</td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td>{{ number_format($trans->product->price, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Quantity</td>
                            <td>{{ $trans->quantity }}</td>
                        </tr>
                        <tr>
                            <td>Total Amount</td>
                            <td>{{ number_format($trans->total_amount, 2) }}</td>
                        </tr>
                    </table>
                    <br />
                    
                    <p>Your transaction is being processed by our partner gateway.</p>
                    
                    <p>You may track the status of this transaction by clicking <a href="{{ route('profile.show', $trans->member_id) }}">here</a></p>
                    
                    <p>Go to <a href="{{ route('home') }}">Dashboard</a> or <a href="{{ route('codevault.index') }}" >Code Vault</a></p>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection