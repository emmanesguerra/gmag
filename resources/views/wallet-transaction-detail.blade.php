<div class="col-12">
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>Tracking No</strong></span>
        <span class="col-8">{{ $data->tracking_no }}</span>
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
        <span class="col-4"><strong>Wallet Source</strong></span>
        
        @switch($data->source)
            @case ('direct_referral')
                <span class="col-8">Direct Referral</span>
                @break
            @case ('encoding_bonus')
                <span class="col-8">Encoding Bonus</span>
                @break
            @case ('matching_pairs')
                <span class="col-8">Matching Pair</span>
                @break
        @endswitch
    </div>
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>Amount</strong></span>
        <span class="col-8">{{ $data->amount }}</span>
    </div>
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>Disbursement Method</strong></span>
        <span class="col-8">{{ $data->disbursement->name }}</span>
    </div>
    @switch($data->disbursement_method)
        @case ('GCASH')
            <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
                <span class="col-4"><span class='ml-3'>GCASH Number</span></span>
                <span class="col-8">{{ $data->reference1 }}</span>
            </div>
            @break
        @case ('PXP')
            <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
                <span class="col-4"><span class='ml-3'>Wallet ID</span></span>
                <span class="col-8">{{ $data->reference1 }}</span>
            </div>
            <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
                <span class="col-4"><span class='ml-3'>Wallet Number</span></span>
                <span class="col-8">{{ $data->reference2 }}</span>
            </div>
            @break
        @case ('IBRTPP')
        @case ('UBP')
        @case ('IBBT')
        @case ('SBINSTAPAY')
            <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
                <span class="col-4"><span class='ml-3'>Bank</span></span>
                <span class="col-8">{{ $data->bank->name }}</span>
            </div>
            <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
                <span class="col-4"><span class='ml-3'>Bank Number</span></span>
                <span class="col-8">{{ $data->reference2 }}</span>
            </div>
            @break
        @case ('GHCP')
        @case ('AUCP')
            <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
                <span class="col-4"><span class='ml-3'>Pickup Center</span></span>
                <span class="col-8">{{ $data->pcenter->description }}</span>
            </div>
            @break
    @endswitch
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>Name</strong></span>
        <span class="col-8">{{ $data->firstname }} {{ $data->middlename }}, {{ $data->lastname }}</span>
    </div>
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>Address 1</strong></span>
        <span class="col-8">{{ $data->address1 }}</span>
    </div>
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>Address 2</strong></span>
        <span class="col-8">{{ $data->address2 }}</span>
    </div>
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>Mobile</strong></span>
        <span class="col-8">{{ $data->mobile }}</span>
    </div>
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>Email</strong></span>
        <span class="col-8">{{ $data->email }}</span>
    </div>
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>City/ State/ Country/ Zip</strong></span>
        <span class="col-8">{{ $data->city }}/ {{ $data->state }}/ {{ $data->country }}/ {{ $data->zip }}</span>
    </div>
    <div class="row mb-3 pb-3" style="border-bottom: 1px solid #ccc">
        <span class="col-4"><strong>Status</strong></span>
        @switch($data->status)
            @case ('C')
                <span class="col-8 text-primary">Confirmed by Admin</span>
                @break
            @case ('CC')
                <span class="col-8 text-success">Transaction completed</span>
                @break
            @case ('X')
                <span class="col-8 text-danger">Cancelled by Admin</span>
                @break
            @case ('XX')
                <span class="col-8 text-danger">Transaction failed</span>
                @break
            @case ('CX')
                <span class="col-8 text-danger">Confirmed with Issue</span>
                @break
            @case ('WA')
                <span class="col-8 text-secondary">Waiting for confirmation</span>
                @break
        @endswitch
    </div>
</div> 