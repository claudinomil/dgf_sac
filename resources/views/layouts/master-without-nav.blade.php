<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title>DGF SAC - @yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('assets/images/image_favicon.png')}}">

        @vite(['resources/css/app.css','resources/js/app.js'])
        @include('layouts.head-css')
    </head>

        @yield('body')
        @yield('content')
        @include('layouts.vendor-scripts')
    </body>
</html>
