<!-- Formulario -->
<div class="font-size-12" id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">
                        <!-- store or update -->
                        @if(temPermissao('dashboards_tvs_controles_create') || temPermissao('dashboards_tvs_controles_edit'))
                        <!-- Botão Confirnar Operação -->
                        <x-button-crud op="5" onclick="crudConfirmOperation();" id="crudFormButtons1ConfirmOperation" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" id="crudFormButtons1CancelOperation" />
                    </div>
                    <div class="modal-buttons" id="crudFormButtons2">
                        <!-- edit or delete -->
                        @if(temPermissao('dashboards_tvs_controles_edit'))
                        <!-- Botão Alterar Registro -->
                        <x-button-crud op="2" onclick="crudEdit(0)" id="crudFormButtons2Edit" />
                        @endif

                        @if(temPermissao('dashboards_tvs_controles_destroy'))
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

                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-info text-start"></i>- <b>Informações Gerais</b></div>
                                <div class="form-group col-12 col-md-10 pb-3">
                                    <label class="form-label">Unidade</label>
                                    <select class="form-control" name="unidade_id" id="unidade_id" required="required">
                                        <option value="0">Selecione...</option>

                                        @foreach ($unidades as $unidade)
                                            <option value="{{ $unidade['id'] }}">{{ $unidade['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Ano</label>
                                    <select class="form-control" name="ano" id="ano" required="required">
                                        <option value="0000">Todos</option>
                                        
                                        @for ($ano = date('Y'); $ano >= 2000; $ano--)
                                        <option value="{{ $ano }}">{{ $ano }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-info text-start"></i>- <b>Indicadores</b></div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="indicador_1" name="indicador_1" value="1">
                                                <label class="form-check-label" for="indicador_1">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="indicador_2" name="indicador_2" value="1">
                                                <label class="form-check-label" for="indicador_2">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="indicador_3" name="indicador_3" value="1">
                                                <label class="form-check-label" for="indicador_3">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="indicador_4" name="indicador_4" value="1">
                                                <label class="form-check-label" for="indicador_4">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="indicador_5" name="indicador_5" value="1">
                                                <label class="form-check-label" for="indicador_5">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="indicador_6" name="indicador_6" value="1">
                                                <label class="form-check-label" for="indicador_6">Checkbox Primary</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="indicador_7" name="indicador_7" value="1">
                                                <label class="form-check-label" for="indicador_7">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="indicador_8" name="indicador_8" value="1">
                                                <label class="form-check-label" for="indicador_8">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="indicador_9" name="indicador_9" value="1">
                                                <label class="form-check-label" for="indicador_9">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="indicador_10" name="indicador_10" value="1">
                                                <label class="form-check-label" for="indicador_10">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="indicador_11" name="indicador_11" value="1">
                                                <label class="form-check-label" for="indicador_11">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-primary mb-3">
                                                <input class="form-check-input" type="checkbox" id="indicador_12" name="indicador_12" value="1">
                                                <label class="form-check-label" for="indicador_12">Checkbox Primary</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-info text-start"></i>- <b>Gráficos</b></div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-success mb-3">
                                                <input class="form-check-input" type="checkbox" id="grafico_1" name="grafico_1" value="1">
                                                <label class="form-check-label" for="grafico_1">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-success mb-3">
                                                <input class="form-check-input" type="checkbox" id="grafico_2" name="grafico_2" value="1">
                                                <label class="form-check-label" for="grafico_2">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-success mb-3">
                                                <input class="form-check-input" type="checkbox" id="grafico_3" name="grafico_3" value="1">
                                                <label class="form-check-label" for="grafico_3">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-success mb-3">
                                                <input class="form-check-input" type="checkbox" id="grafico_4" name="grafico_4" value="1">
                                                <label class="form-check-label" for="grafico_4">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-success mb-3">
                                                <input class="form-check-input" type="checkbox" id="grafico_5" name="grafico_5" value="1">
                                                <label class="form-check-label" for="grafico_5">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-success mb-3">
                                                <input class="form-check-input" type="checkbox" id="grafico_6" name="grafico_6" value="1">
                                                <label class="form-check-label" for="grafico_6">Checkbox Primary</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-success mb-3">
                                                <input class="form-check-input" type="checkbox" id="grafico_7" name="grafico_7" value="1">
                                                <label class="form-check-label" for="grafico_7">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-success mb-3">
                                                <input class="form-check-input" type="checkbox" id="grafico_8" name="grafico_8" value="1">
                                                <label class="form-check-label" for="grafico_8">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-success mb-3">
                                                <input class="form-check-input" type="checkbox" id="grafico_9" name="grafico_9" value="1">
                                                <label class="form-check-label" for="grafico_9">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-success mb-3">
                                                <input class="form-check-input" type="checkbox" id="grafico_10" name="grafico_10" value="1">
                                                <label class="form-check-label" for="grafico_10">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-success mb-3">
                                                <input class="form-check-input" type="checkbox" id="grafico_11" name="grafico_11" value="1">
                                                <label class="form-check-label" for="grafico_11">Checkbox Primary</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-12 pb-3">
                                            <div class="form-check form-check-success mb-3">
                                                <input class="form-check-input" type="checkbox" id="grafico_12" name="grafico_12" value="1">
                                                <label class="form-check-label" for="grafico_12">Checkbox Primary</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
