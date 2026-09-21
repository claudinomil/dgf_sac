@extends('layouts.master')

@section('title')
{{ __('Relatórios') }}
@endsection

@section('topbar_title')
{{ __('Relatórios') }}
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
                            <i class="bx bxs-report img-thumbnail font-size-24"></i>
                        </div>
                        <div class="me-3">
                            <div class="text-muted">
                                <h5 class="mb-1" id="dash_topo_titulo"></h5>
                            </div>
                        </div>
                        <div class="ms-auto dropdown">
                            <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown">
                                <i class="bx bxs-cog align-middle me-1"></i> {{ __('Relatórios') }}
                            </button>

                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#" onclick="dashTopo(1)">Sistema</a>
                                <a class="dropdown-item" href="#" onclick="dashTopo(2)">Efetivo</a>
                                <a class="dropdown-item" href="#" onclick="dashTopo(3)">Ressarcimento</a>
                            </div>
                        </div>
                    </div>

                    <!-- Sistema -->
                    <div style="display: none;" id="relatorios_sistema">&nbsp;</div>

                    <!-- Eftivo -->
                    <div style="display: none;" id="relatorios_efetivo">&nbsp;</div>

                    <!-- Ressarcimento -->
                    <div style="display: none;" id="relatorios_ressarcimento">&nbsp;</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Relatorio 1 -->
    <div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal_relatorio_1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-size-12" id="modal_relatorio_1_titulo">Xxxxxxxxxxxx</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-12 pb-3">
                        <label class="form-label font-size-12">Grupo</label>
                        <select class="form-select font-size-12" name="modal_relatorio_1_grupo_id" id="modal_relatorio_1_grupo_id">
                            <option value="0">Todos os Grupos</option>
                            @foreach ($grupos as $grupo)
                            <option value="{{$grupo['id']}}">{{$grupo['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12 text-end" id="modal_relatorio_1_footer_1">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modal_relatorio_1_cancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="relatoriosRelatorio1(2)">Gerar</button>
                    </div>
                    <div class="col-12 text-center" id="modal_relatorio_1_footer_2" style="display: none;">
                        <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Processando...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Relatorio 2 -->
    <div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal_relatorio_2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-size-12" id="modal_relatorio_2_titulo">Xxxxxxxxxxxx</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-12 pb-3">
                        <label class="form-label font-size-12">Grupo</label>
                        <select class="form-select font-size-12" name="modal_relatorio_2_grupo_id" id="modal_relatorio_2_grupo_id">
                            <option value="0">Todos os Grupos</option>
                            @foreach ($grupos as $grupo)
                            <option value="{{$grupo['id']}}">{{$grupo['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12 pb-3">
                        <label class="form-label font-size-12">Situação</label>
                        <select class="form-select font-size-12" name="modal_relatorio_2_user_situacao_id" id="modal_relatorio_2_user_situacao_id">
                            <option value="0">Todas as Situações</option>
                            @foreach ($user_situacoes as $user_situacao)
                            <option value="{{$user_situacao['id']}}">{{$user_situacao['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12 pb-3">
                        <label class="form-label font-size-12">Tipo</label>
                        <select class="form-select font-size-12" name="modal_relatorio_2_user_tipo_id" id="modal_relatorio_2_user_tipo_id">
                            <option value="0">Todos os Tipos</option>
                            @foreach ($user_tipos as $user_tipo)
                            <option value="{{$user_tipo['id']}}">{{$user_tipo['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12 text-end" id="modal_relatorio_2_footer_1">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modal_relatorio_2_cancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="relatoriosRelatorio2(2)">Gerar</button>
                    </div>
                    <div class="col-12 text-center" id="modal_relatorio_2_footer_2" style="display: none;">
                        <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Processando...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Relatorio 3 -->
    <div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal_relatorio_3">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-size-12" id="modal_relatorio_3_titulo">Xxxxxxxxxxxx</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-12 pb-3">
                        <label class="form-label font-size-12">Data</label>
                        <input type="text" class="form-control form-control-sm mask_date font-size-12" name="modal_relatorio_3_data" id="modal_relatorio_3_data">
                    </div>
                    <div class="form-group col-12 pb-3">
                        <label class="form-label font-size-12">Usuário</label>
                        <select class="form-select font-size-12" name="modal_relatorio_3_user_id" id="modal_relatorio_3_user_id">
                            <option value="0">Todos os Usuários</option>
                            @foreach ($users as $user)
                            <option value="{{$user['id']}}">{{$user['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12 pb-3">
                        <label class="form-label font-size-12">Submódulo</label>
                        <select class="form-select font-size-12" name="modal_relatorio_3_submodulo_id" id="modal_relatorio_3_submodulo_id">
                            <option value="0">Todos os Submódulos</option>
                            @foreach ($submodulos as $submodulo)
                            <option value="{{$submodulo['id']}}">{{$submodulo['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12 pb-3">
                        <label class="form-label font-size-12">Operação</label>
                        <select class="form-select font-size-12" name="modal_relatorio_3_operacao_id" id="modal_relatorio_3_operacao_id">
                            <option value="0">Todos as Operações</option>
                            @foreach ($operacoes as $operacao)
                            <option value="{{$operacao['id']}}">{{$operacao['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12 pb-3">
                        <label class="form-label font-size-12">Dado</label>
                        <input type="text" class="form-control form-control-sm font-size-12" name="modal_relatorio_3_dado" id="modal_relatorio_3_dado">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12 text-end" id="modal_relatorio_3_footer_1">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modal_relatorio_3_cancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="relatoriosRelatorio3(2)">Gerar</button>
                    </div>
                    <div class="col-12 text-center" id="modal_relatorio_3_footer_2" style="display: none;">
                        <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Processando...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Relatorio 4 -->
    <div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal_relatorio_4">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-size-12" id="modal_relatorio_4_titulo">Xxxxxxxxxxxx</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-12 pb-3">
                        <label class="form-label font-size-12">Referência</label>
                        <select class="form-select font-size-12" name="modal_relatorio_4_referencia" id="modal_relatorio_4_referencia">
                            @foreach ($referencias as $referencia)
                            <option value="{{ $referencia['referencia'] }}">{{ getReferencia(1, $referencia['referencia']) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12 pb-3">
                        <label class="form-label font-size-12">Órgão</label>
                        <select class="form-select font-size-12" name="modal_relatorio_4_orgao_id" id="modal_relatorio_4_orgao_id">
                            <option value="0">Todos os Órgãos</option>
                            @foreach ($orgaos as $orgao)
                            <option value="{{ $orgao['id'] }}">{{ $orgao['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12 text-end" id="modal_relatorio_4_footer_1">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modal_relatorio_4_cancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="relatoriosRelatorio4(2)">Gerar</button>
                    </div>
                    <div class="col-12 text-center" id="modal_relatorio_4_footer_2" style="display: none;">
                        <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Processando...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Relatorio 5 -->
    <div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal_relatorio_5">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-size-12" id="modal_relatorio_5_titulo">Xxxxxxxxxxxx</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-12 pb-3">
                        <label class="form-label font-size-12">Referência</label>
                        <select class="form-select font-size-12" name="modal_relatorio_5_referencia" id="modal_relatorio_5_referencia">
                            @foreach ($referencias as $referencia)
                            <option value="{{ $referencia['referencia'] }}">{{ getReferencia(1, $referencia['referencia']) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12 pb-3">
                        <label class="form-label font-size-12">Órgão</label>
                        <select class="form-select font-size-12" name="modal_relatorio_5_orgao_id" id="modal_relatorio_5_orgao_id">
                            <option value="0">Todos os Órgãos</option>
                            @foreach ($orgaos as $orgao)
                            <option value="{{ $orgao['id'] }}">{{ $orgao['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12 text-end" id="modal_relatorio_5_footer_1">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modal_relatorio_5_cancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="relatoriosRelatorio5(2)">Gerar</button>
                    </div>
                    <div class="col-12 text-center" id="modal_relatorio_5_footer_2" style="display: none;">
                        <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Processando...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Relatorio 6 -->
    <div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal_relatorio_6">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-size-12" id="modal_relatorio_6_titulo">Xxxxxxxxxxxx</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-12 pb-3">
                        <label class="form-label font-size-12">Referência</label>
                        <select class="form-select font-size-12" name="modal_relatorio_6_referencia" id="modal_relatorio_6_referencia">
                            @foreach ($referencias as $referencia)
                            <option value="{{ $referencia['referencia'] }}">{{ getReferencia(1, $referencia['referencia']) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12 pb-3">
                        <label class="form-label font-size-12">Órgão</label>
                        <select class="form-select font-size-12" name="modal_relatorio_6_orgao_id" id="modal_relatorio_6_orgao_id">
                            <option value="0">Todos os Órgãos</option>
                            @foreach ($orgaos as $orgao)
                            <option value="{{ $orgao['id'] }}">{{ $orgao['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-12 pb-3">
                        <label class="form-label font-size-12">Saldo</label>
                        <select class="form-select font-size-12" name="modal_relatorio_6_saldo" id="modal_relatorio_6_saldo">
                            <option value="0">Qualquer Saldo</option>
                            <option value="1">Saldo igual a 0(zero)</option>
                            <option value="2">Saldo menor que 0(zero)</option>
                            <option value="3">Saldo maior que 0(zero)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12 text-end" id="modal_relatorio_6_footer_1">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modal_relatorio_6_cancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="relatoriosRelatorio6(2)">Gerar</button>
                    </div>
                    <div class="col-12 text-center" id="modal_relatorio_6_footer_2" style="display: none;">
                        <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Processando...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Relatorio 7 -->
    <div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal_relatorio_7">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-size-12" id="modal_relatorio_7_titulo">Xxxxxxxxxxxx</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">&nbsp;</div>
                <div class="modal-footer">
                    <div class="col-12 text-end" id="modal_relatorio_7_footer_1">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modal_relatorio_7_cancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="relatoriosRelatorio7(2)">Gerar</button>
                    </div>
                    <div class="col-12 text-center" id="modal_relatorio_7_footer_2" style="display: none;">
                        <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Processando...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Relatorio 8 -->
    <div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal_relatorio_8">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-size-12" id="modal_relatorio_8_titulo">Xxxxxxxxxxxx</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">&nbsp;</div>
                <div class="modal-footer">
                    <div class="col-12 text-end" id="modal_relatorio_8_footer_1">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modal_relatorio_8_cancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="relatoriosRelatorio8(2)">Gerar</button>
                    </div>
                    <div class="col-12 text-center" id="modal_relatorio_8_footer_2" style="display: none;">
                        <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Processando...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Relatorio 9 -->
    <div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal_relatorio_9">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-size-12" id="modal_relatorio_9_titulo">Xxxxxxxxxxxx</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">&nbsp;</div>
                <div class="modal-footer">
                    <div class="col-12 text-end" id="modal_relatorio_9_footer_1">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modal_relatorio_9_cancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="relatoriosRelatorio9(2)">Gerar</button>
                    </div>
                    <div class="col-12 text-center" id="modal_relatorio_9_footer_2" style="display: none;">
                        <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Processando...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Relatorio 10 -->
    <div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal_relatorio_10">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-size-12" id="modal_relatorio_10_titulo">Xxxxxxxxxxxx</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">&nbsp;</div>
                <div class="modal-footer">
                    <div class="col-12 text-end" id="modal_relatorio_10_footer_1">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modal_relatorio_10_cancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="relatoriosRelatorio10(2)">Gerar</button>
                    </div>
                    <div class="col-12 text-center" id="modal_relatorio_10_footer_2" style="display: none;">
                        <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Processando...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Relatorio 11 -->
    <div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal_relatorio_11">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-size-12" id="modal_relatorio_11_titulo">Xxxxxxxxxxxx</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">&nbsp;</div>
                <div class="modal-footer">
                    <div class="col-12 text-end" id="modal_relatorio_11_footer_1">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modal_relatorio_11_cancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="relatoriosRelatorio11(2)">Gerar</button>
                    </div>
                    <div class="col-12 text-center" id="modal_relatorio_11_footer_2" style="display: none;">
                        <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Processando...
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Relatorio 12 -->
    <div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal_relatorio_12">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-size-12" id="modal_relatorio_12_titulo">Xxxxxxxxxxxx</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" name="frm_modal_relatorio_12" id="frm_modal_relatorio_12">
                        <div class="accordion accordion-flush" id="modal_relatorio_12_accordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="modal_relatorio_12_accordion_situacoes">
                                    <button class="accordion-button fw-medium font-size-10" type="button" data-bs-toggle="collapse" data-bs-target="#modal_relatorio_12_collapse_situacoes" aria-expanded="true" aria-controls="modal_relatorio_12_collapse_situacoes">
                                        <b>Situações</b>
                                    </button>
                                </h2>
                                <div id="modal_relatorio_12_collapse_situacoes" class="accordion-collapse collapse show" aria-labelledby="modal_relatorio_12_accordion_situacoes" data-bs-parent="#modal_relatorio_12_accordion">
                                    <div class="accordion-body text-muted p-0 px-3 py-2">
                                        <div class="row">
                                            <div class="col-12 pb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="modal_relatorio_12_situacoes_checkboxes_todos" name="modal_relatorio_12_situacoes_checkboxes_todos" onchange="relatorio12SituacoesCheckboxesAlterarTodos(this.checked);" checked>
                                                    <label class="form-check-label font-size-10" for="modal_relatorio_12_situacoes_checkboxes_todos"><b>Marcar / Desmarcar todos</b></label>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-12 flex-fill text-start font-size-11">
                                                <div class="form-check form-check-warning">
                                                    <input class="form-check-input" type="checkbox" name="modal_relatorio_12_situacoes_checkboxes" id="modal_relatorio_12_situacoes_checkboxes_null" value="null">
                                                    <label class="form-check-label" for="modal_relatorio_12_situacoes_checkboxes_null">Null</label>
                                                </div>
                                            </div>

                                            @foreach ($situacoes as $situacao)
                                            <div class="col-12 col-md-6 flex-fill text-start font-size-11">
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_relatorio_12_situacoes_checkboxes" id="modal_relatorio_12_situacoes_checkboxes_{{ $situacao['id'] }}" value="{{ $situacao['id'] }}">
                                                    <label class="form-check-label" for="modal_relatorio_12_situacoes_checkboxes_{{ $situacao['id'] }}">{{ primeiraMaiuscula($situacao['name']) }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="modal_relatorio_12_accordion_graduacoes">
                                    <button class="accordion-button fw-medium font-size-10 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#modal_relatorio_12_collapse_graduacoes" aria-expanded="false" aria-controls="modal_relatorio_12_collapse_graduacoes">
                                        <b>Graduações</b>
                                    </button>
                                </h2>
                                <div id="modal_relatorio_12_collapse_graduacoes" class="accordion-collapse collapse" aria-labelledby="modal_relatorio_12_accordion_graduacoes" data-bs-parent="#modal_relatorio_12_accordion">
                                    <div class="accordion-body text-muted p-0 px-3 py-2">
                                        <div class="row">
                                            <div class="col-12 pb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="modal_relatorio_12_graduacoes_checkboxes_todos" name="modal_relatorio_12_graduacoes_checkboxes_todos" onchange="relatorio12GraduacoesCheckboxesAlterarTodos(this.checked);" checked>
                                                    <label class="form-check-label font-size-10" for="modal_relatorio_12_graduacoes_checkboxes_todos"><b>Marcar / Desmarcar todos</b></label>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-12 flex-fill text-start font-size-11">
                                                <div class="form-check form-check-warning">
                                                    <input class="form-check-input" type="checkbox" name="modal_relatorio_12_graduacoes_checkboxes" id="modal_relatorio_12_graduacoes_checkboxes_null" value="null">
                                                    <label class="form-check-label" for="modal_relatorio_12_graduacoes_checkboxes_null">Null</label>
                                                </div>
                                            </div>

                                            @foreach ($graduacoes as $graduacao)
                                            <div class="col-12 col-md-6 flex-fill text-start font-size-11">
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_relatorio_12_graduacoes_checkboxes" id="modal_relatorio_12_graduacoes_checkboxes_{{ $graduacao['id'] }}" value="{{ $graduacao['id'] }}">
                                                    <label class="form-check-label" for="modal_relatorio_12_graduacoes_checkboxes_{{ $graduacao['id'] }}">{{ primeiraMaiuscula($graduacao['name']) }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="modal_relatorio_12_accordion_unidades">
                                    <button class="accordion-button fw-medium font-size-10 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#modal_relatorio_12_collapse_unidades" aria-expanded="false" aria-controls="modal_relatorio_12_collapse_unidades">
                                        <b>Unidades</b>
                                    </button>
                                </h2>
                                <div id="modal_relatorio_12_collapse_unidades" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#modal_relatorio_12_accordion">
                                    <div class="accordion-body text-muted p-0 px-3 py-2">
                                        <div class="row">
                                            <div class="col-12 pb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="modal_relatorio_12_unidades_checkboxes_todos" name="modal_relatorio_12_unidades_checkboxes_todos" onchange="relatorio12UnidadesCheckboxesAlterarTodos(this.checked);" checked>
                                                    <label class="form-check-label font-size-10" for="modal_relatorio_12_unidades_checkboxes_todos"><b>Marcar / Desmarcar todos</b></label>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-12 flex-fill text-start font-size-11">
                                                <div class="form-check form-check-warning">
                                                    <input class="form-check-input" type="checkbox" name="modal_relatorio_12_unidades_checkboxes" id="modal_relatorio_12_unidades_checkboxes_null" value="null">
                                                    <label class="form-check-label" for="modal_relatorio_12_unidades_checkboxes_null">Null</label>
                                                </div>
                                            </div>

                                            @foreach ($unidades as $unidade)
                                            <div class="col-12 col-md-6 flex-fill text-start font-size-11">
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_relatorio_12_unidades_checkboxes" id="modal_relatorio_12_unidades_checkboxes_{{ $unidade['id'] }}" value="{{ $unidade['id'] }}">
                                                    <label class="form-check-label" for="modal_relatorio_12_unidades_checkboxes_{{ $unidade['id'] }}">{{ primeiraMaiuscula($unidade['name']) }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="modal_relatorio_12_accordion_quadros">
                                    <button class="accordion-button fw-medium font-size-10 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#modal_relatorio_12_collapse_quadros" aria-expanded="false" aria-controls="modal_relatorio_12_collapse_quadros">
                                        <b>Quadros</b>
                                    </button>
                                </h2>
                                <div id="modal_relatorio_12_collapse_quadros" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#modal_relatorio_12_accordion">
                                    <div class="accordion-body text-muted p-0 px-3 py-2">
                                        <div class="row">
                                            <div class="col-12 pb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="modal_relatorio_12_quadros_checkboxes_todos" name="modal_relatorio_12_quadros_checkboxes_todos" onchange="relatorio12QuadrosCheckboxesAlterarTodos(this.checked);" checked>
                                                    <label class="form-check-label font-size-10" for="modal_relatorio_12_quadros_checkboxes_todos"><b>Marcar / Desmarcar todos</b></label>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-12 flex-fill text-start font-size-11">
                                                <div class="form-check form-check-warning">
                                                    <input class="form-check-input" type="checkbox" name="modal_relatorio_12_quadros_checkboxes" id="modal_relatorio_12_quadros_checkboxes_null" value="null">
                                                    <label class="form-check-label" for="modal_relatorio_12_quadros_checkboxes_null">Null</label>
                                                </div>
                                            </div>

                                            @foreach ($quadros as $quadro)
                                            <div class="col-12 col-md-6 flex-fill text-start font-size-11">
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_relatorio_12_quadros_checkboxes" id="modal_relatorio_12_quadros_checkboxes_{{ $quadro['id'] }}" value="{{ $quadro['id'] }}">
                                                    <label class="form-check-label" for="modal_relatorio_12_quadros_checkboxes_{{ $quadro['id'] }}">{{ primeiraMaiuscula($quadro['name']) }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="modal_relatorio_12_accordion_comportamentos">
                                    <button class="accordion-button fw-medium font-size-10 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#modal_relatorio_12_collapse_comportamentos" aria-expanded="false" aria-controls="modal_relatorio_12_collapse_comportamentos">
                                        <b>Comportamentos</b>
                                    </button>
                                </h2>
                                <div id="modal_relatorio_12_collapse_comportamentos" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#modal_relatorio_12_accordion">
                                    <div class="accordion-body text-muted p-0 px-3 py-2">
                                        <div class="row">
                                            <div class="col-12 pb-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="modal_relatorio_12_comportamentos_checkboxes_todos" name="modal_relatorio_12_comportamentos_checkboxes_todos" onchange="relatorio12ComportamentosCheckboxesAlterarTodos(this.checked);" checked>
                                                    <label class="form-check-label font-size-10" for="modal_relatorio_12_comportamentos_checkboxes_todos"><b>Marcar / Desmarcar todos</b></label>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-12 flex-fill text-start font-size-11">
                                                <div class="form-check form-check-warning">
                                                    <input class="form-check-input" type="checkbox" name="modal_relatorio_12_comportamentos_checkboxes" id="modal_relatorio_12_comportamentos_checkboxes_null" value="null">
                                                    <label class="form-check-label" for="modal_relatorio_12_comportamentos_checkboxes_null">Null</label>
                                                </div>
                                            </div>

                                            @foreach ($comportamentos as $comportamento)
                                            <div class="col-12 col-md-6 flex-fill text-start font-size-11">
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="checkbox" name="modal_relatorio_12_comportamentos_checkboxes" id="modal_relatorio_12_comportamentos_checkboxes_{{ $comportamento['id'] }}" value="{{ $comportamento['id'] }}">
                                                    <label class="form-check-label" for="modal_relatorio_12_comportamentos_checkboxes_{{ $comportamento['id'] }}">{{ primeiraMaiuscula($comportamento['name']) }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="modal_relatorio_12_accordion_campos">
                                    <button class="accordion-button fw-medium font-size-10 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#modal_relatorio_12_collapse_campos" aria-expanded="false" aria-controls="modal_relatorio_12_collapse_campos">
                                        <b>Campos</b>
                                    </button>
                                </h2>
                                <div id="modal_relatorio_12_collapse_campos" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#modal_relatorio_12_accordion">
                                    <div class="accordion-body text-muted p-0 px-3 py-2">
                                        <div class="row">
                                            <div class="form-group col-12 pb-3">
                                                <select class="form-select font-size-12" name="modal_relatorio_12_campos_colunas[]" id="modal_relatorio_12_campos_coluna_1">
                                                    <option value="">Selecione um Campo para Coluna 1</option>
                                                    <option value="rg">RG</option>
                                                    <option value="nome">Nome Militar</option>
                                                    <option value="situacaoName">Situação</option>
                                                    <option value="boletim_situacao">Boletim Situação</option>
                                                    <option value="graduacaoName">Graduação</option>
                                                    <option value="boletim_graduacao">Boletim Graduação</option>
                                                    <option value="unidadeName">Unidade</option>
                                                    <option value="boletim_movimentacao">Boletim Movimentação</option>
                                                    <option value="quadroName">Quadro</option>
                                                    <option value="boletim_quadro">Boletim Quadro</option>
                                                    <option value="sexoBiologicoName">Sexo Biológico</option>
                                                    <option value="generoName">Gênero</option>
                                                    <option value="data_ingresso">Data Ingresso</option>
                                                    <option value="boletim_ingresso">Boletim Ingresso</option>
                                                    <option value="nome_guerra">Nome Guerra</option>
                                                    <option value="prestandoServicoName">Prestando Serviço</option>
                                                    <option value="boletim_prestando_servico">Boletim Prestando Serviço</option>
                                                    <option value="funcaoName">Função</option>
                                                    <option value="boletim_funcao">Boletim Função</option>
                                                    <option value="bancoName">Banco</option>
                                                    <option value="agencia">Agência Bacária</option>
                                                    <option value="conta_corrente">Conta Corrente</option>
                                                    <option value="cpf">CPF</option>
                                                    <option value="pasep">PASEP</option>
                                                    <option value="pai">Pai</option>
                                                    <option value="estadoCivilName">Estado Civil</option>
                                                    <option value="mae">Mãe</option>
                                                    <option value="data_nascimento">Data Nascimento</option>
                                                    <option value="aniversario">Aniversário</option>
                                                    <option value="comportamentoName">Comportamento</option>
                                                    <option value="boletim_comportamento">Boletim Comportamento</option>
                                                    <option value="altura">Altura</option>
                                                    <option value="tipoSanguineoName">Tipo Sanguíneo</option>
                                                    <option value="fatorRhName">Fator RH</option>
                                                    <option value="titulo_eleitoral">Título Eleitoral</option>
                                                    <option value="titulo_eleitoral_zona">Título Eleitoral Zona</option>
                                                    <option value="titulo_eleitoral_secao">Título Eleitoral Seção</option>
                                                    <option value="titulo_eleitoral_uf">Título Eleitoral UF</option>
                                                    <option value="certificado_reservista">Certificado Reservista</option>
                                                    <option value="certificado_reservista_serie">Certificado Reservista Série</option>
                                                    <option value="certificado_reservista_categoria">Certificado Reservista Categoria</option>
                                                    <option value="identidade_funcional">Identidade Funcional</option>
                                                    <option value="vinculo">Vínculo</option>
                                                    <option value="temporario">Temporário</option>
                                                    <option value="nacionalidadeName">Nacionalidade</option>
                                                    <option value="naturalidadeName">Naturalidade</option>
                                                    <option value="escolaridadeName">Escolaridade</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-12 pb-3">
                                                <select class="form-select font-size-12" name="modal_relatorio_12_campos_colunas[]" id="modal_relatorio_12_campos_coluna_2">
                                                    <option value="">Selecione um Campo para Coluna 2</option>
                                                    <option value="rg">RG</option>
                                                    <option value="nome">Nome Militar</option>
                                                    <option value="situacaoName">Situação</option>
                                                    <option value="boletim_situacao">Boletim Situação</option>
                                                    <option value="graduacaoName">Graduação</option>
                                                    <option value="boletim_graduacao">Boletim Graduação</option>
                                                    <option value="unidadeName">Unidade</option>
                                                    <option value="boletim_movimentacao">Boletim Movimentação</option>
                                                    <option value="quadroName">Quadro</option>
                                                    <option value="boletim_quadro">Boletim Quadro</option>
                                                    <option value="sexoBiologicoName">Sexo Biológico</option>
                                                    <option value="generoName">Gênero</option>
                                                    <option value="data_ingresso">Data Ingresso</option>
                                                    <option value="boletim_ingresso">Boletim Ingresso</option>
                                                    <option value="nome_guerra">Nome Guerra</option>
                                                    <option value="prestandoServicoName">Prestando Serviço</option>
                                                    <option value="boletim_prestando_servico">Boletim Prestando Serviço</option>
                                                    <option value="funcaoName">Função</option>
                                                    <option value="boletim_funcao">Boletim Função</option>
                                                    <option value="bancoName">Banco</option>
                                                    <option value="agencia">Agência Bacária</option>
                                                    <option value="conta_corrente">Conta Corrente</option>
                                                    <option value="cpf">CPF</option>
                                                    <option value="pasep">PASEP</option>
                                                    <option value="pai">Pai</option>
                                                    <option value="estadoCivilName">Estado Civil</option>
                                                    <option value="mae">Mãe</option>
                                                    <option value="data_nascimento">Data Nascimento</option>
                                                    <option value="aniversario">Aniversário</option>
                                                    <option value="comportamentoName">Comportamento</option>
                                                    <option value="boletim_comportamento">Boletim Comportamento</option>
                                                    <option value="altura">Altura</option>
                                                    <option value="tipoSanguineoName">Tipo Sanguíneo</option>
                                                    <option value="fatorRhName">Fator RH</option>
                                                    <option value="titulo_eleitoral">Título Eleitoral</option>
                                                    <option value="titulo_eleitoral_zona">Título Eleitoral Zona</option>
                                                    <option value="titulo_eleitoral_secao">Título Eleitoral Seção</option>
                                                    <option value="titulo_eleitoral_uf">Título Eleitoral UF</option>
                                                    <option value="certificado_reservista">Certificado Reservista</option>
                                                    <option value="certificado_reservista_serie">Certificado Reservista Série</option>
                                                    <option value="certificado_reservista_categoria">Certificado Reservista Categoria</option>
                                                    <option value="identidade_funcional">Identidade Funcional</option>
                                                    <option value="vinculo">Vínculo</option>
                                                    <option value="temporario">Temporário</option>
                                                    <option value="nacionalidadeName">Nacionalidade</option>
                                                    <option value="naturalidadeName">Naturalidade</option>
                                                    <option value="escolaridadeName">Escolaridade</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-12 pb-3">
                                                <select class="form-select font-size-12" name="modal_relatorio_12_campos_colunas[]" id="modal_relatorio_12_campos_coluna_3">
                                                    <option value="">Selecione um Campo para Coluna 3</option>
                                                    <option value="rg">RG</option>
                                                    <option value="nome">Nome Militar</option>
                                                    <option value="situacaoName">Situação</option>
                                                    <option value="boletim_situacao">Boletim Situação</option>
                                                    <option value="graduacaoName">Graduação</option>
                                                    <option value="boletim_graduacao">Boletim Graduação</option>
                                                    <option value="unidadeName">Unidade</option>
                                                    <option value="boletim_movimentacao">Boletim Movimentação</option>
                                                    <option value="quadroName">Quadro</option>
                                                    <option value="boletim_quadro">Boletim Quadro</option>
                                                    <option value="sexoBiologicoName">Sexo Biológico</option>
                                                    <option value="generoName">Gênero</option>
                                                    <option value="data_ingresso">Data Ingresso</option>
                                                    <option value="boletim_ingresso">Boletim Ingresso</option>
                                                    <option value="nome_guerra">Nome Guerra</option>
                                                    <option value="prestandoServicoName">Prestando Serviço</option>
                                                    <option value="boletim_prestando_servico">Boletim Prestando Serviço</option>
                                                    <option value="funcaoName">Função</option>
                                                    <option value="boletim_funcao">Boletim Função</option>
                                                    <option value="bancoName">Banco</option>
                                                    <option value="agencia">Agência Bacária</option>
                                                    <option value="conta_corrente">Conta Corrente</option>
                                                    <option value="cpf">CPF</option>
                                                    <option value="pasep">PASEP</option>
                                                    <option value="pai">Pai</option>
                                                    <option value="estadoCivilName">Estado Civil</option>
                                                    <option value="mae">Mãe</option>
                                                    <option value="data_nascimento">Data Nascimento</option>
                                                    <option value="aniversario">Aniversário</option>
                                                    <option value="comportamentoName">Comportamento</option>
                                                    <option value="boletim_comportamento">Boletim Comportamento</option>
                                                    <option value="altura">Altura</option>
                                                    <option value="tipoSanguineoName">Tipo Sanguíneo</option>
                                                    <option value="fatorRhName">Fator RH</option>
                                                    <option value="titulo_eleitoral">Título Eleitoral</option>
                                                    <option value="titulo_eleitoral_zona">Título Eleitoral Zona</option>
                                                    <option value="titulo_eleitoral_secao">Título Eleitoral Seção</option>
                                                    <option value="titulo_eleitoral_uf">Título Eleitoral UF</option>
                                                    <option value="certificado_reservista">Certificado Reservista</option>
                                                    <option value="certificado_reservista_serie">Certificado Reservista Série</option>
                                                    <option value="certificado_reservista_categoria">Certificado Reservista Categoria</option>
                                                    <option value="identidade_funcional">Identidade Funcional</option>
                                                    <option value="vinculo">Vínculo</option>
                                                    <option value="temporario">Temporário</option>
                                                    <option value="nacionalidadeName">Nacionalidade</option>
                                                    <option value="naturalidadeName">Naturalidade</option>
                                                    <option value="escolaridadeName">Escolaridade</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-12 pb-3">
                                                <select class="form-select font-size-12" name="modal_relatorio_12_campos_colunas[]" id="modal_relatorio_12_campos_coluna_4">
                                                    <option value="">Selecione um Campo para Coluna 4</option>
                                                    <option value="rg">RG</option>
                                                    <option value="nome">Nome Militar</option>
                                                    <option value="situacaoName">Situação</option>
                                                    <option value="boletim_situacao">Boletim Situação</option>
                                                    <option value="graduacaoName">Graduação</option>
                                                    <option value="boletim_graduacao">Boletim Graduação</option>
                                                    <option value="unidadeName">Unidade</option>
                                                    <option value="boletim_movimentacao">Boletim Movimentação</option>
                                                    <option value="quadroName">Quadro</option>
                                                    <option value="boletim_quadro">Boletim Quadro</option>
                                                    <option value="sexoBiologicoName">Sexo Biológico</option>
                                                    <option value="generoName">Gênero</option>
                                                    <option value="data_ingresso">Data Ingresso</option>
                                                    <option value="boletim_ingresso">Boletim Ingresso</option>
                                                    <option value="nome_guerra">Nome Guerra</option>
                                                    <option value="prestandoServicoName">Prestando Serviço</option>
                                                    <option value="boletim_prestando_servico">Boletim Prestando Serviço</option>
                                                    <option value="funcaoName">Função</option>
                                                    <option value="boletim_funcao">Boletim Função</option>
                                                    <option value="bancoName">Banco</option>
                                                    <option value="agencia">Agência Bacária</option>
                                                    <option value="conta_corrente">Conta Corrente</option>
                                                    <option value="cpf">CPF</option>
                                                    <option value="pasep">PASEP</option>
                                                    <option value="pai">Pai</option>
                                                    <option value="estadoCivilName">Estado Civil</option>
                                                    <option value="mae">Mãe</option>
                                                    <option value="data_nascimento">Data Nascimento</option>
                                                    <option value="aniversario">Aniversário</option>
                                                    <option value="comportamentoName">Comportamento</option>
                                                    <option value="boletim_comportamento">Boletim Comportamento</option>
                                                    <option value="altura">Altura</option>
                                                    <option value="tipoSanguineoName">Tipo Sanguíneo</option>
                                                    <option value="fatorRhName">Fator RH</option>
                                                    <option value="titulo_eleitoral">Título Eleitoral</option>
                                                    <option value="titulo_eleitoral_zona">Título Eleitoral Zona</option>
                                                    <option value="titulo_eleitoral_secao">Título Eleitoral Seção</option>
                                                    <option value="titulo_eleitoral_uf">Título Eleitoral UF</option>
                                                    <option value="certificado_reservista">Certificado Reservista</option>
                                                    <option value="certificado_reservista_serie">Certificado Reservista Série</option>
                                                    <option value="certificado_reservista_categoria">Certificado Reservista Categoria</option>
                                                    <option value="identidade_funcional">Identidade Funcional</option>
                                                    <option value="vinculo">Vínculo</option>
                                                    <option value="temporario">Temporário</option>
                                                    <option value="nacionalidadeName">Nacionalidade</option>
                                                    <option value="naturalidadeName">Naturalidade</option>
                                                    <option value="escolaridadeName">Escolaridade</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-12 pb-3">
                                                <select class="form-select font-size-12" name="modal_relatorio_12_campos_colunas[]" id="modal_relatorio_12_campos_coluna_5">
                                                    <option value="">Selecione um Campo para Coluna 5</option>
                                                    <option value="rg">RG</option>
                                                    <option value="nome">Nome Militar</option>
                                                    <option value="situacaoName">Situação</option>
                                                    <option value="boletim_situacao">Boletim Situação</option>
                                                    <option value="graduacaoName">Graduação</option>
                                                    <option value="boletim_graduacao">Boletim Graduação</option>
                                                    <option value="unidadeName">Unidade</option>
                                                    <option value="boletim_movimentacao">Boletim Movimentação</option>
                                                    <option value="quadroName">Quadro</option>
                                                    <option value="boletim_quadro">Boletim Quadro</option>
                                                    <option value="sexoBiologicoName">Sexo Biológico</option>
                                                    <option value="generoName">Gênero</option>
                                                    <option value="data_ingresso">Data Ingresso</option>
                                                    <option value="boletim_ingresso">Boletim Ingresso</option>
                                                    <option value="nome_guerra">Nome Guerra</option>
                                                    <option value="prestandoServicoName">Prestando Serviço</option>
                                                    <option value="boletim_prestando_servico">Boletim Prestando Serviço</option>
                                                    <option value="funcaoName">Função</option>
                                                    <option value="boletim_funcao">Boletim Função</option>
                                                    <option value="bancoName">Banco</option>
                                                    <option value="agencia">Agência Bacária</option>
                                                    <option value="conta_corrente">Conta Corrente</option>
                                                    <option value="cpf">CPF</option>
                                                    <option value="pasep">PASEP</option>
                                                    <option value="pai">Pai</option>
                                                    <option value="estadoCivilName">Estado Civil</option>
                                                    <option value="mae">Mãe</option>
                                                    <option value="data_nascimento">Data Nascimento</option>
                                                    <option value="aniversario">Aniversário</option>
                                                    <option value="comportamentoName">Comportamento</option>
                                                    <option value="boletim_comportamento">Boletim Comportamento</option>
                                                    <option value="altura">Altura</option>
                                                    <option value="tipoSanguineoName">Tipo Sanguíneo</option>
                                                    <option value="fatorRhName">Fator RH</option>
                                                    <option value="titulo_eleitoral">Título Eleitoral</option>
                                                    <option value="titulo_eleitoral_zona">Título Eleitoral Zona</option>
                                                    <option value="titulo_eleitoral_secao">Título Eleitoral Seção</option>
                                                    <option value="titulo_eleitoral_uf">Título Eleitoral UF</option>
                                                    <option value="certificado_reservista">Certificado Reservista</option>
                                                    <option value="certificado_reservista_serie">Certificado Reservista Série</option>
                                                    <option value="certificado_reservista_categoria">Certificado Reservista Categoria</option>
                                                    <option value="identidade_funcional">Identidade Funcional</option>
                                                    <option value="vinculo">Vínculo</option>
                                                    <option value="temporario">Temporário</option>
                                                    <option value="nacionalidadeName">Nacionalidade</option>
                                                    <option value="naturalidadeName">Naturalidade</option>
                                                    <option value="escolaridadeName">Escolaridade</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-12 pb-3">
                                                <select class="form-select font-size-12" name="modal_relatorio_12_campos_colunas[]" id="modal_relatorio_12_campos_coluna_6">
                                                    <option value="">Selecione um Campo para Coluna 6</option>
                                                    <option value="rg">RG</option>
                                                    <option value="nome">Nome Militar</option>
                                                    <option value="situacaoName">Situação</option>
                                                    <option value="boletim_situacao">Boletim Situação</option>
                                                    <option value="graduacaoName">Graduação</option>
                                                    <option value="boletim_graduacao">Boletim Graduação</option>
                                                    <option value="unidadeName">Unidade</option>
                                                    <option value="boletim_movimentacao">Boletim Movimentação</option>
                                                    <option value="quadroName">Quadro</option>
                                                    <option value="boletim_quadro">Boletim Quadro</option>
                                                    <option value="sexoBiologicoName">Sexo Biológico</option>
                                                    <option value="generoName">Gênero</option>
                                                    <option value="data_ingresso">Data Ingresso</option>
                                                    <option value="boletim_ingresso">Boletim Ingresso</option>
                                                    <option value="nome_guerra">Nome Guerra</option>
                                                    <option value="prestandoServicoName">Prestando Serviço</option>
                                                    <option value="boletim_prestando_servico">Boletim Prestando Serviço</option>
                                                    <option value="funcaoName">Função</option>
                                                    <option value="boletim_funcao">Boletim Função</option>
                                                    <option value="bancoName">Banco</option>
                                                    <option value="agencia">Agência Bacária</option>
                                                    <option value="conta_corrente">Conta Corrente</option>
                                                    <option value="cpf">CPF</option>
                                                    <option value="pasep">PASEP</option>
                                                    <option value="pai">Pai</option>
                                                    <option value="estadoCivilName">Estado Civil</option>
                                                    <option value="mae">Mãe</option>
                                                    <option value="data_nascimento">Data Nascimento</option>
                                                    <option value="aniversario">Aniversário</option>
                                                    <option value="comportamentoName">Comportamento</option>
                                                    <option value="boletim_comportamento">Boletim Comportamento</option>
                                                    <option value="altura">Altura</option>
                                                    <option value="tipoSanguineoName">Tipo Sanguíneo</option>
                                                    <option value="fatorRhName">Fator RH</option>
                                                    <option value="titulo_eleitoral">Título Eleitoral</option>
                                                    <option value="titulo_eleitoral_zona">Título Eleitoral Zona</option>
                                                    <option value="titulo_eleitoral_secao">Título Eleitoral Seção</option>
                                                    <option value="titulo_eleitoral_uf">Título Eleitoral UF</option>
                                                    <option value="certificado_reservista">Certificado Reservista</option>
                                                    <option value="certificado_reservista_serie">Certificado Reservista Série</option>
                                                    <option value="certificado_reservista_categoria">Certificado Reservista Categoria</option>
                                                    <option value="identidade_funcional">Identidade Funcional</option>
                                                    <option value="vinculo">Vínculo</option>
                                                    <option value="temporario">Temporário</option>
                                                    <option value="nacionalidadeName">Nacionalidade</option>
                                                    <option value="naturalidadeName">Naturalidade</option>
                                                    <option value="escolaridadeName">Escolaridade</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="col-12 text-end" id="modal_relatorio_12_footer_1">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="modal_relatorio_12_cancelar">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="relatoriosRelatorio12(2)">Gerar</button>
                    </div>
                    <div class="col-12 text-center" id="modal_relatorio_12_footer_2" style="display: none;">
                        <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Processando...
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<!-- jspdf.js -->
<script src="{{ asset('assets/libs/jspdf/jspdf.js')}}"></script>

<!-- jspdf_autotable.js -->
<script src="{{ asset('assets/libs/jspdf/jspdf_autotable.js')}}"></script>

<!-- scripts_relatorios.js -->
<script src="{{ asset('assets/js/scripts_relatorios.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
