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
    <body>
        <div class="row">
            <div class="col-12">
                <div class="card border-0 mb-4">
                    <div class="card-body">
                        <!-- Topo -->
                        <div class="d-flex align-items-center alert alert-secondary p-1 mb-2">
                            <div class="me-3">
                                <i class="bx bx-import img-thumbnail font-size-24" id="int_topo_icone"></i>
                            </div>
                            <div class="me-3">
                                <div class="text-muted">
                                    <h5 class="mb-1" id="int_topo_titulo"></h5>
                                </div>
                            </div>
                            <div class="ms-auto dropdown">
                                <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown">
                                    <i class="bx bxs-cog align-middle me-1"></i> {{ __('Integrações') }}
                                </button>

                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#" onclick="intTopo(1)">Importações SAC antigo</a>
                                    <a class="dropdown-item" href="#" onclick="intTopo(2)">XXXYYYZZZ</a>
                                </div>
                            </div>
                        </div>

                        <!-- Importações SAC antigo -->
                        <div style="display: none;" id="int_importacoes_sac_antigo">
                            <div class="row">
                                <div class="col-12 col-sm-12">
                                    <div class="alert alert-primary">
                                        <div class="row g-2">

                                            <!-- Integrar Bancos -->
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Integrar Bancos</p>
                                                        <button type="button" class="btn btn-success btn-sm waves-effect waves-light font-size-12" id="impsac_btn_integrar_bancos" onclick="impsacIntegrarBancos();">Integrar Bancos</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="int_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="int_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Situações -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 col-xxl-2">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Situações</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_situacoes" onclick="impsacAtualizarDados('situacoes');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabsit_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabsit_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Graduações -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 col-xxl-2">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Graduações</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_graduacoes" onclick="impsacAtualizarDados('graduacoes');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabgra_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabgra_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Unidades -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 col-xxl-2">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Unidades</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_unidades" onclick="impsacAtualizarDados('unidades');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabuni_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabuni_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Quadros -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 col-xxl-2">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Quadros</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_quadros" onclick="impsacAtualizarDados('quadros');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabqua_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabqua_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Funções -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 col-xxl-2">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Funções</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_funcoes" onclick="impsacAtualizarDados('funcoes');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabfun_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabfun_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Estados Civis -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 col-xxl-2">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Estados Civis</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_estados_civis" onclick="impsacAtualizarDados('estados_civis');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabetc_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabetc_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Comportamentos -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 col-xxl-2">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Comportamentos</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_comportamentos" onclick="impsacAtualizarDados('comportamentos');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabcom_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabcom_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tipos Sanguíneos -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 col-xxl-2">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Tipos Sanguíneos</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_tipos_sanguineos" onclick="impsacAtualizarDados('tipos_sanguineos');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabtps_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabtps_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Fatores RH -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 col-xxl-2">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Fatores RH</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_fatores_rh" onclick="impsacAtualizarDados('fatores_rh');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabfrh_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabfrh_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Nacionalidades -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 col-xxl-2">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Nacionalidades</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_nacionalidades" onclick="impsacAtualizarDados('nacionalidades');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabnac_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabnac_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Naturalidades -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 col-xxl-2">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Naturalidades</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_naturalidades" onclick="impsacAtualizarDados('naturalidades');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabnat_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabnat_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Escolaridades -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 col-xxl-2">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Escolaridades</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_escolaridades" onclick="impsacAtualizarDados('escolaridades');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabesc_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabesc_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sexos Biologicos -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 col-xxl-2">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Sexos Biologicos</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_sexos_biologicos" onclick="impsacAtualizarDados('sexos_biologicos');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabsxb_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabsxb_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Bancos -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 col-xxl-2">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Bancos</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_bancos" onclick="impsacAtualizarDados('bancos');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabban_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabban_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Cursos -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 col-xxl-2">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Cursos</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_cursos" onclick="impsacAtualizarDados('cursos');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabcur_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabcur_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Parentescos -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 col-xxl-2">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Parentescos</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_parentescos" onclick="impsacAtualizarDados('parentescos');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabpar_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabpar_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tempos Averbados Locais -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-4 col-xxl-4">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Tempos Averbados Locais</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_tempos_averbados_locais" onclick="impsacAtualizarDados('tempos_averbados_locais');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabtal_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabtal_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">&nbsp;</div>


                                            <!-- Militares 1 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares 1</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_1" onclick="impsacAtualizarDados('militares_1');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmil1_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmil1_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares 2 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares 2</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_2" onclick="impsacAtualizarDados('militares_2');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmil2_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmil2_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares 3 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares 3</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_3" onclick="impsacAtualizarDados('militares_3');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmil3_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmil3_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares 4 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares 4</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_4" onclick="impsacAtualizarDados('militares_4');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmil4_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmil4_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">&nbsp;</div>


                                            <!-- Militares Cursos 1 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Cursos 1</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_cursos_1" onclick="impsacAtualizarDados('militares_cursos_1');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabcco1_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabcco1_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Cursos 2 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Cursos 2</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_cursos_2" onclick="impsacAtualizarDados('militares_cursos_2');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabcco2_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabcco2_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Cursos 3 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Cursos 3</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_cursos_3" onclick="impsacAtualizarDados('militares_cursos_3');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabcco3_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabcco3_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Cursos 4 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Cursos 4</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_cursos_4" onclick="impsacAtualizarDados('militares_cursos_4');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabcco4_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabcco4_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Cursos 5 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Cursos 5</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_cursos_5" onclick="impsacAtualizarDados('militares_cursos_5');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabcco5_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabcco5_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Cursos 6 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Cursos 6</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_cursos_6" onclick="impsacAtualizarDados('militares_cursos_6');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabcco6_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabcco6_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Cursos 7 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Cursos 7</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_cursos_7" onclick="impsacAtualizarDados('militares_cursos_7');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabcco7_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabcco7_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Cursos 8 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Cursos 8</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_cursos_8" onclick="impsacAtualizarDados('militares_cursos_8');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabcco8_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabcco8_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">&nbsp;</div>


                                            <!-- Militares Ajudas Custos -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-12 col-xxl-12">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Ajudas Custos</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ajudas_custos" onclick="impsacAtualizarDados('militares_ajudas_custos');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabacu_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabacu_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">&nbsp;</div>


                                            <!-- Militares Auxílios Fardamentos 1 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-4 col-xxl-4">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Auxílios Fardamentos 1</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_auxilios_fardamentos_1" onclick="impsacAtualizarDados('militares_auxilios_fardamentos_1');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabaxf1_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabaxf1_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Auxílios Fardamentos 2 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-4 col-xxl-4">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Auxílios Fardamentos 2</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_auxilios_fardamentos_2" onclick="impsacAtualizarDados('militares_auxilios_fardamentos_2');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabaxf2_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabaxf2_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Auxílios Fardamentos 3 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-4 col-xxl-4">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Auxílios Fardamentos 3</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_auxilios_fardamentos_3" onclick="impsacAtualizarDados('militares_auxilios_fardamentos_3');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabaxf3_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabaxf3_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">&nbsp;</div>


                                            <!-- Militares Fundos Saúde 1 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Fundos Saúde 1</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_fundos_saude_1" onclick="impsacAtualizarDados('militares_fundos_saude_1');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabfsa1_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabfsa1_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Fundos Saúde 2 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Fundos Saúde 2</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_fundos_saude_2" onclick="impsacAtualizarDados('militares_fundos_saude_2');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabfsa2_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabfsa2_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Fundos Saúde 3 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Fundos Saúde 3</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_fundos_saude_3" onclick="impsacAtualizarDados('militares_fundos_saude_3');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabfsa3_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabfsa3_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Fundos Saúde 4 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Fundos Saúde 4</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_fundos_saude_4" onclick="impsacAtualizarDados('militares_fundos_saude_4');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabfsa4_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabfsa4_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">&nbsp;</div>


                                            <!-- Militares Fundos Saúde Controle -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-12 col-xxl-12">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Fundos Saúde Controle</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_fundos_saude_controle" onclick="impsacAtualizarDados('militares_fundos_saude_controle');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabfsc_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabfsc_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">&nbsp;</div>


                                            <!-- Militares Fundos Saúde Adesão -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-12 col-xxl-12">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Fundos Saúde Adesão</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_fundos_saude_adesao" onclick="impsacAtualizarDados('militares_fundos_saude_adesao');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabfsd_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabfsd_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">&nbsp;</div>


                                            <!-- Militares Dependentes 1 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Dependentes 1</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_dependentes_1" onclick="impsacAtualizarDados('militares_dependentes_1');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmde1_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmde1_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Dependentes 2 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Dependentes 2</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_dependentes_2" onclick="impsacAtualizarDados('militares_dependentes_2');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmde2_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmde2_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Dependentes 3 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Dependentes 3</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_dependentes_3" onclick="impsacAtualizarDados('militares_dependentes_3');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmde3_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmde3_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Dependentes 4 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Dependentes 4</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_dependentes_4" onclick="impsacAtualizarDados('militares_dependentes_4');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmde4_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmde4_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Dependentes 5 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-4 col-xxl-4">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Dependentes 5</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_dependentes_5" onclick="impsacAtualizarDados('militares_dependentes_5');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmde5_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmde5_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Dependentes 6 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-4 col-xxl-4">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Dependentes 6</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_dependentes_6" onclick="impsacAtualizarDados('militares_dependentes_6');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmde6_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmde6_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Dependentes 7 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-4 col-xxl-4">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Dependentes 7</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_dependentes_7" onclick="impsacAtualizarDados('militares_dependentes_7');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmde7_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmde7_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">&nbsp;</div>


                                            <!-- Militares Tempos Averbados -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-12 col-xxl-12">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Tempos Averbados</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_tempos_averbados" onclick="impsacAtualizarDados('militares_tempos_averbados');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmta_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmta_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">&nbsp;</div>


                                            <!-- Militares Pensões 1 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-6 col-xxl-6">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Pensões 1</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_pensoes_1" onclick="impsacAtualizarDados('militares_pensoes_1');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmpe1_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmpe1_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Pensões 2 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-6 col-xxl-6">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Pensões 2</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_pensoes_2" onclick="impsacAtualizarDados('militares_pensoes_2');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmpe2_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmpe2_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-12">&nbsp;</div>


                                            <!-- Militares Férias 1 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 1</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_1" onclick="impsacAtualizarDados('militares_ferias_1');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe1_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe1_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 2 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 2</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_2" onclick="impsacAtualizarDados('militares_ferias_2');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe2_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe2_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 3 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 3</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_3" onclick="impsacAtualizarDados('militares_ferias_3');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe3_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe3_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 4 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 4</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_4" onclick="impsacAtualizarDados('militares_ferias_4');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe4_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe4_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 5 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 5</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_5" onclick="impsacAtualizarDados('militares_ferias_5');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe5_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe5_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 6 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 6</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_6" onclick="impsacAtualizarDados('militares_ferias_6');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe6_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe6_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 7 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 7</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_7" onclick="impsacAtualizarDados('militares_ferias_7');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe7_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe7_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 8 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 8</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_8" onclick="impsacAtualizarDados('militares_ferias_8');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe8_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe8_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 9 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 9</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_9" onclick="impsacAtualizarDados('militares_ferias_9');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe9_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe9_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 10 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 10</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_10" onclick="impsacAtualizarDados('militares_ferias_10');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe10_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe10_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 11 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 11</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_11" onclick="impsacAtualizarDados('militares_ferias_11');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe11_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe11_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 12 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 12</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_12" onclick="impsacAtualizarDados('militares_ferias_12');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe12_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe12_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 13 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 13</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_13" onclick="impsacAtualizarDados('militares_ferias_13');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe13_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe13_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 14 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 14</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_14" onclick="impsacAtualizarDados('militares_ferias_14');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe14_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe14_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 15 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 15</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_15" onclick="impsacAtualizarDados('militares_ferias_15');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe15_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe15_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 16 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 16</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_16" onclick="impsacAtualizarDados('militares_ferias_16');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe16_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe16_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 17 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 17</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_17" onclick="impsacAtualizarDados('militares_ferias_17');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe17_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe17_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 18 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 18</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_18" onclick="impsacAtualizarDados('militares_ferias_18');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe18_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe18_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 19 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 19</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_19" onclick="impsacAtualizarDados('militares_ferias_19');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe19_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe19_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 20 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 20</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_20" onclick="impsacAtualizarDados('militares_ferias_20');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe20_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe20_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 21 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 21</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_21" onclick="impsacAtualizarDados('militares_ferias_21');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe21_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe21_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 22 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 22</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_22" onclick="impsacAtualizarDados('militares_ferias_22');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe22_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe22_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 23 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 23</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_23" onclick="impsacAtualizarDados('militares_ferias_23');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe23_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe23_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 24 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 24</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_24" onclick="impsacAtualizarDados('militares_ferias_24');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe24_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe24_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 25 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 25</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_25" onclick="impsacAtualizarDados('militares_ferias_25');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe25_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe25_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 26 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 26</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_26" onclick="impsacAtualizarDados('militares_ferias_26');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe26_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe26_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 27 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 27</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_27" onclick="impsacAtualizarDados('militares_ferias_27');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe27_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe27_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 28 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 28</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_28" onclick="impsacAtualizarDados('militares_ferias_28');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe28_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe28_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 29 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 29</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_29" onclick="impsacAtualizarDados('militares_ferias_29');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe29_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe29_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 30 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 30</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_30" onclick="impsacAtualizarDados('militares_ferias_30');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe30_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe30_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 31 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 31</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_31" onclick="impsacAtualizarDados('militares_ferias_31');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe31_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe31_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 32 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 32</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_32" onclick="impsacAtualizarDados('militares_ferias_32');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe32_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe32_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 33 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 33</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_33" onclick="impsacAtualizarDados('militares_ferias_33');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe33_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe33_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 34 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 34</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_34" onclick="impsacAtualizarDados('militares_ferias_34');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe34_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe34_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 35 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 35</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_35" onclick="impsacAtualizarDados('militares_ferias_35');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe35_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe35_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 36 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 36</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_36" onclick="impsacAtualizarDados('militares_ferias_36');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe36_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe36_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 37 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 37</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_37" onclick="impsacAtualizarDados('militares_ferias_37');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe37_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe37_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 38 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 38</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_38" onclick="impsacAtualizarDados('militares_ferias_38');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe38_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe38_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 39 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 39</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_39" onclick="impsacAtualizarDados('militares_ferias_39');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe39_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe39_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Militares Férias 40 -->
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <p class="text-muted font-size-12">Militares Férias 40</p>
                                                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light font-size-12" id="impsac_btn_militares_ferias_40" onclick="impsacAtualizarDados('militares_ferias_40');">Atualizar Dados</button>
                                                    </div>
                                                    <div class="card-footer bg-transparent border-top">
                                                        <div class="row flex-nowrap justify-content-center g-4 text-center">
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bxs-data font-size-20"></i>
                                                                <span class="text-danger font-size-20" id="tabmfe40_quantidade_banco_1">0</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center gap-2">
                                                                <i class="bx bx-data font-size-20"></i>
                                                                <span class="text-success font-size-20" id="tabmfe40_quantidade_banco_2">0</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- XXXYYYZZZ -->
                        <div style="display: none;" id="int_xxxyyyzzz">XXXYYYZZZ</div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.vendor-scripts')

        <!-- scripts_integracoes.js -->
        <script src="{{ asset('assets/js/scripts_integracoes.js')}}"></script>
    </body>
</html>
