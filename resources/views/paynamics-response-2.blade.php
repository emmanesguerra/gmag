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
                    
                    <h2>Thank you for settling your credit amount.</h2>
                    <br />
                    
                    <p>Below are the details of your transaction</p>
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
                            <td>Transasction</td>
                            <td>Credit Adjustment</td>
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
                    
                    <p>Your transaction is currently being processed by our partner gateway. Sometime this takes time to verify the final status.</p>
                    
                    <p>You may track manually the status of this transaction by checking your <a href="{{ route('profile.show', $trans->member_id) }}">Profile</a> page</p>
                    
                    <ol>
                        <li>Under "Paynamics Transaction", click the status of the transaction you want to check</li>
                        <li>Inside the modal box you will find "Check Status" if the current status is waiting/pending</li>
                        <li>Click "Check Status" button to fetch the final result of the transaction.</li>
                    </ol>
                    
                    <p>Redirect to <a href="{{ route('home') }}">Dashboard</a> or <a href="{{ route('codevault.index') }}" >Code Vault</a></p>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection