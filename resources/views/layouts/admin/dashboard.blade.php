<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('title')
    
    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    
    <!-- For font awesome -->
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    @yield('css')
</head>
<body style="background-color: #d5dae5; line-height: 1.15;">
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        
        var getAjaxErrorMessage = function (xHr) {
            console.log(typeof(xHr.responseJSON.errors));
            var error = '';
            if(typeof(xHr.responseJSON.errors) !== 'undefined') {
                $.each(xHr.responseJSON.errors, function(index, errors) {
                    $.each(errors, function(index, err) {
                        error += err + '<br />';
                    });
                });
            } else {
                error = xHr.responseJSON.message;
            }
            return error;
        }

        var showdeletemodal = function (id, text, url) {
            $('#deletemodalform').attr('action', url)
            $('#idtobedeleted').html(id);
            $('#texttobedeleted').html(text);
            $('#delete-modal').modal('show');
        }
    </script>
    @yield('javascripts')
</body>
</html>
