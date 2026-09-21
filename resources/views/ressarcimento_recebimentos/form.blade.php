<!-- Formulario -->
<div class="font-size-12" id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">
                        <!-- update -->
                        @if(temPermissao('ressarcimento_recebimentos_edit'))
                        <!-- Botão Confirnar Operação -->
                        <button type="button" class="btn btn-sm btn-success text-white mb-2 font-size-12" data-bs-toggle="tooltip" data-bs-placement="top" title="Confirmar Operação" id="re_btn_alterar_registros_confirmar_update"><i class="fa fa-save label-icon"></i> Confirmar</button>
                        @endif

                         <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" />
                    </div>
                    <div class="modal-buttons" id="crudFormButtons2">
                        <!-- edit -->
                        @if(temPermissao('ressarcimento_recebimentos_edit'))
                        <!-- Botão Alterar Registro -->
                        <x-button-crud op="2" onclick="crudEdit(0)" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" />
                    </div>

                    <!-- Formulário - Form -->
                    <form id="{{ session('crudNameFormSubmodulo') }}" name="{{ session('crudNameFormSubmodulo') }}">
                        @csrf

                        <fieldset>
                            <input type="hidden" id="frm_operacao" name="frm_operacao">
                            <input type="hidden" id="registro_id" name="registro_id">

                            <input type="hidden" id="grade_recebimentos_referencia" name="grade_recebimentos_referencia">
                            <input type="hidden" id="grade_recebimentos_orgao_id" name="grade_recebimentos_orgao_id">

                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-info text-start"></i>- <b>Informações Gerais</b></div>
                                <div class="pb-4" id="gradeRecebimentosTitulo"></div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Valor total a receber</label>
                                    <input type="text" class="form-control form-control-sm mask_money" id="valor_a_receber_orgao" name="valor_a_receber_orgao" required="required" readonly>
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Valor total recebido</label>
                                    <input type="text" class="form-control form-control-sm mask_money" id="valor_recebido_orgao" name="valor_recebido_orgao" required="required">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Operações</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-sm btn-info float-end" id="valor_recebido_orgao_op_1" data-bs-toggle="tooltip" data-bs-placement="top" title="Dividir Valor Total Recebido Integralmente"><i class="fas fa-divide"></i></button>
                                        <button type="button" class="btn btn-sm btn-success float-end" id="valor_recebido_orgao_op_2" data-bs-toggle="tooltip" data-bs-placement="top" title="Dividir Valor Total Recebido Distribuído"><i class="fas fa-align-center"></i></button>
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Data recebimento</label>
                                    <input type="text" class="form-control form-control-sm mask_date" id="data_recebimento" name="data_recebimento" required="required">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Guia Recolhimento</label>
                                    <input type="text" class="form-control form-control-sm" id="guia_recolhimento" name="guia_recolhimento">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Documento</label>
                                    <input type="text" class="form-control form-control-sm" id="documento" name="documento">
                                </div>

                                <div class="table-responsive">
                                    <table class="table align-middle table-hover font-size-11" id="gradeRecebimentosTable">
                                        <thead class="table-light" id="gradeRecebimentosThead"></thead>
                                        <tbody id="gradeRecebimentosTbody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
