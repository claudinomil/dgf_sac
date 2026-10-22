<!-- Formulario -->
<div class="font-size-12" id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">
                        <!-- store or update -->
                        @if(temPermissao('militares_pensoes_create') || temPermissao('militares_pensoes_edit'))
                        <!-- Botão Confirnar Operação -->
                        <x-button-crud op="5" onclick="crudConfirmOperation();" id="crudFormButtons1ConfirmOperation" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" id="crudFormButtons1CancelOperation" />
                    </div>
                    <div class="modal-buttons" id="crudFormButtons2">
                        <!-- edit or delete -->
                        @if(temPermissao('militares_pensoes_edit'))
                        <!-- Botão Alterar Registro -->
                        <x-button-crud op="2" onclick="crudEdit(0)" id="crudFormButtons2Edit" />
                        @endif

                        @if(temPermissao('militares_pensoes_destroy'))
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
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Pensão Tipo</label>
                                    <select class="form-control" name="pensao_tipo_id" id="pensao_tipo_id" required="required">
                                        <option value="">Selecione...</option>

                                        @foreach ($pensao_tipos as $pensao_tipo)
                                        <option value="{{ $pensao_tipo['id'] }}">{{ $pensao_tipo['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Desconto</label>
                                    <input type="text" class="form-control" id="desconto" name="desconto">
                                </div>
                                <div class="form-group col-12 col-md-7 pb-3">
                                    <label class="form-label">Representante Legal</label>
                                    <input type="text" class="form-control" id="representante_legal" name="representante_legal">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Logradouro</label>
                                    <input type="text" class="form-control" id="logradouro" name="logradouro">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Estado</label>
                                    <input type="text" class="form-control" id="estado" name="estado">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">CEP</label>
                                    <input type="text" class="form-control mask_cep" id="cep" name="cep">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Telefone</label>
                                    <input type="text" class="form-control mask_phone_with_ddd" id="telefone" name="telefone">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Celular</label>
                                    <input type="text" class="form-control mask_cell_with_ddd" id="celular" name="celular">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">CPF</label>
                                    <input type="text" class="form-control mask_cpf" id="cpf" name="cpf">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Data Nascimento</label>
                                    <input type="text" class="form-control mask_date" id="data_nascimento" name="data_nascimento">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Banco</label>
                                    <input type="text" class="form-control" id="banco" name="">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Agência</label>
                                    <input type="text" class="form-control" id="agencia" name="agencia">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Conta Corrente</label>
                                    <input type="text" class="form-control" id="conta_corrente" name="conta_corrente">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Documento</label>
                                    <input type="text" class="form-control" id="documento" name="documento">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Data Documento</label>
                                    <input type="text" class="form-control mask_date" id="data_documento" name="data_documento">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Processo</label>
                                    <input type="text" class="form-control" id="numero_processo" name="numero_processo">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Vara Família</label>
                                    <input type="text" class="form-control" id="vara_familia" name="vara_familia">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Cancelar em</label>
                                    <input type="text" class="form-control" id="cancelar_em" name="cancelar_em">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Alterar em</label>
                                    <input type="text" class="form-control" id="alterar_em" name="alterar_em">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Implantacao</label>
                                    <input type="text" class="form-control mask_date" id="implantacao" name="implantacao">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Beneficiario</label>
                                    <input type="text" class="form-control" id="beneficiario" name="beneficiario">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">CPF</label>
                                    <input type="text" class="form-control mask_cpf" id="cpf_beneficiario" name="cpf_beneficiario">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Data Nascimento</label>
                                    <input type="text" class="form-control mask_date" id="nascimento_beneficiario" name="nascimento_beneficiario">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Referência Processo SEI</label>
                                    <input type="text" class="form-control mask_processo_sei" id="referencia_processo_sei" name="referencia_processo_sei" maxlength="200">
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
