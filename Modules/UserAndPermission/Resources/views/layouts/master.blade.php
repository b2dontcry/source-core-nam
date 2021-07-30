<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>

        <link rel="icon" href="{{ asset('static/imgs/favicon.ico') }}">
        <link rel="stylesheet" href="{{ asset('static/backend/css/userandpermission.css') }}">

    </head>
    <body class="sidebar-mini layout-fixed
        @if (! is_null(auth()->user()->setting) && auth()->user()->setting != 'default')
            @php
                [$theme, $color] = explode('-', auth()->user()->setting->theme);
            @endphp
            {{ "accent-{$color}" }}
            {{ "{$theme}-mode" }}
        @endif" style="height: auto;">
        <div class="wrapper">
            <x-userandpermission-navbar />
            <x-userandpermission-sidebar />
            <div class="content-wrapper" style="min-height: calc(100vh - 57px);">
                @yield('content')
            </div>
        </div>

        <div id="loading">
            <div id="loading-icon-1">
                <div id="loading-icon-2">
                    <div id="loading-icon-3">
                        <div id="loading-icon-4"></div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="locale" value="{{ app()->getLocale() }}" />

        <script src="{{ asset('static/backend/js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>
