@extends('layouts.admin.dashboard')

@section('title')
<title>GOLDEN MAG - PRODUCTS</title>
@endsection

@section('module-content')

<div class="row my-3">
    <div class="col-sm-6">
        <form class="form-inline"  method="GET" action="{{ route('admin.products.index') }}">
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
            <div class="col-sm-9">
                <div class="form-group row">
                    <input class="form-control col-12" type="search" name="search" value='{{ Request::get('search') }}' placeholder="Search" aria-label="Search">
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-6 text-right">
        <a href='{{ route('admin.products.create') }}' class='btn btn-primary my-2'>CREATE NEW PRODUCT</a>
    </div>
</div>
@include('common.serverresponse')
<div class="row">
    <div class="col-12">
        <table class="table table-hover table-striped text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Product Value</th>
                    <th>Flush Bonus Pts</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <th>{{ $product->id }}</th>
                    <td>{{ $product->code }}</a></td>
                    <td>{{ $product->name }}</td>
                    @if($product->price > 0)
                    <td>{{ number_format($product->price, 2) }}</td>
                    @else
                    <td>0</td>
                    @endif
                    @if($product->product_value > 0)
                    <td>{{ number_format($product->product_value, 2) }}</td>
                    @else
                    <td>0</td>
                    @endif
                    <td>{{$product->flush_bonus}}</td>
                    @if($product->type == 'ACT')
                    <td>ACTIVATION</td>
                    @else
                    <td>PRODUCT</td>
                    @endif
                    <td class='small'>
                        <a href="{{ route('admin.products.show', $product->slug) }}">View</a> | 
                        <a href="{{ route('admin.products.edit', $product->slug) }}">Update</a>
                    </td>
                </tr>
                @endforeach 
            </tbody>
        </table>

        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection