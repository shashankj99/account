<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- include custom styles --}}
    @include('layouts._styles')

    {{-- yield page styles --}}
    @yield('page-styles')
    
</head>

<body class="hold-transition {{ (Request::is('login')) ? 'login-page' : 'sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed' }} text-sm">
    @if (Request::is('login'))
        @yield('login-content')
    @else
        <div class="wrapper">
            
            @include('layouts._navbar')
            @include('layouts._sidebar')

            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid">
                        @yield('content-header')
                    </div>
                </section>
                <section class="content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </section>
            </div>
            
            @include('layouts._footer')

        </div>
    @endif
    
    {{-- custom scripts --}}
    @include('layouts._scripts')

    {{-- yield page scripts --}}
    @yield('page-scripts')

    <script>
        jQuery(function($) {
            @if (Session::has('success'))
                toastr.success("{{ Session::get('success') }}");
            @endif
            @if(Session::has('info'))
                toastr.info("{{ Session::get('info') }}");
            @endif
            @if(Session::has('error'))
                toastr.error("{{ Session::get('error') }}");
            @endif
        });
    </script>

</body>
</html>
