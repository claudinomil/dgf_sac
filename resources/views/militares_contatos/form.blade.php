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

                            <input type="hiddenx" id="militar_id" name="militar_id" value="0" />
                            <input type="hiddenx" id="militar_id_token" name="militar_id_token" value="xxxyyyzzz" />

                            <input type="hiddenx" id="militarSituacaoId" name="militarSituacaoId" value="0" />
                            <input type="hiddenx" id="militarSituacaoId_token" name="militarSituacaoId_token" value="xxxyyyzzz" />

                            <div class="row pt-4" id="divPesquisarMilitar" style="display: none;">
                                <div class="font-size-16 pb-4"><i class="fas fa-person-military-pointing text-start"></i>- <b>Pesquisar Militar</b></div>
                                <div class="form-group col-12 col-md-12 pb-3">
                                    <label class="form-label">Nome / RG / Id. Funcional</label>
                                    <input type="text" class="form-control" id="pesquisar_militar" name="pesquisar_militar">
                                    <div id="autocomplete_militar" class="list-group position-absolute col-12 col-md-8" style="z-index:999;"></div>
                                </div>
                            </div>

                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-person-military-pointing text-start"></i>- <b>Informações Militar</b></div>
                                <div class="form-group col-12 col-md-8 pb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control text-uppercase" id="militarNome" name="militarNome">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">RG</label>
                                    <input type="text" class="form-control text-uppercase" id="militarRg" name="militarRg">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Id. Funcional</label>
                                    <input type="text" class="form-control text-uppercase" id="militarIdentidadeFuncional" name="militarIdentidadeFuncional">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Situação</label>
                                    <input type="text" class="form-control text-uppercase" id="militarSituacaoName" name="militarSituacaoName">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Posto/Graduação</label>
                                    <input type="text" class="form-control text-uppercase" id="militarGraduacaoName" name="militarGraduacaoName">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Quadro</label>
                                    <input type="text" class="form-control text-uppercase" id="militarQuadroEspecialidadeName" name="militarQuadroEspecialidadeName">
                                </div>
                            </div>

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
