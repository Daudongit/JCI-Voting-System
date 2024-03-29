<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts._opengraph')
    <title>{{ config('app.name', 'JCI Voting System') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/sweetalert.css')}}"> 
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    @stack('css')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    @include('layouts._sidebar')
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                @include('layouts._alert')
            </div>
        </div>
        @yield('content')
        @yield('modal_component')
    </div>
    <!-- Scripts -->
    <script type="text/javascript">
        var baseUrl = '{{url("/")}}'
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('js')
    <script src="{{asset('assets/js/custom.modal.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/sweetalert.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/sweetalert_init.js')}}"></script>
</body>
</html>
