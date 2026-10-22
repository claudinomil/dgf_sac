<!-- Formulario -->
<div class="font-size-12" id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">
                        <!-- store or update -->
                        @if(temPermissao('militares_auxilios_fardamentos_create') || temPermissao('militares_auxilios_fardamentos_edit'))
                        <!-- Botão Confirnar Operação -->
                        <x-button-crud op="5" onclick="crudConfirmOperation();" id="crudFormButtons1ConfirmOperation" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" id="crudFormButtons1CancelOperation" />
                    </div>
                    <div class="modal-buttons" id="crudFormButtons2">
                        <!-- edit or delete -->
                        @if(temPermissao('militares_auxilios_fardamentos_edit'))
                        <!-- Botão Alterar Registro -->
                        <x-button-crud op="2" onclick="crudEdit(0)" id="crudFormButtons2Edit" />
                        @endif

                        @if(temPermissao('militares_auxilios_fardamentos_destroy'))
                        <!-- Botão Excluir Registro -->
                        <x-button-crud op="3" onclick="crudDelete(0);" id="crudFormButtons2Delete" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" id="crudFormButtons2CancelOperation" />
                    </div>

                    <!-- Formulário - Form -->
                    <form id="{{ session('crudNameFormSubmodulo') }}" name="{{ session('crudNameFormSubmodulo') }}">
                        <fieldset>
                            <input type="hidden" id="frm_operacao" name="frm_operacao" />
                            <input type="hidden" id="registro_id" name="registro_id" />

                            <!-- Inclusão de campos hiddens e da Pesquisa de Militar para Incluir Registro -->
                            @include('layouts.pesquisar-militar')

                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-info text-start"></i>- <b>Informações Gerais</b></div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Auxílio Fardamento Tipo</label>
                                    <select class="form-control" name="auxilio_fardamento_tipo_id" id="auxilio_fardamento_tipo_id" required="required">
                                        <option value="">Selecione...</option>

                                        @foreach ($auxilio_fardamento_tipos as $auxilio_fardamento_tipo)
                                        <option value="{{ $auxilio_fardamento_tipo['id'] }}">{{ $auxilio_fardamento_tipo['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Boletim</label>
                                    <input type="text" class="form-control mask_boletim" id="boletim" name="boletim" required="required">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Pagamento</label>
                                    <input type="text" class="form-control mask_pagamento" id="pagamento" name="pagamento" required="required">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Data Última Promoção</label>
                                    <input type="text" class="form-control mask_date" id="data_ultima_promocao" name="data_ultima_promocao" required="required">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Referência Processo SEI</label>
                                    <input type="text" class="form-control mask_processo_sei" id="referencia_processo_sei" name="referencia_processo_sei" maxlength="200">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Requerimento Número</label>
                                    <input type="text" class="form-control mask_requerimento" id="requerimento_numero" name="requerimento_numero" required="required">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Requerimento Data</label>
                                    <input type="text" class="form-control mask_date" id="requerimento_data" name="requerimento_data" required="required">
                                </div>
                                <div class="form-group col-12 col-md-5 pb-3">
                                    <label class="form-label">Requerimento Unidade</label>
                                    <input type="text" class="form-control" id="requerimento_unidade" name="requerimento_unidade" required="required">
                                </div>
                                <div class="form-group col-12 col-md-12 pb-3">
                                    <label class="form-label">Observação</label>
                                    <input type="text" class="form-control" id="observacao" name="observacao" maxlength="255">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
