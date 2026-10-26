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

        <style>
            .indicador {
                background-color: #2a3042;
                border: 1px solid #3b435a;
            }

            .indicador-dados {
                margin-top: 0;
                text-align: center;
            }

            .indicador-titulo {
                color: #20c997;
                font-size: 14px;
            }

            .indicador-valor {
                font-weight: bold;
                color: #ffffff;
                font-size: 24px;
            }

            .indicador-icone {
                width: 70px;
                height: 70px;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #343e56;
                border-radius: 8px;
                color: #20c997;
                font-size: 30px;
            }
        </style>
    </head>
    <body class="w-100 h-100 m-0 p-0 overflow-hidden bg-dark">
        <div id="dashboard" class="position-fixed top-0 start-0 w-100 vh-100 m-0 p-2 overflow-hidden">
            <div id="dashboard_conteudo" class="w-100 h-100 overflow-hidden">
                <div id="dashboard_header" class="row p-2 mb-3">
                    <div class="col-4">
                        <img src="{{ asset('/assets/images/logo_cbmerj_dgf_branco.png') }}" height="50">
                    </div>
                    <div class="col-4 text-warning text-center align-self-center fw-bold nowrap" id="dashboard_titulo">
                        DASHBOARD GERENCIAL
                    </div>
                    <div class="col-4 text-end">
                        <button type="button" class="btn btn-success" id="btn_tela_cheia">
                            <i class="bx bx-fullscreen"></i>
                        </button>
                    </div>
                </div>

                <!-- Indicadores abaixo do cabeçalho -->
                <div id="dashboard_indicadores" class="d-flex flex-wrap gap-2">

                    <!-- Cartão com ícone à esquerda -->
                    <div class="indicador flex-fill p-2 rounded">
                        <div class="d-flex align-items-start gap-3">
                            <div class="indicador-icone">
                                <i class="fas fa-users"></i>
                            </div>

                            <div class="indicador-dados">
                                <div class="indicador-titulo">Total de Militares</div>
                                <div class="indicador-valor">12.450</div>
                            </div>
                        </div>
                    </div>

                    <!-- Sem Imagem -->
                    <div class="indicador flex-fill p-2 rounded">
                        <div class="indicador-dados">
                            <div class="indicador-titulo">Total de Férias</div>
                            <div class="indicador-valor">3.000</div>
                        </div>
                    </div>

                    <!-- Cartão com ícone à direita -->
                    <div class="indicador flex-fill p-2 rounded">
                        <div class="d-flex align-items-start gap-3">
                            <div class="indicador-dados flex-fill">
                                <div class="indicador-titulo">Total de Tempos Averbados</div>
                                <div class="indicador-valor">450</div>
                            </div>

                            <div class="indicador-icone">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Sem Imagem -->
                    <div class="indicador flex-fill p-2 rounded">
                        <div class="indicador-dados">
                            <div class="indicador-titulo">Total de Férias</div>
                            <div class="indicador-valor">3.000</div>
                        </div>
                    </div>

                    <!-- Cartão com ícone à esquerda -->
                    <div class="indicador flex-fill p-2 rounded">
                        <div class="d-flex align-items-start gap-3">
                            <div class="indicador-icone">
                                <i class="fas fa-users"></i>
                            </div>

                            <div class="indicador-dados">
                                <div class="indicador-titulo">Total de Militares</div>
                                <div class="indicador-valor">12.450</div>
                            </div>
                        </div>
                    </div>

                    <!-- Sem Imagem -->
                    <div class="indicador flex-fill p-2 rounded">
                        <div class="indicador-dados">
                            <div class="indicador-titulo">Total de Férias</div>
                            <div class="indicador-valor">3.000</div>
                        </div>
                    </div>

                    <!-- Cartão com ícone à direita -->
                    <div class="indicador flex-fill p-2 rounded">
                        <div class="d-flex align-items-start gap-3">
                            <div class="indicador-dados flex-fill">
                                <div class="indicador-titulo">Total de Tempos Averbados</div>
                                <div class="indicador-valor">450</div>
                            </div>

                            <div class="indicador-icone">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Sem Imagem -->
                    <div class="indicador flex-fill p-2 rounded">
                        <div class="indicador-dados">
                            <div class="indicador-titulo">Total de Férias</div>
                            <div class="indicador-valor">3.000</div>
                        </div>
                    </div>

                    <!-- Cartão com ícone à esquerda -->
                    <div class="indicador flex-fill p-2 rounded">
                        <div class="d-flex align-items-start gap-3">
                            <div class="indicador-icone">
                                <i class="fas fa-users"></i>
                            </div>

                            <div class="indicador-dados">
                                <div class="indicador-titulo">Total de Militares</div>
                                <div class="indicador-valor">12.450</div>
                            </div>
                        </div>
                    </div>

                    <!-- Sem Imagem -->
                    <div class="indicador flex-fill p-2 rounded">
                        <div class="indicador-dados">
                            <div class="indicador-titulo">Total de Férias</div>
                            <div class="indicador-valor">3.000</div>
                        </div>
                    </div>

                    <!-- Cartão com ícone à direita -->
                    <div class="indicador flex-fill p-2 rounded">
                        <div class="d-flex align-items-start gap-3">
                            <div class="indicador-dados flex-fill">
                                <div class="indicador-titulo">Total de Tempos Averbados</div>
                                <div class="indicador-valor">450</div>
                            </div>

                            <div class="indicador-icone">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Sem Imagem -->
                    <div class="indicador flex-fill p-2 rounded">
                        <div class="indicador-dados">
                            <div class="indicador-titulo">Total de Férias</div>
                            <div class="indicador-valor">3.000</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @include('layouts.vendor-scripts')

        <script src="https://cdn.jsdelivr.net/npm/echarts@6/dist/echarts.min.js"></script>
        <script src="{{ asset('assets/js/scripts_dashboards_tvs.js') }}"></script>
    </body>
</html>
