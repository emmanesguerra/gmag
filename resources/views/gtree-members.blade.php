
@if ($data['id'] > 0)
    @if (isset($first))
        @if (auth()->user()->id == $data['id'])
            <a href='{{ route('gtree.index') }}' class='gtree-a'>
        @else
            @if(app('request')->input('r'))
            <a href='{{ route('gtree.index') }}' class='gtree-a'>
            @else
            <a href='javascript:history.back()' class='gtree-a'>
            @endif
        @endif
    @else
        <a href='{{ route('gtree.index', ['top' => $data['id']]) }}' class='gtree-a'>
    @endif
@else
    @if ($data['username'] == 'Sign Up')
    <a href='{{ route('register.member.create', ['target_id' => $data['target_id'], 'position' => $data['position']]) }}' target="_blank" class='gtree-a'>
    @endif
@endif
    @switch($data['product_id'])
    @case(4)
    <img class='gtree-img' src='{{ asset('images/gold_s.png') }}' />
    @break
    @case(3)
    <img class='gtree-img' src='{{ asset('images/silver_s.png') }}' />
    @break
    @case(2)
    <img class='gtree-img' src='{{ asset('images/bronze_s.png') }}' />
    @break
    @case(1)
    <img class='gtree-img' src='{{ asset('images/starter_s.png') }}' />
    @break
    @default
    <img class='gtree-img' src='{{ asset('images/open_s.png') }}' />
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