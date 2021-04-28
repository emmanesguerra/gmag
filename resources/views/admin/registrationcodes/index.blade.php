@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - ENTRY CODES</title>
@endsection

@section('module-content')

<div class="row my-3">
    <div class="col-sm-9">
        <form class="form-inline"  method="GET" action="{{ route('admin.entrycodes.index') }}">
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
            <div class="col-sm-6">
                <div class="form-group row">
                    <input class="form-control col-12" type="search" name="search" value='{{ Request::get('search') }}' placeholder="Search for pincode1 and 2" aria-label="Search" onChange="this.form.submit()">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Status</label>
                    <div class="col-sm-6">
                        <select class="form-control" name='status' onChange="this.form.submit()">
                            @foreach(['Available','Used'] as $ctr => $value)
                            @if(Request::get('status') == $ctr)
                            <option value="{{ $ctr }}" selected>{{ $value }}</option>
                            @else 
                            <option value="{{ $ctr }}">{{ $value }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-3 text-right">
        <a href='{{ route('admin.entrycodes.create') }}' class='btn btn-primary my-2'>GENERATE ENTRY CODES</a>
    </div>
</div>
@include('common.serverresponse')
<div class="row">
    <div class="col-12">
        <table class="table table-hover table-striped text-center">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Date Created</th>
                    <th>Assigned To</th>
                    <th>Pincode 1</th>
                    <th>Pincode 2</th>
                    <th>Created By</th>
                    <th>Package Type</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entrycodes as $entrycode)
                <tr>
                    <th>{{ $entrycode->id }}</th>
                    <td>{{ $entrycode->created_at }}</a></td>
                    <td>{{ ($entrycode->member) ? $entrycode->member->username : "" }}</td>
                    <td>{{ $entrycode->pincode1 }}</td>
                    <td>{{ $entrycode->pincode2 }}</td>
                    <td>{{ $entrycode->creator->name }}</td>
                    <td>{{ $entrycode->product->name }}</td>
                    <td>{{ number_format($entrycode->product->price) }}</td>
                    <td>{{ ($entrycode->is_used) ? 'Used' : 'Available' }}</td>
                    <td>{{ $entrycode->remarks }}</td>
                    <td class='small'> 
                        <a href="{{ route('admin.entrycodes.edit', $entrycode->id) }}">Update</a> | 
                        <a href="#" 
                           onclick="showdeletemodal('{{ $entrycode->id }}', '', '{{ route('admin.entrycodes.delete', $entrycode->id) }}')" >Delete</a>
                    </td>
                </tr>
                @endforeach 
            </tbody>
        </table>

        {{ $entrycodes->withQueryString()->links() }}
    </div>
</div>
@endsection