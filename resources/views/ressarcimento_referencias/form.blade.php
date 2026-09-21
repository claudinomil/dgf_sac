<!-- Formulario -->
<div class="font-size-12" id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">
                        <!-- store or update -->
                        @if(temPermissao('ressarcimento_referencias_create') || temPermissao('ressarcimento_referencias_edit'))
                        <!-- Botão Confirnar Operação -->
                         <x-button-crud op="5" onclick="crudConfirmOperation();" />
                         @endif

                         <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" />
                    </div>
                    <div class="modal-buttons" id="crudFormButtons2">
                        <!-- edit or delete -->
                        @if(temPermissao('ressarcimento_referencias_edit'))
                        <!-- Botão Alterar Registro -->
                        <x-button-crud op="2" onclick="crudEdit(0)" />
                        @endif

                        @if(temPermissao('ressarcimento_referencias_destroy'))
                        <!-- Botão Excluir Registro -->
                        <x-button-crud op="3" onclick="crudDelete(0);" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" />
                    </div>

                    <!-- Formulário - Form -->
                    <form id="{{ session('crudNameFormSubmodulo') }}" name="{{ session('crudNameFormSubmodulo') }}">
                        <fieldset>
                            <input type="hidden" id="frm_operacao" name="frm_operacao">
                            <input type="hidden" id="registro_id" name="registro_id">

                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-info text-start"></i>- <b>Informações Gerais</b></div>
                                <div class="form-group col-12 col-md-6 pb-3">
                                    <label class="form-label">Referência</label>
                                    <input type="text" class="form-control" id="referencia_extenso" name="referencia_extenso" readonly>
                                    <input type="hidden" id="referencia" name="referencia" min="202301" max="203012" minlength="6" maxlength="6" required="required">
                                </div>
                                <div class="form-group col-4 col-md-2 pb-3">
                                    <label class="form-label">Ano</label>
                                    <input type="text" class="form-control" id="ano" name="ano" min="2023" max="2030" minlength="4" maxlength="4" required="required">
                                </div>
                                <div class="form-group col-4 col-md-2 pb-3">
                                    <label class="form-label">Mês</label>
                                    <input type="text" class="form-control" id="mes" name="mes" min="01" max="12" minlength="2" maxlength="2" required="required">
                                </div>
                                <div class="form-group col-4 col-md-2 pb-3">
                                    <label class="form-label">Parte</label>
                                    <input type="text" class="form-control" id="parte" name="parte" min="01" max="30" minlength="2" maxlength="2" required="required">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
