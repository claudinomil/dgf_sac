<!-- Formulario -->
<div class="font-size-12" id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">
                        <!-- store or update -->
                        @if(temPermissao('militares_contatos_create') || temPermissao('militares_contatos_edit'))
                        <!-- Botão Confirnar Operação -->
                        <x-button-crud op="5" onclick="crudConfirmOperation();" id="crudFormButtons1ConfirmOperation" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" id="crudFormButtons1CancelOperation" />
                    </div>
                    <div class="modal-buttons" id="crudFormButtons2">
                        <!-- edit or delete -->
                        @if(temPermissao('militares_contatos_edit'))
                        <!-- Botão Alterar Registro -->
                        <x-button-crud op="2" onclick="crudEdit(0)" id="crudFormButtons2Edit" />
                        @endif

                        @if(temPermissao('militares_contatos_destroy'))
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
                                <div class="font-size-16 pb-4"><i class="fas fa-info text-start"></i>- <b>{{ __('Informações Gerais') }}</b></div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">{{ __('CEP') }}</label>
                                    <input type="text" class="form-control mask_cep" id="cep" name="cep" onblur="pesquisacep(this.value);">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">{{ __('Número') }}</label>
                                    <input type="text" class="form-control" id="numero" name="numero">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">{{ __('Complemento') }}</label>
                                    <input type="text" class="form-control text-uppercase" id="complemento" name="complemento">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">{{ __('Logradouro') }}</label>
                                    <input type="text" class="form-control text-uppercase" id="logradouro" name="logradouro" readonly="readonly">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">{{ __('Bairro') }}</label>
                                    <input type="text" class="form-control text-uppercase" id="bairro" name="bairro" readonly="readonly">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">{{ __('Localidade') }}</label>
                                    <input type="text" class="form-control text-uppercase" id="localidade" name="localidade" readonly="readonly">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">{{ __('UF') }}</label>
                                    <input type="text" class="form-control text-uppercase" id="uf" name="uf" readonly="readonly">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">{{ __('Celular 1') }}</label>
                                    <input type="text" class="form-control mask_cell_with_ddd" id="celular_1" name="celular_1">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">{{ __('Celular 2') }}</label>
                                    <input type="text" class="form-control mask_cell_with_ddd" id="celular_2" name="celular_2">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">{{ __('Telefone 1') }}</label>
                                    <input type="text" class="form-control mask_phone_with_ddd" id="telefone_1" name="telefone_1">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">{{ __('Telefone 2') }}</label>
                                    <input type="text" class="form-control mask_phone_with_ddd" id="telefone_2" name="telefone_2">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">{{ __('E-mail') }}</label>
                                    <input type="email" class="form-control mask_email" id="email" name="email">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
