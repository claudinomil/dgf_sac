<!-- Formulario -->
<div class="font-size-12" id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">
                        <!-- store or update -->
                        @if(temPermissao('ressarcimento_pagamentos_edit'))
                        <!-- Botão Confirnar Operação -->
                        <x-button-crud op="5" onclick="crudConfirmOperation();" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" />
                    </div>
                    <div class="modal-buttons" id="crudFormButtons2">
                        <!-- delete -->
                        @if(temPermissao('ressarcimento_pagamentos_destroy'))
                        <!-- Botão Excluir Registro -->
                        <x-button-crud op="3" onclick="crudDelete(0);" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" />
                    </div>

                    <!-- Formulário - Form -->
                    <form id="{{ session('crudNameFormSubmodulo') }}" name="{{ session('crudNameFormSubmodulo') }}" enctype="multipart/form-data">
                        <fieldset>
                            <input type="hidden" id="frm_operacao" name="frm_operacao">
                            <input type="hidden" id="registro_id" name="registro_id">
                            <input type="hidden" id="referencia" name="referencia">

                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-info text-start"></i>- <b>Informações Gerais</b></div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Identidade Funcional</label>
                                    <input type="text" class="form-control text-uppercase" id="identidade_funcional" name="identidade_funcional">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">RG</label>
                                    <input type="text" class="form-control text-uppercase" id="rg" name="rg">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Nome Cargo</label>
                                    <input type="text" class="form-control text-uppercase" id="nome_cargo" name="nome_cargo">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Posto Graduação</label>
                                    <input type="text" class="form-control text-uppercase" id="posto_graduacao" name="posto_graduacao">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control text-uppercase" id="nome" name="nome">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">UA</label>
                                    <input type="text" class="form-control text-uppercase" id="ua" name="ua">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Cidade</label>
                                    <input type="text" class="form-control text-uppercase" id="cidade" name="cidade">
                                </div>
                            </div>
                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-list text-start"></i>- <b>Documentos</b></div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">CPF</label>
                                    <input type="text" class="form-control text-uppercase" id="cpf" name="cpf">
                                </div>
                            </div>
                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-bank text-start"></i>- <b>Informações Bancárias</b></div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Banco</label>
                                    <input type="text" class="form-control text-uppercase" id="banco" name="banco">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Agência</label>
                                    <input type="text" class="form-control text-uppercase" id="agencia" name="agencia">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Conta Corrente</label>
                                    <input type="text" class="form-control text-uppercase" id="conta_corrente" name="conta_corrente">
                                </div>
                            </div>
                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-comment-dollar text-start"></i>- <b>Valores Principais</b></div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Bruto</label>
                                    <input type="text" class="form-control mask_money valores_principais" id="bruto" name="bruto">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Fundo Saúde</label>
                                    <input type="text" class="form-control mask_money valores_principais" id="fundo_saude" name="fundo_saude">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Auxílio Transporte</label>
                                    <input type="text" class="form-control mask_money valores_principais" id="auxilio_transporte" name="auxilio_transporte">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Rioprevidência 22</label>
                                    <input type="text" class="form-control mask_money valores_principais" id="rioprevidencia22" name="rioprevidencia22">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Etapa Férias</label>
                                    <input type="text" class="form-control mask_money valores_principais" id="etapa_ferias" name="etapa_ferias">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Etapa Destacado</label>
                                    <input type="text" class="form-control mask_money valores_principais" id="etapa_destacado" name="etapa_destacado">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Abono Permanência</label>
                                    <input type="text" class="form-control mask_money valores_principais" id="abono_permanencia" name="abono_permanencia">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Valor Total</label>
                                    <input type="text" class="form-control mask_money" id="valores_principais_total" name="valores_principais_total" readonly>
                                </div>
                            </div>
                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-comment-dollar text-start"></i>- <b>Outros Valores</b></div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Desconto</label>
                                    <input type="text" class="form-control mask_money" id="desconto" name="desconto">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Líquido</label>
                                    <input type="text" class="form-control mask_money" id="liquido" name="liquido">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Soldo</label>
                                    <input type="text" class="form-control mask_money" id="soldo" name="soldo">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Hospital 10</label>
                                    <input type="text" class="form-control mask_money" id="hospital10" name="hospital10">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Ajuda Fardamento</label>
                                    <input type="text" class="form-control mask_money" id="ajuda_fardamento" name="ajuda_fardamento">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Habilitação Profissional</label>
                                    <input type="text" class="form-control mask_money" id="habilitacao_profissional" name="habilitacao_profissional">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">GRET</label>
                                    <input type="text" class="form-control mask_money" id="gret" name="gret">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Férias</label>
                                    <input type="text" class="form-control mask_money" id="ferias" name="ferias">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Raio X</label>
                                    <input type="text" class="form-control mask_money" id="raio_x" name="raio_x">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Triênio</label>
                                    <input type="text" class="form-control mask_money" id="trienio" name="trienio">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">GRAM</label>
                                    <input type="text" class="form-control mask_money" id="gram" name="gram">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Auxílio Fardamento</label>
                                    <input type="text" class="form-control mask_money" id="auxilio_fardamento" name="auxilio_fardamento">
                                </div>
                            </div>
                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-list-alt text-start"></i>- <b>Observação</b></div>
                                <div class="form-group col-12 col-md-12 pb-3">
                                    <label class="form-label">Observação</label>
                                    <textarea class="form-control text-uppercase" id="observacao" name="observacao"></textarea>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para importação do Pagamento -->
<div class="modal fade modal-importar-pagamentos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Importar Pagamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="frm_importar_ressarcimento_pagamentos">
                    @csrf
                    @method('POST')

                    <div class="mb-3">
                        <label class="form-label small">Referência</label>
                        <select class="form-select form-select-sm" name="ressarcimento_pagamento_referencia" id="ressarcimento_pagamento_referencia" required>
                            <option value="">Selecione...</option>

                            @foreach ($referencias as $referencia)
                                <option value="{{ $referencia }}">{{ getReferencia(1, $referencia) }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Arquivo</label>
                        <div class="input-group">
                            <input type="file" class="form-control form-control-sm" name="ressarcimento_pagamento_file" id="ressarcimento_pagamento_file">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-12 text-end" id="modal-importar-pagamentos-footer-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-primary" id="btnConfirmarImportacaoPagamentos">Confirmar Importação</button>
                </div>
                <div class="col-12 text-center" id="modal-importar-pagamentos-footer-2" style="display: none;">
                    <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Processando...
                </div>
            </div>
        </div>
    </div>
</div>
