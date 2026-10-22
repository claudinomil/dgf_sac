<!-- Formulario -->
<div class="font-size-12" id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">
                        <!-- store or update -->
                        @if(temPermissao('militares_fundos_saude_create') || temPermissao('militares_fundos_saude_edit'))
                        <!-- Botão Confirnar Operação -->
                        <x-button-crud op="5" onclick="crudConfirmOperation();" id="crudFormButtons1ConfirmOperation" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" id="crudFormButtons1CancelOperation" />
                    </div>
                    <div class="modal-buttons" id="crudFormButtons2">
                        <!-- edit -->
                        @if(temPermissao('militares_fundos_saude_edit'))
                        <!-- Botão Alterar Registro -->
                        <x-button-crud op="2" onclick="crudEdit(0)" id="crudFormButtons2Edit" />
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
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Cancelar Desconto</label>
                                    <select class="form-control" name="cancelar_desconto" id="cancelar_desconto" required="required">
                                        <option value="">Selecione...</option>
                                        <option value="0">NÃO</option>
                                        <option value="1">SIM</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Acesso Sistema Saúde</label>
                                    <select class="form-control" name="acesso_sistema_saude" id="acesso_sistema_saude" required="required">
                                        <option value="">Selecione...</option>
                                        <option value="0">NÃO</option>
                                        <option value="1">SIM</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-8 pb-3">
                                    <label class="form-label">Acesso Sistema Saúde Documento</label>
                                    <input type="text" class="form-control" id="acesso_sistema_saude_documento" name="acesso_sistema_saude_documento">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Data Documento</label>
                                    <input type="text" class="form-control mask_date" id="data_documento" name="data_documento">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Tipo Acesso</label>
                                    <select class="form-control" name="tipo_acesso" id="tipo_acesso" required="required">
                                        <option value="">Selecione...</option>
                                        <option value="0">NEGADO</option>
                                        <option value="1">INTEGRAL</option>
                                        <option value="2">AMBULATORIAL</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-8 pb-3">
                                    <label class="form-label">Tipo Acesso Motivo</label>
                                    <input type="text" class="form-control" id="tipo_acesso_motivo" name="tipo_acesso_motivo">
                                </div>
                            </div>
                            <div class="row pt-4" id="divMilitarDependentes">
                                <div class="font-size-16 pb-4"><i class="fas fa-table text-start"></i>- <b>Dependentes</b></div>


                                <div id="divTabelaDependentes"></div>


                                <!-- <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Parentesco</th>
                                                <th>Dependente</th>
                                                <th>Idade</th>
                                                <th>Acesso Sistema Saúde</th>
                                                <th>Tipo Acesso</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>@mdo</td>
                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>@mdo</td>
                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> -->





                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
