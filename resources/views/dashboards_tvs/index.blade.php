<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>DGF SAC - Dashboards TV</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('assets/images/image_favicon.png') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @include('layouts.head-css')
    </head>
    <body class="w-100 h-100 m-0 p-0 overflow-hidden bg-dark">
        <div class="position-fixed top-0 start-0 w-100 vh-100 m-0 p-2 overflow-hidden">
            <div class="w-100 h-100 overflow-hidden">
                <div class="row p-2 mb-3">
                    <div class="col-4">
                        <img src="{{ asset('/assets/images/logo_cbmerj_dgf_branco.png') }}" height="50">
                    </div>
                    <div class="col-4" id="dashboard_info">
                        DASHBOARD GERENCIAL
                    </div>
                    <div class="col-4 text-end">
                        <button type="button" class="btn btn-success" id="btn_tela_cheia">
                            <i class="bx bx-fullscreen"></i>
                        </button>
                    </div>
                </div>
                <div id="dashboard">
                    <div class="row mb-1 g-1" id="dashboard_indicadores_container"></div>
                    <div class="row g-1" id="dashboard_graficos_container"></div>
                </div>
            </div>
        </div>

        @include('layouts.vendor-scripts')

        <script src="https://cdn.jsdelivr.net/npm/echarts@6/dist/echarts.min.js"></script>
        <script src="{{ asset('assets/js/scripts_dashboards_tvs.js') }}"></script>
    </body>
</html>
