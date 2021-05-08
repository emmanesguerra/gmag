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
    <a href='{{ route('register.member.create', ['target_id' => $data['target_id'], 'position' => $data['position']]) }}' class='gtree-a'>
    @endif
@endif
<img class='gtree-img' src='{{ asset('images/' . $data['display_icon'] ) }}' />
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