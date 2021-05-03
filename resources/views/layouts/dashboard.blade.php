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

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:700, 600,500,400,300" rel="stylesheet" type="text/css">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    
    <!-- For font awesome -->
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    @yield('css')
</head>
<body style="background-color: #d5dae5; font-family: 'Source Sans Pro', sans-serif; line-height: 1.15;">
    <div class="dashboard">
        <main>
            <div class="container p-0">
                @include('common.leftsidebar')
                
                <div class="row pagehead100 py-2">
                    <div class="col-4 pl-0">
                        <span class="pagetitle100">
                            @yield('pagetitle')
                        </span>
                    </div>
                    <div class="col-8 text-right">
                        <span style=" float:right; color:#fcee7d; font-weight:normal; font-size:15px;">
                            @if(Auth::guard('admin')->check())
                                <i class="fa fa-user"></i> {{Auth::guard('admin')->user()->name}}
                            @elseif(Auth::guard('web')->check())
                                <i class="fa fa-user"></i> {{Auth::guard('web')->user()->username}}
                            @endif
                        </span>
                    </div>
                </div>

                @yield('module-content')
            </div>
        </main>
    </div>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('javascripts')
</body>
</html>
