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
    <body class="sidebar-mini layout-fixed {{ ! is_null(auth('phuongnam')->user()->setting) ? 'accent-'.auth('phuongnam')->user()->setting->color : '' }}" style="height: auto;">
        <div class="wrapper">
            <x-navbar />
            <x-sidebar />
            <div class="content-wrapper" style="min-height: calc(100vh - 57px);">
                @yield('content')
            </div>
        </div>

        <div id="loading"></div>

        <script src="{{ asset('static/backend/js/userandpermission.js') }}"></script>
        <script src="{{ asset('static/backend/js/common.js') }}"></script>
        <script src="{{ asset('static/backend/js/helpers.js') }}"></script>
        <script>
            helper.locale = '{{ app()->getLocale() }}';
        </script>
        @stack('scripts')
    </body>
</html>
