
@if ($data['id'] > 0)
    @if (isset($first))
        <a href='{{ route('gtree.index') }}'>
    @else
    <a href='{{ route('gtree.index', ['top' => $data['id']]) }}'>
    @endif
@else
    @if ($data['username'] == 'Sign Up')
    <a href='{{ route('gtree.index') }}'>
    @endif
@endif
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
@if ($data['id'] > 0)
<strong class='text-dark'>{{ $data['username'] }}</strong></a>
@else

    @if ($data['username'] == 'Sign Up')
    <strong class='text-success'>{{ $data['username'] }}</strong></a>
    @else 
    <strong class='text-danger'>{{ $data['username'] }}</strong>
    @endif
@endif