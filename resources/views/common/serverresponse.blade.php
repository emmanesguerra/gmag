
@if (session('status-success'))
<div class="card-body">
    <div class="alert alert-success text-left">
        {{ session('status-success') }}
    </div>
</div>
@endif

@if (session('status-failed'))
<div class="card-body">
    <div class="alert alert-danger text-left">
        {{ session('status-failed') }}
    </div>
</div>
@endif


@if (count($errors) > 0)
<div class="card-body">
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif