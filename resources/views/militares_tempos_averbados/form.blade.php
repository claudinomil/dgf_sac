<!-- Formulario -->
<div class="font-size-12" id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">
                        <!-- store or update -->
                        @if(temPermissao('militares_tempos_averbados_create') || temPermissao('militares_tempos_averbados_edit'))
                        <!-- Botão Confirnar Operação -->
                        <x-button-crud op="5" onclick="crudConfirmOperation();" id="crudFormButtons1ConfirmOperation" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" id="crudFormButtons1CancelOperation" />
                    </div>
                    <div class="modal-buttons" id="crudFormButtons2">
                        <!-- edit or delete -->
                        @if(temPermissao('militares_tempos_averbados_edit'))
                        <!-- Botão Alterar Registro -->
                        <x-button-crud op="2" onclick="crudEdit(0)" id="crudFormButtons2Edit" />
                        @endif

                        @if(temPermissao('militares_tempos_averbados_destroy'))
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
                                <div class="form-group col-12 col-md-6 pb-3">
                                    <label class="form-label">Tempo Averbado Local</label>
                                    <select class="form-control" name="tempo_averbado_local_id" id="tempo_averbado_local_id" required="required">
                                        <option value="">Selecione...</option>

                                        @foreach ($tempos_averbados_locais as $tempo_averbado_local)
                                        <option value="{{ $tempo_averbado_local['id'] }}">{{ $tempo_averbado_local['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Data Ingresso Local</label>
                                    <input type="text" class="form-control mask_date" id="data_ingresso_local" name="data_ingresso_local" required="required">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Data Término Local</label>
                                    <input type="text" class="form-control mask_date" id="data_termino_local" name="data_termino_local" required="required">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">
                                        Tempo Apurado Local
                                        <a href="javascript:void(0);" class="text-success font-size-10 text-decoration-none ms-2" onclick="calcularTempoApuradoLocal();">Calcular</a>
                                    </label>
                                    <input type="text" class="form-control" id="tempo_apurado_local" name="tempo_apurado_local" required="required">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Boletim</label>
                                    <input type="text" class="form-control mask_boletim" id="boletim" name="boletim" required="required">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Referência Processo SEI</label>
                                    <input type="text" class="form-control mask_processo_sei" id="referencia_processo_sei" name="referencia_processo_sei" maxlength="200">
                                </div>
                                <div class="form-group col-12 col-md-7 pb-3">
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
