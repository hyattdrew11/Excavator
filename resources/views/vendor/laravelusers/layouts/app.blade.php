<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@if (trim($__env->yieldContent('template_title')))@yield('template_title') | @endif {{ config('app.name', 'Excavator') }}</title>

        {{-- Styles --}}
        @if(config('laravelusers.enableBootstrapCssCdn'))
            <link rel="stylesheet" type="text/css" href="{{ config('laravelusers.bootstrapCssCdn') }}">
        @endif
        @if(config('laravelusers.enableAppCss'))
            <link rel="stylesheet" type="text/css" href="{{ asset(config('laravelusers.appCssPublicFile')) }}">
        @endif

        @yield('template_linked_css')

        {{-- Scripts --}}
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>


        <!-- Scripts -->
    <script src="http://localhost:8000/js/app.js" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="/css/fonts/nunito.css" rel="stylesheet">
    <link href="/css/fontawesome/fontawesome.min.css" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img id="brand" src="http://localhost:8000/img/dig.png">
                        {{ config('app.name', 'Excavator') }}
                    </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

            <main class="">
                <adminleftnav></adminleftnav>
                @yield('content')
                <!-- <adminhelp></adminhelp> -->
                <!-- <adminprofile></adminprofile> -->
                <!-- <adminnotifications></adminnotifications> -->
            </main>
        </div>

        {{-- Scripts --}}
        @if(config('laravelusers.enablejQueryCdn'))
            <script src="{{ asset(config('laravelusers.jQueryCdn')) }}"></script>
        @endif
        @if(config('laravelusers.enableBootstrapPopperJsCdn'))
            <script src="{{ asset(config('laravelusers.bootstrapPopperJsCdn')) }}"></script>
        @endif
        @if(config('laravelusers.enableBootstrapJsCdn'))
            <script src="{{ asset(config('laravelusers.bootstrapJsCdn')) }}"></script>
        @endif
        @if(config('laravelusers.enableAppJs'))
            <script src="{{ asset(config('laravelusers.appJsPublicFile')) }}"></script>
        @endif
        @include('laravelusers::scripts.toggleText')

        @yield('template_scripts')

    </body>
</html>
