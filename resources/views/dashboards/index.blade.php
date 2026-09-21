@extends('layouts.master')

@section('title')
{{ __('Dashboards') }}
@endsection

@section('topbar_title')
{{ __('Dashboards') }}
@endsection

@section('content')

<div id="crudTable">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 mb-4">
                <div class="card-body">
                    <!-- Topo -->
                    <div class="d-flex align-items-center alert alert-secondary p-1 mb-2">
                        <div class="me-3">
                            <i class="bx bxs-dashboard img-thumbnail font-size-24"></i>
                        </div>
                        <div class="me-3">
                            <div class="text-muted">
                                <h5 class="mb-1" id="dash_topo_titulo"></h5>
                            </div>
                        </div>
                        <div class="ms-auto dropdown">
                            <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown">
                                <i class="bx bxs-cog align-middle me-1"></i> {{ __('Dashboards') }}
                            </button>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#" onclick="dashTopo(1)">Sistema</a>
                                <a class="dropdown-item" href="#" onclick="dashTopo(2)">Efetivo</a>
                                <a class="dropdown-item" href="#" onclick="dashTopo(3)">Ressarcimento</a>
                            </div>
                        </div>
                    </div>

                    <!-- Sistema -->
                    <div style="display: none;" id="dashboard_sistema">
                        <div class="row">
                            <div class="col-12 col-sm-8">
                                <div class="alert alert-primary">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="d-flex">
                                                <div class="me-3">
                                                    <i class="bx bx-user font-size-24"></i>
                                                </div>
                                                <div class="me-3">
                                                    <p class="text-muted mb-2">Usuários</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-10 align-self-center">
                                            <div class="text-lg-center mt-4 mt-lg-0">
                                                <div class="row justify-content-between text-center">

                                                    <div class="col">
                                                        <p class="text-muted text-truncate mb-2">Total</p>
                                                        <h5 class="mb-0" id="dashboard_sistema_usuarios_total_geral">0</h5>
                                                    </div>

                                                    <div class="col">
                                                        <p class="text-muted text-truncate mb-2">Militares</p>
                                                        <h5 class="mb-0" id="dashboard_sistema_usuarios_total_militares">0</h5>
                                                    </div>

                                                    <div class="col">
                                                        <p class="text-muted text-truncate mb-2">Civis</p>
                                                        <h5 class="mb-0" id="dashboard_sistema_usuarios_total_civis">0</h5>
                                                    </div>

                                                    <div class="col">
                                                        <p class="text-muted text-truncate mb-2">Liberados</p>
                                                        <h5 class="mb-0" id="dashboard_sistema_usuarios_total_liberados">0</h5>
                                                    </div>

                                                    <div class="col">
                                                        <p class="text-muted text-truncate mb-2">Bloqueados</p>
                                                        <h5 class="mb-0" id="dashboard_sistema_usuarios_total_bloqueados">0</h5>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-2">
                                <div class="border rounded alert alert-success">
                                    <div class="d-flex flex-wrap">
                                        <div class="me-3">
                                            <p class="text-muted mb-2">Grupos</p>
                                            <h5 class="mb-0" id="dashboard_sistema_grupos_total_geral">0</h5>
                                        </div>
                                        <div class="ms-auto">
                                            <div class="avatar-sm rounded-circle bg-success">
                                                <span class="avatar-title rounded-circle">
                                                    <i class="bx bx-group font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-2">
                                <div class="border rounded alert alert-danger">
                                    <div class="d-flex flex-wrap">
                                        <div class="me-3">
                                            <p class="text-muted mb-2">Transações</p>
                                            <h5 class="mb-0" id="dashboard_sistema_transacoes_total_geral">0</h5>
                                        </div>
                                        <div class="ms-auto">
                                            <div class="avatar-sm rounded-circle bg-danger">
                                                <span class="avatar-title rounded-circle">
                                                    <i class="bx bx-transfer font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gráficos -->
                        <div class="row">
                            <div class="col-12 col-sm-4 mb-3" id="container_grafico_1">
                                <div class="border rounded" style="height: 400px;" id="div_grafico_1"></div>
                            </div>
                            <div class="col-12 col-sm-4 mb-3" id="container_grafico_2">
                                <div class="border rounded" style="height: 400px;" id="div_grafico_2"></div>
                            </div>
                            <div class="col-12 col-sm-4 mb-3" id="container_grafico_3">
                                <div class="border rounded" style="height: 400px;" id="div_grafico_3"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Efetivo -->
                    <div style="display: none;" id="dashboard_efetivo">
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="alert alert-primary">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="d-flex">
                                                <div class="me-3">
                                                    <i class="fa fa-users font-size-24"></i>
                                                </div>
                                                <div class="me-3">
                                                    <p class="text-muted mb-2">Militares</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-10 align-self-center">
                                            <div class="text-lg-center mt-4 mt-lg-0">
                                                <div class="row justify-content-between text-center">
                                                    <div class="col">
                                                        <p class="text-muted text-truncate mb-2">Ativos</p>
                                                        <h5 class="mb-0" id="dashboard_efetivo_militares_total_ativos">0</h5>
                                                    </div>

                                                    <div class="col">
                                                        <p class="text-muted text-truncate mb-2">Oficiais Ativos</p>
                                                        <h5 class="mb-0" id="dashboard_sistema_militares_total_oficiais_ativos">0</h5>
                                                    </div>

                                                    <div class="col">
                                                        <p class="text-muted text-truncate mb-2">Aspirantes</p>
                                                        <h5 class="mb-0" id="dashboard_sistema_militares_total_aspirantes">0</h5>
                                                    </div>

                                                    <div class="col">
                                                        <p class="text-muted text-truncate mb-2">Alunos CFO</p>
                                                        <h5 class="mb-0" id="dashboard_sistema_militares_total_alunos_cfo">0</h5>
                                                    </div>

                                                    <div class="col">
                                                        <p class="text-muted text-truncate mb-2">Praças Ativos</p>
                                                        <h5 class="mb-0" id="dashboard_sistema_militares_total_pracas_ativos">0</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gráficos -->
                        <div class="row">
                            <div class="col-12 col-sm-4 mb-3" id="container_grafico_4">
                                <div class="border rounded" style="height: 400px;" id="div_grafico_4"></div>
                            </div>
                            <div class="col-12 col-sm-4 mb-3" id="container_grafico_5">
                                <div class="border rounded" style="height: 400px;" id="div_grafico_5"></div>
                            </div>
                            <div class="col-12 col-sm-4 mb-3" id="container_grafico_6">
                                <div class="border rounded" style="height: 400px;" id="div_grafico_6"></div>
                            </div>
                            <div class="col-12 col-sm-4 mb-3" id="container_grafico_7">
                                <div class="border rounded" style="height: 400px;" id="div_grafico_7"></div>
                            </div>
                        </div>

                        <!-- Modal div_grafico_5 -->
                        <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true" id="modal_grafico_5">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Quadros</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modal_grafico_5_fechar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-success p-0 p-2 d-flex justify-content-center align-items-center gap-4 flex-wrap">
                                            <div class="form-check font-size-12">
                                                <input class="form-check-input" type="radio" name="modal_grafico_5_militares" id="modal_grafico_5_militares_todos" value="2" checked>
                                                <label class="form-check-label" for="modal_grafico_5_militares_todos">Efetivo</label>
                                            </div>
                                            <div class="form-check font-size-12">
                                                <input class="form-check-input" type="radio" name="modal_grafico_5_militares" id="modal_grafico_5_militares_oficiais" value="3">
                                                <label class="form-check-label" for="modal_grafico_5_militares_oficiais">Oficiais</label>
                                            </div>
                                            <div class="form-check font-size-12">
                                                <input class="form-check-input" type="radio" name="modal_grafico_5_militares" id="modal_grafico_5_militares_pracas" value="6">
                                                <label class="form-check-label" for="modal_grafico_5_militares_pracas">Praças</label>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-4 flex-wrap mb-3">
                                            <div class="col ps-0 font-size-10">
                                                <!-- <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_1" id="modal_grafico_5_quadro_1" value="1">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_1">EFQ</label>
                                                </div> -->
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_2" id="modal_grafico_5_quadro_2" value="2" checked>
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_2">Q00 - {{ primeiraMaiuscula('COMBATENTE') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_3" id="modal_grafico_5_quadro_3" value="3" checked>
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_3">Q01 - {{ primeiraMaiuscula('BUSCA E SALVAMENTO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_4" id="modal_grafico_5_quadro_4" value="4" checked>
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_4">Q02 - {{ primeiraMaiuscula('CONDUTOR E OPERADOR DE VIATURAS') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_5" id="modal_grafico_5_quadro_5" value="5" checked>
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_5">Q03 - {{ primeiraMaiuscula('ARTÍFICE E MOTOMECANIZAÇÃO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_6" id="modal_grafico_5_quadro_6" value="6" checked>
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_6">Q04 - {{ primeiraMaiuscula('MÚSICO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_7" id="modal_grafico_5_quadro_7" value="7" checked>
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_7">Q05 - {{ primeiraMaiuscula('COMUNICANTE') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_8" id="modal_grafico_5_quadro_8" value="8" checked>
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_8">Q06 - {{ primeiraMaiuscula('AUXILIAR DE CONSULTÓRIO DENTÁRIO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_9" id="modal_grafico_5_quadro_9" value="9" checked>
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_9">Q06 - {{ primeiraMaiuscula('AUXILIAR DE ENFERMAGEM') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_31" id="modal_grafico_5_quadro_31" value="31" checked>
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_31">Q06/TRX - {{ primeiraMaiuscula('TÉCNICO DE RADIOLOGIA') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_10" id="modal_grafico_5_quadro_10" value="10" checked>
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_10">Q07 - {{ primeiraMaiuscula('CORNETEIRO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_11" id="modal_grafico_5_quadro_11" value="11" checked>
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_11">Q08 - {{ primeiraMaiuscula('MARÍTIMO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_12" id="modal_grafico_5_quadro_12" value="12" checked>
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_12">Q09 - {{ primeiraMaiuscula('OPERADOR DE HIDRANTE') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_13" id="modal_grafico_5_quadro_13" value="13" checked>
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_13">Q10 - {{ primeiraMaiuscula('GUARDA-VIDAS') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_14" id="modal_grafico_5_quadro_14" value="14" checked>
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_14">Q11 - {{ primeiraMaiuscula('TÉCNICO EM EMERGÊNCIAS MÉDICAS') }}</label>
                                                </div>
                                            </div>
                                            <div class="col font-size-10">
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_15" id="modal_grafico_5_quadro_15" value="15" checked>
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_15">QOA - {{ primeiraMaiuscula('OFICIAL ADMINISTRATIVO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_16" id="modal_grafico_5_quadro_16" value="16" checked>
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_16">QOC - {{ primeiraMaiuscula('OFICIAL COMBATENTE') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_17" id="modal_grafico_5_quadro_17" value="17">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_17">QOC - {{ primeiraMaiuscula('CAPELÃO') }}</label>
                                                </div>
                                                <!-- <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_18" id="modal_grafico_5_quadro_18" value="18">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_18">QOE</label>
                                                </div> -->
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_19" id="modal_grafico_5_quadro_19" value="19">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_19">QOE - {{ primeiraMaiuscula('COMUNICAÇÃO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_20" id="modal_grafico_5_quadro_20" value="20">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_20">QOE - {{ primeiraMaiuscula('MÚSICO') }}</label>
                                                </div>
                                                <!-- <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_21" id="modal_grafico_5_quadro_21" value="21">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_21">QOS</label>
                                                </div> -->
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_22" id="modal_grafico_5_quadro_22" value="22">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_22">QOS - {{ primeiraMaiuscula('ASSISTENTE SOCIAL') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_23" id="modal_grafico_5_quadro_23" value="23">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_23">QOS - {{ primeiraMaiuscula('DENTISTA') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_24" id="modal_grafico_5_quadro_24" value="24">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_24">QOS - {{ primeiraMaiuscula('ENFERMAGEM') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_25" id="modal_grafico_5_quadro_25" value="25">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_25">QOS - {{ primeiraMaiuscula('FARMACÊUTICO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_26" id="modal_grafico_5_quadro_26" value="26">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_26">QOS - {{ primeiraMaiuscula('FISIOTERAPEUTA') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_27" id="modal_grafico_5_quadro_27" value="27">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_27">QOS - {{ primeiraMaiuscula('FONOAUDIÓLOGO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_28" id="modal_grafico_5_quadro_28" value="28">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_28">QOS - {{ primeiraMaiuscula('MÉDICO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_29" id="modal_grafico_5_quadro_29" value="29">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_29">QOS - {{ primeiraMaiuscula('NUTRICIONISTA') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_30" id="modal_grafico_5_quadro_30" value="30">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_30">QOS - {{ primeiraMaiuscula('PSICÓLOGO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_32" id="modal_grafico_5_quadro_32" value="32">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_32">QAL - {{ primeiraMaiuscula('ALUNO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_33" id="modal_grafico_5_quadro_33" value="33">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_33">QFC/AASS - {{ primeiraMaiuscula('AUXÍLIAR ADM. SERV. SAÚDE') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_34" id="modal_grafico_5_quadro_34" value="34">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_34">QFC/AE - {{ primeiraMaiuscula('AUXÍLIAR DE ENFERMAGEM') }}</label>
                                                </div>
                                                <!-- <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_35" id="modal_grafico_5_quadro_35" value="35">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_35">C - {{ primeiraMaiuscula('CIVIL') }}</label>
                                                </div> -->
                                            </div>
                                            <div class="col pe-0 font-size-10">
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_36" id="modal_grafico_5_quadro_36" value="36">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_36">TEMP/00 - {{ primeiraMaiuscula('TEMPORARIO COMBATENTE') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_37" id="modal_grafico_5_quadro_37" value="37">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_37">TEMP/10 - {{ primeiraMaiuscula('TEMPORÁRIO GUARDA-VIDAS') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_38" id="modal_grafico_5_quadro_38" value="38">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_38">TEMP/06 - {{ primeiraMaiuscula('TEMPORARIO TECNICO DE ENFERMEGEM') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_39" id="modal_grafico_5_quadro_39" value="39">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_39">TEMP/Med - {{ primeiraMaiuscula('OFICIAL TEMPORARIO MEDICO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_40" id="modal_grafico_5_quadro_40" value="40">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_40">TEMP/AsS - {{ primeiraMaiuscula('OFICIAL TEMPORARIO ASSISTENTE SOCIAL') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_41" id="modal_grafico_5_quadro_41" value="41">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_41">TEMP/Fis - {{ primeiraMaiuscula('OFICIAL TEMPORARIO FISIOTERAPEUTA') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_42" id="modal_grafico_5_quadro_42" value="42">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_42">TEMP/Enf - {{ primeiraMaiuscula('OFICIAL TEMPORARIO ENFERMEIRO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_43" id="modal_grafico_5_quadro_43" value="43">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_43">TEMP/FON - {{ primeiraMaiuscula('OFICIAL TEMPORARIO FONOAUDIOLOGO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_44" id="modal_grafico_5_quadro_44" value="44">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_44">TEMP/NUT - {{ primeiraMaiuscula('OFICIAL TEMPORARIO NUTRICIONISTA') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_5_quadro_45" id="modal_grafico_5_quadro_45" value="45">
                                                    <label class="form-check-label" for="modal_grafico_5_quadro_45">TEMP/PSI - {{ primeiraMaiuscula('OFICIAL TEMPORARIO PSICOLOGO') }}</label>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-sm btn-success col-12" onclick="dashboardEfetivoGrafico2();">Atualizar Gráfico</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal div_grafico_6 -->
                        <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true" id="modal_grafico_6">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Graduações</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modal_grafico_6_fechar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-success p-0 p-2 d-flex justify-content-center align-items-center gap-4 flex-wrap">
                                            <div class="form-check font-size-12">
                                                <input class="form-check-input" type="radio" name="modal_grafico_6_militares" id="modal_grafico_6_militares_todos" value="2" checked>
                                                <label class="form-check-label" for="modal_grafico_6_militares_todos">Efetivo</label>
                                            </div>
                                            <div class="form-check font-size-12">
                                                <input class="form-check-input" type="radio" name="modal_grafico_6_militares" id="modal_grafico_6_militares_oficiais" value="3">
                                                <label class="form-check-label" for="modal_grafico_6_militares_oficiais">Oficiais</label>
                                            </div>
                                            <div class="form-check font-size-12">
                                                <input class="form-check-input" type="radio" name="modal_grafico_6_militares" id="modal_grafico_6_militares_pracas" value="6">
                                                <label class="form-check-label" for="modal_grafico_6_militares_pracas">Praças</label>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-4 flex-wrap mb-3">
                                            <div class="col ps-0 font-size-10">
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_6_graduacao_2" id="modal_grafico_6_graduacao_2" value="2" checked>
                                                    <label class="form-check-label" for="modal_grafico_6_graduacao_2">{{ primeiraMaiuscula('CORONEL') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_6_graduacao_3" id="modal_grafico_6_graduacao_3" value="3" checked>
                                                    <label class="form-check-label" for="modal_grafico_6_graduacao_3">{{ primeiraMaiuscula('TENENTE CORONEL') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_6_graduacao_4" id="modal_grafico_6_graduacao_4" value="4" checked>
                                                    <label class="form-check-label" for="modal_grafico_6_graduacao_4">{{ primeiraMaiuscula('MAJOR') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_6_graduacao_5" id="modal_grafico_6_graduacao_5" value="5" checked>
                                                    <label class="form-check-label" for="modal_grafico_6_graduacao_5">{{ primeiraMaiuscula('CAPITÃO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_6_graduacao_6" id="modal_grafico_6_graduacao_6" value="6" checked>
                                                    <label class="form-check-label" for="modal_grafico_6_graduacao_6">{{ primeiraMaiuscula('1º TENENTE') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_6_graduacao_7" id="modal_grafico_6_graduacao_7" value="7" checked>
                                                    <label class="form-check-label" for="modal_grafico_6_graduacao_7">{{ primeiraMaiuscula('2º TENENTE') }}</label>
                                                </div>
                                            </div>
                                            <div class="col font-size-10">
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_6_graduacao_8" id="modal_grafico_6_graduacao_8" value="8">
                                                    <label class="form-check-label" for="modal_grafico_6_graduacao_8">{{ primeiraMaiuscula('ASPIRANTE') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_6_graduacao_9" id="modal_grafico_6_graduacao_9" value="9">
                                                    <label class="form-check-label" for="modal_grafico_6_graduacao_9">{{ primeiraMaiuscula('CADETE DO 3º ANO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_6_graduacao_10" id="modal_grafico_6_graduacao_10" value="10">
                                                    <label class="form-check-label" for="modal_grafico_6_graduacao_10">{{ primeiraMaiuscula('CADETE DO 2º ANO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_6_graduacao_11" id="modal_grafico_6_graduacao_11" value="11">
                                                    <label class="form-check-label" for="modal_grafico_6_graduacao_11">{{ primeiraMaiuscula('CADETE DO 1º ANO') }}</label>
                                                </div>
                                            </div>
                                            <div class="col pe-0 font-size-10">
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_6_graduacao_12" id="modal_grafico_6_graduacao_12" value="12" checked>
                                                    <label class="form-check-label" for="modal_grafico_6_graduacao_12">{{ primeiraMaiuscula('SUBTENENTE') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_6_graduacao_13" id="modal_grafico_6_graduacao_13" value="13" checked>
                                                    <label class="form-check-label" for="modal_grafico_6_graduacao_13">{{ primeiraMaiuscula('1º SARGENTO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_6_graduacao_14" id="modal_grafico_6_graduacao_14" value="14" checked>
                                                    <label class="form-check-label" for="modal_grafico_6_graduacao_14">{{ primeiraMaiuscula('2º SARGENTO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_6_graduacao_15" id="modal_grafico_6_graduacao_15" value="15" checked>
                                                    <label class="form-check-label" for="modal_grafico_6_graduacao_15">{{ primeiraMaiuscula('3º SARGENTO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_6_graduacao_16" id="modal_grafico_6_graduacao_16" value="16" checked>
                                                    <label class="form-check-label" for="modal_grafico_6_graduacao_16">{{ primeiraMaiuscula('CABO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_6_graduacao_17" id="modal_grafico_6_graduacao_17" value="17" checked>
                                                    <label class="form-check-label" for="modal_grafico_6_graduacao_17">{{ primeiraMaiuscula('SOLDADO') }}</label>
                                                </div>
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_grafico_6_graduacao_18" id="modal_grafico_6_graduacao_18" value="18" checked>
                                                    <label class="form-check-label" for="modal_grafico_6_graduacao_18">{{ primeiraMaiuscula('SOLDADO RECRUTA') }}</label>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-sm btn-success col-12" onclick="dashboardEfetivoGrafico3();">Atualizar Gráfico</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ressarcimento -->
                    <div style="display: none;" id="dashboard_ressarcimento">
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="alert alert-primary">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <div class="d-flex">
                                                <div class="me-3">
                                                    <i class="fa fa-users font-size-24"></i>
                                                </div>
                                                <div class="me-3">
                                                    <p class="text-muted mb-2">Ressarcimentos</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-10 align-self-center">
                                            <div class="text-lg-center mt-4 mt-lg-0">
                                                <div class="row justify-content-between text-center">
                                                    <div class="col">
                                                        <p class="text-muted text-truncate mb-2">Ressarcimentos</p>
                                                        <h5 class="mb-0" id="dashboard_ressarcimento_ressarcimentos_total">0</h5>
                                                    </div>

                                                    <div class="col">
                                                        <p class="text-muted text-truncate mb-2">Órgãos</p>
                                                        <h5 class="mb-0" id="dashboard_ressarcimento_orgaos_total">0</h5>
                                                    </div>

                                                    <div class="col">
                                                        <p class="text-muted text-truncate mb-2">Militares</p>
                                                        <h5 class="mb-0" id="dashboard_ressarcimento_militares_total">0</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gráficos -->
                        <div class="row">
                            <div class="col-12 col-sm-4 mb-3" id="container_grafico_8">
                                <div class="border rounded" style="height: 400px;" id="div_grafico_8"></div>
                            </div>
                            <div class="col-12 col-sm-4 mb-3" id="container_grafico_9">
                                <div class="border rounded" style="height: 400px;" id="div_grafico_9"></div>
                            </div>
                            <div class="col-12 col-sm-4 mb-3" id="container_grafico_10">
                                <div class="border rounded" style="height: 400px;" id="div_grafico_10"></div>
                            </div>
                            <div class="col-12 col-sm-4 mb-3" id="container_grafico_11">
                                <div class="border rounded" style="height: 400px;" id="div_grafico_11"></div>
                            </div>
                            <div class="col-12 col-sm-4 mb-3" id="container_grafico_12">
                                <div class="border rounded" style="height: 400px;" id="div_grafico_12"></div>
                            </div>
                        </div>

                        <!-- Modal div_grafico_8 -->
                        <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true" id="modal_grafico_8">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ primeiraMaiuscula('QUANTIDADE DE MILITARES: OFICIAIS/PRAÇAS') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modal_grafico_8_fechar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-12 pb-3">
                                                <label class="form-label font-size-12">Período 1</label>
                                                <select class="form-select font-size-12" name="modal_grafico_8_periodo_1" id="modal_grafico_8_periodo_1">
                                                    @foreach ($ressarcimento_referencias as $ressarcimento_referencia)
                                                    <option value="{{ $ressarcimento_referencia['referencia'] }}">{{ getReferencia(1, $ressarcimento_referencia['referencia']) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-12 pb-3">
                                                <label class="form-label font-size-12">Período 2</label>
                                                <select class="form-select font-size-12" name="modal_grafico_8_periodo_2" id="modal_grafico_8_periodo_2">
                                                    @foreach ($ressarcimento_referencias as $ressarcimento_referencia)
                                                    <option value="{{ $ressarcimento_referencia['referencia'] }}">{{ getReferencia(1, $ressarcimento_referencia['referencia']) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-12 pb-3">
                                                <label class="form-label font-size-12">Órgão(s)</label>
                                                <select class="form-select font-size-12" name="modal_grafico_8_orgao_id" id="modal_grafico_8_orgao_id">
                                                    <option value="0">Todos os Órgãos</option>

                                                    @foreach ($ressarcimento_orgaos as $ressarcimento_orgao)
                                                    <option value="{{ $ressarcimento_orgao['id'] }}">{{ $ressarcimento_orgao['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-sm btn-success col-12" onclick="dashboardEfetivoGrafico8();">Atualizar Gráfico</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal div_grafico_9 -->
                        <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true" id="modal_grafico_9">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ primeiraMaiuscula('VALORES DEVIDOS E PAGOS PELOS ÓRGÃOS') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modal_grafico_9_fechar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-12 pb-3">
                                                <label class="form-label font-size-12">Período 1</label>
                                                <select class="form-select font-size-12" name="modal_grafico_9_periodo_1" id="modal_grafico_9_periodo_1">
                                                    @foreach ($ressarcimento_referencias as $ressarcimento_referencia)
                                                    <option value="{{ $ressarcimento_referencia['referencia'] }}">{{ getReferencia(1, $ressarcimento_referencia['referencia']) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-12 pb-3">
                                                <label class="form-label font-size-12">Período 2</label>
                                                <select class="form-select font-size-12" name="modal_grafico_9_periodo_2" id="modal_grafico_9_periodo_2">
                                                    @foreach ($ressarcimento_referencias as $ressarcimento_referencia)
                                                    <option value="{{ $ressarcimento_referencia['referencia'] }}">{{ getReferencia(1, $ressarcimento_referencia['referencia']) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-12 pb-3">
                                                <label class="form-label font-size-12">Órgão(s)</label>
                                                <select class="form-select font-size-12" name="modal_grafico_9_orgao_id" id="modal_grafico_9_orgao_id">
                                                    <option value="0">Todos os Órgãos</option>

                                                    @foreach ($ressarcimento_orgaos as $ressarcimento_orgao)
                                                    <option value="{{ $ressarcimento_orgao['id'] }}">{{ $ressarcimento_orgao['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-sm btn-success col-12" onclick="dashboardEfetivoGrafico8();">Atualizar Gráfico</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal div_grafico_10 -->
                        <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true" id="modal_grafico_10">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ primeiraMaiuscula('NÚMERO DE ÓRGÃOS POR ESFERA') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modal_grafico_10_fechar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-12 pb-3">
                                                <label class="form-label font-size-12">Período 1</label>
                                                <select class="form-select font-size-12" name="modal_grafico_10_periodo_1" id="modal_grafico_10_periodo_1">
                                                    @foreach ($ressarcimento_referencias as $ressarcimento_referencia)
                                                    <option value="{{ $ressarcimento_referencia['referencia'] }}">{{ getReferencia(1, $ressarcimento_referencia['referencia']) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-12 pb-3">
                                                <label class="form-label font-size-12">Período 2</label>
                                                <select class="form-select font-size-12" name="modal_grafico_10_periodo_2" id="modal_grafico_10_periodo_2">
                                                    @foreach ($ressarcimento_referencias as $ressarcimento_referencia)
                                                    <option value="{{ $ressarcimento_referencia['referencia'] }}">{{ getReferencia(1, $ressarcimento_referencia['referencia']) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-12 pb-3">
                                                <label class="form-label font-size-12">Órgão(s)</label>
                                                <select class="form-select font-size-12" name="modal_grafico_10_orgao_id" id="modal_grafico_10_orgao_id">
                                                    <option value="0">Todos os Órgãos</option>

                                                    @foreach ($ressarcimento_orgaos as $ressarcimento_orgao)
                                                    <option value="{{ $ressarcimento_orgao['id'] }}">{{ $ressarcimento_orgao['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-sm btn-success col-12" onclick="dashboardEfetivoGrafico8();">Atualizar Gráfico</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal div_grafico_11 -->
                        <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true" id="modal_grafico_11">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ primeiraMaiuscula('NÚMERO DE ÓRGÃOS POR PODER') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modal_grafico_11_fechar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-12 pb-3">
                                                <label class="form-label font-size-12">Período 1</label>
                                                <select class="form-select font-size-12" name="modal_grafico_11_periodo_1" id="modal_grafico_11_periodo_1">
                                                    @foreach ($ressarcimento_referencias as $ressarcimento_referencia)
                                                    <option value="{{ $ressarcimento_referencia['referencia'] }}">{{ getReferencia(1, $ressarcimento_referencia['referencia']) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-12 pb-3">
                                                <label class="form-label font-size-12">Período 2</label>
                                                <select class="form-select font-size-12" name="modal_grafico_11_periodo_2" id="modal_grafico_11_periodo_2">
                                                    @foreach ($ressarcimento_referencias as $ressarcimento_referencia)
                                                    <option value="{{ $ressarcimento_referencia['referencia'] }}">{{ getReferencia(1, $ressarcimento_referencia['referencia']) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-12 pb-3">
                                                <label class="form-label font-size-12">Órgão(s)</label>
                                                <select class="form-select font-size-12" name="modal_grafico_11_orgao_id" id="modal_grafico_11_orgao_id">
                                                    <option value="0">Todos os Órgãos</option>

                                                    @foreach ($ressarcimento_orgaos as $ressarcimento_orgao)
                                                    <option value="{{ $ressarcimento_orgao['id'] }}">{{ $ressarcimento_orgao['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-sm btn-success col-12" onclick="dashboardEfetivoGrafico8();">Atualizar Gráfico</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal div_grafico_12 -->
                        <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true" id="modal_grafico_12">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ primeiraMaiuscula('VALORES DEVIDOS E PAGOS POR ÓRGÃOS MENSALMENTE') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modal_grafico_12_fechar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-12 pb-3">
                                                <label class="form-label font-size-12">Período 1</label>
                                                <select class="form-select font-size-12" name="modal_grafico_12_periodo_1" id="modal_grafico_12_periodo_1">
                                                    @foreach ($ressarcimento_referencias as $ressarcimento_referencia)
                                                    <option value="{{ $ressarcimento_referencia['referencia'] }}">{{ getReferencia(1, $ressarcimento_referencia['referencia']) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-12 pb-3">
                                                <label class="form-label font-size-12">Período 2</label>
                                                <select class="form-select font-size-12" name="modal_grafico_12_periodo_2" id="modal_grafico_12_periodo_2">
                                                    @foreach ($ressarcimento_referencias as $ressarcimento_referencia)
                                                    <option value="{{ $ressarcimento_referencia['referencia'] }}">{{ getReferencia(1, $ressarcimento_referencia['referencia']) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-12 pb-3">
                                                <label class="form-label font-size-12">Órgão(s)</label>
                                                <select class="form-select font-size-12" name="modal_grafico_12_orgao_id" id="modal_grafico_12_orgao_id">
                                                    <option value="0">Todos os Órgãos</option>

                                                    @foreach ($ressarcimento_orgaos as $ressarcimento_orgao)
                                                    <option value="{{ $ressarcimento_orgao['id'] }}">{{ $ressarcimento_orgao['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-sm btn-success col-12" onclick="dashboardEfetivoGrafico8();">Atualizar Gráfico</button>
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

@endsection

@section('script')
<!-- E-Charts -->
<script src="https://cdn.jsdelivr.net/npm/echarts@6/dist/echarts.min.js"></script>

<!-- scripts_dashboards.js -->
<script src="{{ asset('assets/js/scripts_dashboards.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
