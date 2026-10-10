<!-- Formulario -->
<div class="font-size-12" id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">
                        <!-- store or update -->
                        @if(temPermissao('homologacao_solicitacoes_create') || temPermissao('homologacao_solicitacoes_edit'))
                        <!-- Botão Confirnar Operação -->
                        <x-button-crud op="5" onclick="crudConfirmOperation();" id="crudFormButtons1ConfirmOperation" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" id="crudFormButtons1CancelOperation" />
                    </div>
                    <div class="modal-buttons" id="crudFormButtons2">
                        <!-- edit or delete -->
                        @if(temPermissao('homologacao_solicitacoes_edit'))
                        <!-- Botão Alterar Registro -->
                        <x-button-crud op="2" onclick="crudEdit(0)" id="crudFormButtons2Edit" />
                        @endif

                        @if(temPermissao('homologacao_solicitacoes_destroy'))
                        <!-- Botão Excluir Registro -->
                        <x-button-crud op="3" onclick="crudDelete(0);" id="crudFormButtons2Delete" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" id="crudFormButtons2CancelOperation" />
                    </div>

                    <!-- Formulário - Form -->
                    <form id="{{ session('crudNameFormSubmodulo') }}" name="{{ session('crudNameFormSubmodulo') }}" enctype="multipart/form-data">
                        <fieldset>
                            <input type="hidden" id="frm_operacao" name="frm_operacao" />
                            <input type="hidden" id="registro_id" name="registro_id" />

                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-clipboard text-start"></i>- <b>Solicitação</b></div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Submódulo</label>
                                    <select class="form-control" name="submodulo_id" id="submodulo_id">
                                        <option value="">Selecione...</option>

                                        @foreach ($submodulos as $submodulo)
                                        <option value="{{ $submodulo['id'] }}">{{ $submodulo['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Tipo</label>
                                    <select class="form-control" name="solicitacao_tipo" id="solicitacao_tipo" required="required">
                                        <option value="Correção">Correção</option>
                                        <option value="Ajuste">Ajuste</option>
                                        <option value="Melhoria">Melhoria</option>
                                        <option value="Nova Funcionalidade">Nova Funcionalidade</option>
                                        <option value="Dúvida">Dúvida</option>
                                        <option value="Sugestão">Sugestão</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Prioridade</label>
                                    <select class="form-control" name="solicitacao_prioridade" id="solicitacao_prioridade" required="required">
                                        <option value="Baixa">Baixa</option>
                                        <option value="Normal">Normal</option>
                                        <option value="Alta">Alta</option>
                                        <option value="Urgente">Urgente</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-12 pb-3">
                                    <label class="form-label">Solicitação</label>
                                    <textarea class="form-control" id="solicitacao" name="solicitacao" rows="3" required="required"></textarea>
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3 d-none" id="div_cp_solicitacao_data">
                                    <label class="form-label">Solicitação Data</label>
                                    <input type="text" class="form-control mask_date" id="solicitacao_data" name="solicitacao_data">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3 d-none" id="div_cp_solicitacao_hora">
                                    <label class="form-label">Solicitação Hora</label>
                                    <input type="text" class="form-control" id="solicitacao_hora" name="solicitacao_hora">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3 d-none" id="div_cp_user_id">
                                    <label class="form-label">Usuário Solicitante</label>
                                    <select class="form-control" name="user_id" id="user_id">
                                        <option value="">Selecione...</option>

                                        @foreach ($users as $user)
                                        <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-12 pb-3" id="solicitacao_imagem_salva_container_file">
                                    <label class="form-label">Imagem do erro (opcional)</label>
                                    <input type="file" class="form-control" id="solicitacao_imagem_file" name="solicitacao_imagem_file" accept="image/jpeg,image/png,image/webp">
                                </div>
                                <div class="form-group col-12 col-md-12 d-none pb-3" id="solicitacao_imagem_salva_container_visualizacao">
                                    <label class="form-label">Imagem anexada à solicitação</label>
                                    <div class="col-12">
                                        <img id="solicitacao_imagem_salva" class="img-thumbnail" style="max-width: 100%; max-height: 500px">
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-4 d-none" id="div_resposta">
                                <div class="font-size-16 pb-4"><i class="fas fa-clipboard-check text-start"></i>- <b>Resposta</b></div>
                                <div class="form-group col-12 col-md-12 pb-3">
                                    <label class="form-label">Resposta</label>
                                    <textarea class="form-control" id="resposta" name="resposta" rows="2"></textarea>
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" name="resposta_status" id="resposta_status" required="required">
                                        <option value="Em Análise">Em Análise</option>
                                        <option value="Em Desenvolvimento">Em Desenvolvimento</option>
                                        <option value="Aguardando Validação">Aguardando Validação</option>
                                        <option value="Concluído">Concluído</option>
                                        <option value="Não Realizado">Não Realizado</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3" id="div_cp_resposta_data">
                                    <label class="form-label">Resposta Data</label>
                                    <input type="text" class="form-control mask_date" id="resposta_data" name="resposta_data">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3" id="div_cp_resposta_hora">
                                    <label class="form-label">Resposta Hora</label>
                                    <input type="text" class="form-control" id="resposta_hora" name="resposta_hora">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
