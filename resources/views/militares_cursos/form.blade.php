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
