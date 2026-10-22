<!-- Formulario -->
<div class="font-size-12" id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">
                        <!-- store or update -->
                        @if(temPermissao('militares_cursos_create') || temPermissao('militares_cursos_edit'))
                        <!-- Botão Confirnar Operação -->
                        <x-button-crud op="5" onclick="crudConfirmOperation();" id="crudFormButtons1ConfirmOperation" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" id="crudFormButtons1CancelOperation" />
                    </div>
                    <div class="modal-buttons" id="crudFormButtons2">
                        <!-- edit or delete -->
                        @if(temPermissao('militares_cursos_edit'))
                        <!-- Botão Alterar Registro -->
                        <x-button-crud op="2" onclick="crudEdit(0)" id="crudFormButtons2Edit" />
                        @endif

                        @if(temPermissao('militares_cursos_destroy'))
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
                                <div class="form-group col-12 col-md-12 pb-3">
                                    <label class="form-label">Curso</label>
                                    <select class="form-control" name="curso_id" id="curso_id" required="required">
                                        <option value="">Selecione...</option>

                                        @foreach ($cursos as $curso)
                                        <option value="{{ $curso['id'] }}">{{ $curso['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Data Início</label>
                                    <input type="text" class="form-control mask_date" id="data_inicio" name="data_inicio">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Data Término</label>
                                    <input type="text" class="form-control mask_date" id="data_termino" name="data_termino" required="required">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Boletim</label>
                                    <input type="text" class="form-control mask_boletim" id="boletim" name="boletim" required="required">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Conceito</label>
                                    <select class="form-control" name="conceito" id="conceito" required="required">
                                        <option value="">Selecione...</option>
                                        <option value="MB">MB</option>
                                        <option value="B">B</option>
                                        <option value="R">R</option>
                                        <option value="I">I</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Classificação</label>
                                    <select class="form-control" name="classificacao" id="classificacao" required="required">
                                        <option value="">Selecione...</option>

                                        @for($i = 1; $i <= 999; $i++)
                                        <option value="{{ str_pad($i, 3, '0', STR_PAD_LEFT) }}">{{ str_pad($i, 3, '0', STR_PAD_LEFT) }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
