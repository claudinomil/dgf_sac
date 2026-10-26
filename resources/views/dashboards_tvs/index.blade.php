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
            /* ## INDICADORES - ESTILO BASE ## */
            .indicador-modelo1 {
                background: #202b3c;
                border: 1px solid #354156;
                border-radius: 10px;

                /* background-color: #2a3042;
                border: 1px solid #3b435a;
                border-radius: 8px; */
                min-width: 0;
            }

            .indicador-modelo1-dados {
                margin-top: 0;
                text-align: center;
                min-width: 0;
            }

            .indicador-modelo1-titulo {
                color: #20c997;
                font-size: 14px;
                line-height: 1.3;
            }

            .indicador-modelo1-valor {
                font-weight: bold;
                color: #ffffff;
                font-size: 24px;
                line-height: 1.3;
                overflow-wrap: anywhere;
            }

            .indicador-modelo1-icone {
                width: 70px;
                height: 70px;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                /* background-color: #343e56; */
                border-radius: 8px;
                color: #20c997;
                font-size: 30px;
            }

            /* ## INDICADORES - MOBILE - ATÉ 575 PX - Celulares ## */
            @media (max-width: 575.98px) {
                .indicador-modelo1 {
                    padding: 8px !important;
                }

                .indicador-modelo1-titulo {
                    font-size: 12px;
                }

                .indicador-modelo1-valor {
                    font-size: 20px;
                }

                .indicador-modelo1-icone {
                    width: 42px;
                    height: 42px;
                    font-size: 20px;
                    border-radius: 6px;
                }
            }

            /* ## INDICADORES - TABLET - 576 A 991 PX ## */
            @media (min-width: 576px) and (max-width: 991.98px) {
                .indicador-modelo1-titulo {
                    font-size: 13px;
                }

                .indicador-modelo1-valor {
                    font-size: 22px;
                }

                .indicador-modelo1-icone {
                    width: 56px;
                    height: 56px;
                    font-size: 25px;
                }
            }

            /* ## INDICADORES - NOTEBOOK / DESKTOP - 992 A 1599 PX ## */
            @media (min-width: 992px) and (max-width: 1599.98px) {
                .indicador-modelo1-titulo {
                    font-size: 14px;
                }

                .indicador-modelo1-valor {
                    font-size: 24px;
                }

                .indicador-modelo1-icone {
                    width: 64px;
                    height: 64px;
                    font-size: 28px;
                }
            }

            /* ## INDICADORES - TV / TELAS GRANDES - 1600 PX OU MAIS ## */
            @media (min-width: 1600px) {
                .indicador-modelo1 {
                    padding: 12px !important;
                }

                .indicador-modelo1-titulo {
                    font-size: 18px;
                }

                .indicador-modelo1-valor {
                    font-size: 32px;
                }

                .indicador-modelo1-icone {
                    width: 80px;
                    height: 80px;
                    font-size: 36px;
                }
            }

            /* ## INDICADORES - TV 4K - 2560 PX OU MAIS ## */
            @media (min-width: 2560px) {
                .indicador-modelo1 {
                    padding: 16px !important;
                }

                .indicador-modelo1-titulo {
                    font-size: 22px;
                }

                .indicador-modelo1-valor {
                    font-size: 40px;
                }

                .indicador-modelo1-icone {
                    width: 100px;
                    height: 100px;
                    font-size: 44px;
                }
            }











            #dashboard_indicadores_modelo2 .indicador-modelo2 {
                background: #202b3c;
                border: 1px solid #354156;
                border-radius: 10px;
                color: #fff;
            }

            .indicador-modelo2 .card-body {
                padding: 16px;
            }

            .indicador-modelo2-titulo {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 8px;
                color: #cbd5e1;
                font-size: 14px;
            }

            .indicador-modelo2-titulo i {
                font-size: 18px;
            }

            .indicador-modelo2-valor {
                margin-top: 12px;
                font-size: clamp(24px, 2vw, 36px);
                font-weight: 700;
                line-height: 1.2;
                color: #fff;
            }

            .indicador-modelo2-legenda {
                margin-top: 6px;
                font-size: 12px;
                color: #cbd5e1;
            }

            .indicador-modelo2-legenda span {
                color: #94a3b8;
            }

            .indicador-modelo2-grafico-mini {
                width: 100%;
                height: 65px;
                margin-top: 8px;
            }

            @media (min-width: 1600px) {
                .indicador-modelo2 .card-body {
                    padding: 20px;
                }

                .indicador-modelo2-titulo {
                    font-size: 17px;
                }

                .indicador-modelo2-legenda {
                    font-size: 14px;
                }

                .indicador-modelo2-grafico-mini {
                    height: 80px;
                }
            }
        </style>
    </head>
    <body class="w-100 h-100 m-0 p-0 overflow-hidden bg-dark">
        <div class="position-fixed top-0 start-0 w-100 vh-100 m-0 p-2 overflow-hidden">
            <div class="w-100 h-100 overflow-hidden">
                <div class="row p-2 mb-3">
                    <div class="col-4">
                        <img src="{{ asset('/assets/images/logo_cbmerj_dgf_branco.png') }}" height="50">
                    </div>
                    <div class="col-4 text-warning text-center align-self-center fw-bold nowrap">
                        DASHBOARD GERENCIAL
                    </div>
                    <div class="col-4 text-end">
                        <button type="button" class="btn btn-success" id="btn_tela_cheia">
                            <i class="bx bx-fullscreen"></i>
                        </button>
                    </div>
                </div>





                <div class="row g-3" id="dashboard_indicadores_modelo2"></div>
                
                <div class="p-3">&nbsp;</div>

                <!-- Indicadores abaixo do cabeçalho -->
                <div class="d-flex flex-wrap gap-2" id="dashboard_indicadores_modelo1"></div>
            </div>
        </div>

        @include('layouts.vendor-scripts')

        <script src="https://cdn.jsdelivr.net/npm/echarts@6/dist/echarts.min.js"></script>
        <script src="{{ asset('assets/js/scripts_dashboards_tvs.js') }}"></script>
    </body>
</html>