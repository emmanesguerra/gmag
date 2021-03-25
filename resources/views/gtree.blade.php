@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - CONTROL PANEL</title>
@endsection

@section('pagetitle')
<i class="fa fa-group"></i>  GRAPHICAL GENEALOGY TREE
@endsection

@section('module-content')

<div class="row p-3">
    <div class='col-12 contentheader100'>
        Genealogy Tree
    </div>
    <div class='col-12 card-content' style='position: relative'>
        @if(app('request')->input('top'))
        <span style='position: absolute; top: 15px; right: 25px; z-index: 5'><a href='{{ route('gtree.index') }}'>Back to top</a></span>
        @endif
        <table class="table table-borderless table-hover gtree">
            <tbody>
                <tr style="text-align: center">
                    <td class="p-0" colspan="16">
                        <div class="row">
                            <span class="p-3 col-6 offset-3 center" style='border-bottom: 2px solid #666666;' data-target-id="0" id="row0">
                                @include('gtree-members', ['data' => $member[0], 'first' => true])
                            </span>
                        </div>
                    </td> <!-- lvl 0 -->
                </tr>
                <tr style="text-align: center">
                    <td class="p-3 td-border-l" colspan="8">
                        @include('gtree-members', ['data' => $member[1]])
                    </td>  <!-- lvl 1 -->
                    <td class="p-3 td-border-r"  colspan="8">
                        @include('gtree-members', ['data' => $member[2]])
                    </td>
                </tr>
                <tr style="text-align: center">
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
                <tr style="text-align: center">
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
                <div class='col-5 offset-2 alert alert-light'>
                    <p>Legends:</p>
                    <ul class='list-group list-group-horizontal text-center'>
                        <li class="list-group-item border-0"><img src='{{ asset('images/open.png') }}' style='margin-bottom: 4px;' width="42" /> <br /> Available</li>
                        <li class="list-group-item border-0"><img src='{{ asset('images/starter.png') }}' style='margin-bottom: 4px;' width="42" /> <br /> STARTER <br />1,998</li>
                        <li class="list-group-item border-0"><img src='{{ asset('images/bronze.png') }}' style='margin-bottom: 4px;' width="42" /> <br /> BRONZE <br />5,998</li>
                        <li class="list-group-item border-0"><img src='{{ asset('images/silver.png') }}' style='margin-bottom: 4px;' width="42" /> <br /> SILVER <br />19,998</li>
                        <li class="list-group-item border-0"><img src='{{ asset('images/gold.png') }}' style='margin-bottom: 4px;' width="42" /> <br /> GOLD <br />49,998</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascripts')
<script>

//    $('.need-data').each(function() {
//        var targetId = $(this).data('target-id');
//        var id = $('#'+targetId).data('id');
//        var position = $(this).data('position');
//        
//        console.log(targetId);
//        console.log(id);
//        console.log(position);
//        
//        var element = this;
//        $.ajax({
//            url: "{{ route('gtree.member.data') }}",  
//            method: "POST",
//            data: { "id": id, "position": position, "_token": "{{ csrf_token() }}"},
//            async: false,
//            success: function(result){
//                $(element).data('id', result.target_id)
//                $(element).html("<img class='gtree-img' src='"+result.image+"' /><br /><br />"+result.username);
//            },error: function () {
//                $(element).data('id', 0)
//                $(element).html("<img class='gtree-img' src='{{ asset('images/open.png') }}' /><br /><br />");
//            }
//        });
//
//    });

</script>
@endsection