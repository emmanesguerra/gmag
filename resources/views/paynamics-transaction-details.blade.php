<div class="col-12">
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>Transaction No</strong></span>
        <span class="col-8">
            {{ $data->transaction_no }}
            <img id="transactionloader1" style="display: none" src="{{ asset('images/loader.svg') }}" height="30" widht="30" class=" ml-3 float-right">
            @if(Auth::guard('web')->check())
                @if(in_array($data->status, ['WR']))
                    <a href='{{ route('codevault.checkstatus', $data->id) }}' class='btn btn-sm btn-info float-right mr-3' onclick="showloader(true)">Check Status</a>
                @endif
            @endif
        </span>
    </div>
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>Remarks</strong></span>
        <?php $remarks = explode("|", $data->remarks) ?>
        <span class="col-8">
            @foreach($remarks as $remark)
                @if(!empty($remark))
                    {!! $remark !!} <br />
                @endif
            @endforeach
        </span>
    </div>
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>Paynamics Request ID</strong></span>
        <span class="col-8">{{ $data->generated_req_id }}</span>
    </div>
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>Paynamics Response ID</strong></span>
        <span class="col-8">{{ $data->response_id }}</span>
    </div>
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>Package</strong></span>
        <span class="col-8">{{ $data->product->name }}</span>
    </div>
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>Price</strong></span>
        <span class="col-8">{{ number_format($data->product->price, 2) }}</span>
    </div>
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>Quantity</strong></span>
        <span class="col-8">{{ $data->quantity }}</span>
    </div>
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>Total Amount</strong></span>
        <span class="col-8">{{ number_format($data->total_amount, 2) }}</span>
    </div>
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>Status</strong></span>
        @switch($data->status)
            @case ('WR')
                <span class="col-8 text-primary">Waiting for response</span>
                @break
            @case ('S')
                <span class="col-8 text-success">Transaction success</span>
                @break
            @case ('F')
                <span class="col-8 text-danger">Transaction failed</span>
                @break
            @case ('X')
                <span class="col-8 text-danger">Cancelled</span>
                @break
        @endswitch
    </div>
</div> 

<script>
    function showloader (isTwo){
        if(isTwo) {
            $('#transactionloader2').css('display', 'inline');
        } else {
            $('#transactionloader1').css('display', 'inline');
        }
    }
</script>