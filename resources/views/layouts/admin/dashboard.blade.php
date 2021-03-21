<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('title')
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:700, 600,500,400,300" rel="stylesheet" type="text/css">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body style="background-color: #d5dae5; font-family: 'Source Sans Pro', sans-serif; line-height: 1.15;">
    <div id="app" class="dashboard">
        <main style="float: left; width: 100%;">
            <div class="container p-0">
                @include('common.admin.leftsidebar')
                
                @include('common.admin.header')

                <div class="container">
                    <div class="row">
                        <div class="col-12 content-container m-2">
                            @yield('module-content')
                        </div>
                    </div>
                </div>
            </div>
        </main>
        @include('common.admin.footer')
    </div>   
    
    <div class="modal fade in" id="delete-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h4 class="modal-title">Danger!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p>You are about to remove this record (<strong id="idtobedeleted"></strong>:<strong id="texttobedeleted"></strong>) in the system. Do you wish to continue?</p>

                    <form id="deletemodalform" method="POST" accept-charset="UTF-8" style="display:inline">
                        <input name="_method" type="hidden" value="DELETE">
                        @csrf
                        <input class="btn btn-outline text-danger" type="submit" value="Delete">
                    </form>
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var showdeletemodal = function (id, text, url) {
            $('#deletemodalform').attr('action', url)
            $('#idtobedeleted').html(id);
            $('#texttobedeleted').html(text);
            $('#delete-modal').modal('show');
        }
    </script>
</body>
</html>
