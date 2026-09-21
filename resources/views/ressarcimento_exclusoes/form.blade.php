<!-- Formulario -->
<div id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 mb-4">
                <div class="card-body">
                    <!-- Campo hidden para controle -->
                    <input type="hidden" id="ctrl_referencia" name="ctrl_referencia">

                    <!-- Campos hiddens para a tabela ressarcimento_exclusoes -->
                    <input type="hidden" id="referencia" name="referencia" value="">
                    <input type="hidden" id="ano" name="ano" value="">
                    <input type="hidden" id="mes" name="mes" value="">
                    <input type="hidden" id="parte" name="parte" value="">
                    <input type="hidden" id="militares" name="militares" value="">

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
                                <div class="col-12 text-end">
                                    <!-- Botão Cancelar Operação -->
                                    <x-button-crud op="4" onclick="crudCancelOperation();" />
                                </div>
                                <div class="col-12 text-end pt-2">
                                    @if(temPermissao('ressarcimento_exclusoes_create'))
                                    <!-- Botão Confirnar Operação -->
                                    <button type="button" class="btn btn-sm btn-danger text-white mb-2 font-size-12 waves-effect btn-label waves-light " data-bs-toggle="tooltip" data-bs-placement="top" data-bs-target="" data-bs-original-title="Confirmar Exclusão" id="btn_exclusao_ressarcimento">
                                        <i class="fa fa-trash-alt label-icon"></i>
                                        Excluir
                                    </button>
                                    @endif
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

<!-- Modal para Confirmação: Exclusão Ressarcimento -->
<div class="modal fade confirmacaoExclusaoRessarcimento" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmação: Exclusão Ressarcimento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 alert alert-danger mb-1">
                        <div class="col-12 text-center"><h6 class="text-danger">Aviso</h6></div>
                        <div class="col-12 text-center text-danger font-size-11">Remover dados de Militares para a referência</div>
                        <div class="col-12 text-center text-danger font-size-11">Remover dados de Pagamentos para a referência</div>
                        <div class="col-12 text-center text-danger font-size-11">Remover dados de Cobrança para a referência</div>
                        <div class="col-12 text-center text-danger font-size-11">Remover dados de Recebimentos para a referência</div>
                        <div class="col-12 text-center text-danger font-size-11">Excluir arquivos PDFs para a referência</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-12 text-center confirmacaoExclusaoRessarcimento_loading" style="display: none;">Executando serviço...</div>
                <div class="col-12 text-center spinner-chase confirmacaoExclusaoRessarcimento_loading" style="display: none;">
                    <div class="spinner-chase">
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                        <div class="chase-dot"></div>
                    </div>
                </div>

                <button type="button" class="btn btn-sm btn-secondary confirmacaoExclusaoRessarcimento_botoes" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-sm btn-success confirmacaoExclusaoRessarcimento_botoes" id="btn_exclusao_ressarcimento_confirmar">Confirmar</button>
            </div>
        </div>
    </div>
</div>
