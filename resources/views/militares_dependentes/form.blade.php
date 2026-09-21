<!-- Formulario -->
<div class="font-size-12" id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">
                        <!-- store or update -->
                        @if(temPermissao('militares_dependentes_create') || temPermissao('militares_dependentes_edit'))
                        <!-- Botão Confirnar Operação -->
                        <x-button-crud op="5" onclick="crudConfirmOperation();" id="crudFormButtons1ConfirmOperation" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" id="crudFormButtons1CancelOperation" />
                    </div>
                    <div class="modal-buttons" id="crudFormButtons2">
                        <!-- edit or delete -->
                        @if(temPermissao('militares_dependentes_edit'))
                        <!-- Botão Alterar Registro -->
                        <x-button-crud op="2" onclick="crudEdit(0)" id="crudFormButtons2Edit" />
                        @endif

                        @if(temPermissao('militares_dependentes_destroy'))
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


                            <button type="button" onclick="preenchimento_teste();">Dados Teste</button>


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
                                    <label class="form-label">Parentesco</label>
                                    <select class="form-control" name="parentesco_id" id="parentesco_id" required="required">
                                        <option value="">Selecione...</option>

                                        @foreach ($parentescos as $parentesco)
                                        <option value="{{ $parentesco['id'] }}">{{ $parentesco['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-6 pb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control text-uppercase" id="name" name="name" required="required">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">CPF</label>
                                    <input type="text" class="form-control mask_cpf" id="cpf" name="cpf" required="required">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Data Nascimento</label>
                                    <input type="text" class="form-control mask_date" id="data_nascimento" name="data_nascimento">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Data Casamento</label>
                                    <input type="text" class="form-control mask_date" id="data_casamento" name="data_casamento">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Sexo Biológico</label>
                                    <select class="form-control" name="sexo_biologico_id" id="sexo_biologico_id" required="required">
                                        <option value="">Selecione...</option>

                                        @foreach ($sexos_biologicos as $sexo_biologico)
                                        <option value="{{ $sexo_biologico['id'] }}">{{ $sexo_biologico['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Vínculo Permanente</label>
                                    <select class="form-control" name="vinculo_permanente" id="vinculo_permanente" required="required">
                                        <option value="">Selecione...</option>
                                        <option value="0">NÃO</option>
                                        <option value="1">SIM</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Boletim</label>
                                    <input type="text" class="form-control mask_boletim" id="boletim" name="boletim">
                                </div>
                                <div class="form-group col-12 col-md-6 pb-3">
                                    <label class="form-label">Unidade</label>
                                    <input type="text" class="form-control text-uppercase" id="unidade" name="unidade">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Número Requerimento</label>
                                    <input type="text" class="form-control" id="numero_requerimento" name="numero_requerimento">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Data Requerimento</label>
                                    <input type="text" class="form-control mask_date" id="data_requerimento" name="data_requerimento">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Número Processo</label>
                                    <input type="text" class="form-control" id="numero_processo" name="numero_processo">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Data Processo</label>
                                    <input type="text" class="form-control mask_date" id="data_processo" name="data_processo">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Decisão Judicial</label>
                                    <select class="form-control" name="decisao_judicial" id="decisao_judicial" required="required">
                                        <option value="">Selecione...</option>
                                        <option value="0">NÃO</option>
                                        <option value="1">SIM</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Decisão Judicial Documento</label>
                                    <input type="text" class="form-control" id="decisao_judicial_documento" name="decisao_judicial_documento">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Decisão Judicial A Contar De</label>
                                    <input type="text" class="form-control mask_date" id="decisao_judicial_a_contar_de" name="decisao_judicial_a_contar_de">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Imposto Renda</label>
                                    <select class="form-control" name="imposto_renda" id="imposto_renda" required="required">
                                        <option value="">Selecione...</option>
                                        <option value="0">NÃO</option>
                                        <option value="1">SIM</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Fundo Saúde</label>
                                    <select class="form-control" name="fundo_saude" id="fundo_saude" required="required">
                                        <option value="">Selecione...</option>
                                        <option value="0">NÃO</option>
                                        <option value="1">SIM</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Referência Processo SEI</label>
                                    <input type="text" class="form-control" id="referencia_processo_sei" name="referencia_processo_sei">
                                </div>
                                <div class="form-group col-12 col-md-9 pb-3">
                                    <label class="form-label">Observação</label>
                                    <textarea class="form-control" id="observacao" name="observacao"></textarea>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
