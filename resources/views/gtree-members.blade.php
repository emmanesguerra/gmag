<div class="row">
    <span class="p-3  need-data col-6 offset-3 center" data-target-id="0" id="row0" data-id="{{ $data['id'] }}">
        @switch($data['product_id'])
        @case(4)
        <img class='gtree-img' src='{{ asset('images/gold.png') }}' />
        @break
        @case(3)
        <img class='gtree-img' src='{{ asset('images/silver.png') }}' />
        @break
        @case(2)
        <img class='gtree-img' src='{{ asset('images/bronze.png') }}' />
        @break
        @case(1)
        <img class='gtree-img' src='{{ asset('images/starter.png') }}' />
        @break
        @default
        <img class='gtree-img' src='{{ asset('images/open.png') }}' />
        @endswitch
        <br />
        <br />
        {{ $data['username'] }}
    </span>
</div>