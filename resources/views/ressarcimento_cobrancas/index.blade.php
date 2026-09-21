@extends('layouts.master')

@section('title')
{{ __('Ressarcimento Cobranças') }}
@endsection

@section('topbar_title')
{{ __('Ressarcimento Cobranças') }}
@endsection

@section('content')

<div id="crudTable">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 mb-4">
                <div class="card-body">
                    <!-- Campo hidden para controle -->
                    <input type="hidden" id="ctrl_referencia" name="ctrl_referencia">

                    <!-- Paineis -->
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <i class="fas fa-file-invoice-dollar text-primary font-size-40"></i>
                                </div>
                                <div class="flex-grow-1 align-self-center">
                                    <div class="text-muted">
                                        <p class="mb-2 font-size-12"><b>RESSARCIMENTO</b></p>
                                        <p class="mb-1 font-size-12" id="re_referencia">Referência</p>
                                        <p class="mb-1 font-size-11" id="re_status_dados">Status Dados</p>
                                        <p class="mb-0 font-size-11" id="re_status_documentos">Status Documentos</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 align-self-center">
                            <div class="text-lg-center mt-4 mt-lg-0">
                                <div class="row">
                                    <div class="col-6 col-sm-3">
                                        <div>
                                            <p class="text-muted text-truncate mb-2 font-size-12">Órgãos</p>
                                            <h5 class="mb-0 font-size-16" id="re_quantidade_orgaos">0</h5>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div>
                                            <p class="text-muted text-truncate mb-2 font-size-12">Militares</p>
                                            <h5 class="mb-0 font-size-16" id="re_quantidade_militares">0</h5>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div>
                                            <p class="text-muted text-truncate mb-2 font-size-12">Pagamento</p>
                                            <h5 class="mb-0 font-size-16" id="re_quantidade_pagamentos">0</h5>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div>
                                            <p class="text-muted text-truncate mb-2 font-size-12">Configuração</p>
                                            <h5 class="mb-0 font-size-16" id="re_quantidade_configuracoes">0</h5>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div>
                                            <p class="text-muted text-truncate mb-2 font-size-12">Cobrança</p>
                                            <h5 class="mb-0 font-size-16" id="re_quantidade_cobranca">0</h5>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div>
                                            <p class="text-muted text-truncate mb-2 font-size-12">Listagem</p>
                                            <h5 class="mb-0 font-size-16" id="re_quantidade_listagens">0</h5>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div>
                                            <p class="text-muted text-truncate mb-2 font-size-12">Notas</p>
                                            <h5 class="mb-0 font-size-16" id="re_quantidade_notas">0</h5>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <div>
                                            <p class="text-muted text-truncate mb-2 font-size-12">Ofícios</p>
                                            <h5 class="mb-0 font-size-16" id="re_quantidade_oficios">0</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-2 d-lg-block">
                            <div class="clearfix mt-4 mt-lg-0">
                                <div class="dropdown float-end">
                                    <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-calendar align-middle me-1"></i> Referências
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        @foreach($referencias as $referencia)
                                            <a class="dropdown-item re_btn_referencia font-size-14" href="#" data-referencia="{{ $referencia }}">{{ getReferencia(1, $referencia) }}</a>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="dropdown float-end pt-3" id="div_botao_cobrancas" style="display: none;">
                                    <button class="btn btn-sm btn-success" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-file-invoice-dollar align-middle me-1 font-size-16"></i> Cobranças
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#" id="re_btn_gerar_cobranca">Gerar Cobrança</a>
                                        <a class="dropdown-item" href="#" id="re_btn_gerar_pdfs">Gerar PDF's</a>
                                        <a class="dropdown-item" href="#" id="re_btn_baixar_pdfs">Baixar PDF's</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Retorno -->
                    <div class="row mt-5">
                        <div class="col-12 col-md-6" id="re_registros_grade_status_dados"></div>
                        <div class="col-12 col-md-6" id="re_registros_grade_status_documentos"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Grade de Registros-->
<div class="modal fade gradeRegistrosModal" tabindex="-1" role="dialog" aria-labelledby=gradeRegistrosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gradeRegistrosModalLabel">Detalhes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Confirmação: Gerar Cobrança -->
<div class="modal fade confirmacaoGerarCobrancaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmação: Gerar Cobrança</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 alert alert-primary mb-1">
                        <div class="col-12 text-center"><h6>Vencimento</h6></div>
                        <div class="col-12 text-center font-size-11"><span id="confirmacaoGerarCobrancaModal_data_vencimento"></span></div>
                    </div>
                    <div class="col-12 alert alert-primary mb-1">
                        <div class="col-12 text-center"><h6><span id="confirmacaoGerarCobrancaModal_diretor_linha_0"></span></h6></div>
                        <div class="col-12 text-center font-size-11"><span id="confirmacaoGerarCobrancaModal_diretor_linha_1"></span></div>
                        <div class="col-12 text-center font-size-11"><span id="confirmacaoGerarCobrancaModal_diretor_linha_2"></span></div>
                        <div class="col-12 text-center font-size-11"><span id="confirmacaoGerarCobrancaModal_diretor_linha_3"></span></div>
                    </div>
                    <div class="col-12 alert alert-primary mb-1">
                        <div class="col-12 text-center"><h6><span id="confirmacaoGerarCobrancaModal_dgf2_linha_0"></span></h6></div>
                        <div class="col-12 text-center font-size-11"><span id="confirmacaoGerarCobrancaModal_dgf2_linha_1"></span></div>
                        <div class="col-12 text-center font-size-11"><span id="confirmacaoGerarCobrancaModal_dgf2_linha_2"></span></div>
                        <div class="col-12 text-center font-size-11"><span id="confirmacaoGerarCobrancaModal_dgf2_linha_3"></span></div>
                    </div>
                    <div class="col-12 alert alert-danger mb-1">
                        <div class="col-12 text-center"><h6 class="text-danger">Aviso</h6></div>
                        <div class="col-12 text-center text-danger font-size-11">Remover dados de Cobrança já gerados para a referência</div>
                        <div class="col-12 text-center text-danger font-size-11">Excluir arquivos PDFs já criados para a referência</div>
                        <div class="col-12 text-center text-danger font-size-11">Gerar dados de Cobrança para a referência</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-12 text-center confirmacaoGerarCobrancaModal_loading" style="display: none;">Executando serviço...</div>
                <div class="col-12 text-center spinner-chase confirmacaoGerarCobrancaModal_loading" style="display: none;">
                    <div class="spinner-chase">
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                    </div>
                </div>

                <button type="button" class="btn btn-sm btn-secondary confirmacaoGerarCobrancaModal_botoes" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-sm btn-success confirmacaoGerarCobrancaModal_botoes" id="re_btn_gerar_cobranca_confirmar">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Confirmação: Gerar PDF's -->
<div class="modal fade confirmacaoGerarPdfsModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmação: Gerar PDFs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 alert alert-danger mb-1">
                        <div class="col-12 text-center"><h6 class="text-danger">Aviso</h6></div>
                        <div class="col-12 text-center text-danger font-size-11">Excluir arquivos PDFs já criados para a referência</div>
                        <div class="col-12 text-center text-danger font-size-11">Criar arquivos PDFs para a referência</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-12 text-center confirmacaoGerarPdfsModal_loading" style="display: none;">Executando serviço...</div>
                <div class="col-12 text-center spinner-chase confirmacaoGerarPdfsModal_loading" style="display: none;">
                    <div class="spinner-chase">
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                    </div>
                </div>

                <button type="button" class="btn btn-sm btn-secondary confirmacaoGerarPdfsModal_botoes" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-sm btn-success confirmacaoGerarPdfsModal_botoes" id="re_btn_gerar_pdfs_confirmar">Confirmar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <!-- scripts_ressarcimento_cobrancas.js -->
    <script src="{{ asset('assets/js/scripts_ressarcimento_cobrancas.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
