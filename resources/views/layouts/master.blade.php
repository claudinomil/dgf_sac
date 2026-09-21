<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title>DGF SAC - @yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="shortcut icon" href="{{ asset('assets/images/image_favicon.png') }}">

        @vite(['resources/css/app.css','resources/js/app.js'])
        @include('layouts.head-css')
    </head>

    @section('body')

    @if(session('userContext.user.layout_menu') == 1)
    <body data-sidebar="dark" style="background-color: #f8f8fb;">
    @endif

    @if(session('userContext.user.layout_menu') == 2)
    <body data-topbar="dark" data-layout="horizontal">
    @endif

        @show
        <div id="layout-wrapper">
            @if(session('userContext.user.layout_menu') == 1)
                @include('layouts.topbar')
                @include('layouts.sidebar')
            @endif

            @if(session('userContext.user.layout_menu') == 2)
                @include('layouts.horizontal')
            @endif

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <!-- Hiddens -->
                        <input type="hidden" id="crudPrefixPermissaoSubmodulo" name="crudPrefixPermissaoSubmodulo" value="{{ session('crudPrefixPermissaoSubmodulo') }}">
                        <input type="hidden" id="crudNameSubmodulo" name="crudNameSubmodulo" value="{{ session('crudNameSubmodulo') }}">
                        <input type="hidden" id="crudNameFormSubmodulo" name="crudNameFormSubmodulo" value="{{ session('crudNameFormSubmodulo') }}">
                        <input type="hidden" id="crudFieldsFormSubmodulo" name="crudFieldsFormSubmodulo" value="{{ session('crudFieldsFormSubmodulo') }}">

                        <!-- crudFormAjaxLoading -->
                         <div class="modal-loading" id="crudFormAjaxLoading" style="display: none;">
                            <div class="spinner-chase">
                                <div class="chase-dot"></div>
                                <div class="chase-dot"></div>
                                <div class="chase-dot"></div>
                                <div class="chase-dot"></div>
                                <div class="chase-dot"></div>
                                <div class="chase-dot"></div>
                            </div>
                        </div>

                        @yield('content')
                    </div>
                </div>

                @include('layouts.offcanva-profille')

                @if(session('crudPrefixPermissaoSubmodulo') == 'militares')
                    @include('layouts.offcanva-informacoes-militar')
                @endif

                @include('layouts.footer')
            </div>
        </div>

        @include('layouts.vendor-scripts')
    </body>
</html>
