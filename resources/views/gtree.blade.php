@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Genealogy Tree</title>
@endsection

@section('pagetitle')
<i class="fa fa-sitemap"></i>  GRAPHICAL GENEALOGY TREE
@endsection

@section('module-content')

<div class="row p-3">
    <div class='col-12 contentheader100'>
        Genealogy Tree
    </div>
    <div class='col-12 card-content' style='position: relative'>
        @include('common.serverresponse')
        @if(app('request')->input('top'))
        <span style='position: absolute; top: 30px; right: 50px; z-index: 5'><a href='{{ route('gtree.index') }}'>Back to top</a></span>
        @endif
        <table class="table table-borderless table-hover gtree">
            <tbody>
                <tr class='gtree-rw0' style="text-align: center">
                    <td class="p-0" colspan="16">
                        <div class="row">
                            <span class="p-3 col-6 offset-3 center" style='border-bottom: 2px solid #666666;' data-target-id="0" id="row0">
                                @include('gtree-members', ['data' => $member[0], 'first' => true])
                            </span>
                        </div>
                    </td> <!-- lvl 0 -->
                </tr>
                <tr class='gtree-rw1' style="text-align: center">
                    <td class="p-3 td-border-l" colspan="8" width="50%">
                        @include('gtree-members', ['data' => $member[1]])
                    </td>  <!-- lvl 1 -->
                    <td class="p-3 td-border-r"  colspan="8" width="50%">
                        @include('gtree-members', ['data' => $member[2]])
                    </td>
                </tr>
                <tr class='gtree-rw2' style="text-align: center">
                    <td class="p-3" colspan="4">
                        @include('gtree-members', ['data' => $member[3]])
                    </td>  <!-- lvl 2 -->
                    <td class="p-3 td-border-l" colspan="4">
                        @include('gtree-members', ['data' => $member[4]])
                    </td>
                    <td class="p-3 td-border-r" colspan="4">
                        @include('gtree-members', ['data' => $member[5]])
                    </td>
                    <td class="p-3"  colspan="4">
                        @include('gtree-members', ['data' => $member[6]])
                    </td>
                </tr>
                <tr class='gtree-rw3' style="text-align: center">
                    <td class="p-3" colspan="2">
                        @include('gtree-members', ['data' => $member[7]])
                    </td>  <!-- lvl 3 -->
                    <td class="p-3" colspan="2">
                        @include('gtree-members', ['data' => $member[8]])
                    </td>
                    <td class="p-3" colspan="2">
                        @include('gtree-members', ['data' => $member[9]])
                    </td>
                    <td class="p-3 td-border-l" colspan="2">
                        @include('gtree-members', ['data' => $member[10]])
                    </td>
                    <td class="p-3 td-border-r" colspan="2">
                        @include('gtree-members', ['data' => $member[11]])
                    </td> 
                    <td class="p-3" colspan="2">
                        @include('gtree-members', ['data' => $member[12]])
                    </td>
                    <td class="p-3" colspan="2">
                        @include('gtree-members', ['data' => $member[13]])
                    </td>
                    <td class="p-3" colspan="2">
                        @include('gtree-members', ['data' => $member[14]])
                    </td>
                </tr>
            </tbody>
        </table>
        <div class='col-12'>
            <div class='row'>
                <div class='col-5 alert alert-light'>
                    <p>Instructions:</p>
                    <ol>
                        <li>Click the icon to Move Down the Genealogy</li>
                        <li>Click the icon at the top to Move Up the Genealogy</li>
                    </ol>
                </div>
                <div class='col-6 offset-1 alert alert-light'>
                    <p>Legends:</p>
                    <ul class='list-group list-group-horizontal text-center'>
                        <li class="list-group-item border-0"><img src='{{ asset('images/open_s.png') }}' style='margin-bottom: 4px;' width="42" /> <br /> Available</li>
                        @foreach($products as $product)
                        <li class="list-group-item border-0"><img src='{{ asset('images/' . $product->display_icon) }}' style='margin-bottom: 4px;' width="42" /> 
                            <br /> {{ $product->code }} 
                            <br /> {{ number_format($product->price,2) }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection