<!-- Formulario -->
<div class="font-size-12" id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">&nbsp;</div>
                    <div class="modal-buttons" id="crudFormButtons2">
                        <!-- delete -->
                        @if(temPermissao('ressarcimento_militares_destroy'))
                        <!-- Botão Excluir Registro -->
                        <x-button-crud op="3" onclick="crudDelete(0);" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" />
                    </div>

                    <!-- Formulário - Form -->
                    <form id="{{ session('crudNameFormSubmodulo') }}" name="{{ session('crudNameFormSubmodulo') }}" enctype="multipart/form-data">
                        <fieldset>
                            <input type="hidden" id="frm_operacao" name="frm_operacao">
                            <input type="hidden" id="registro_id" name="registro_id">

                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-info text-start"></i>- <b>Informações Gerais</b></div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Referência</label>
                                    <input type="text" class="form-control text-uppercase" id="referencia" name="referencia">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Identidade Funcional</label>
                                    <input type="text" class="form-control text-uppercase" id="identidade_funcional" name="identidade_funcional">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">RG</label>
                                    <input type="text" class="form-control text-uppercase" id="rg" name="rg">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control text-uppercase" id="nome" name="nome">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Posto Graduação</label>
                                    <input type="text" class="form-control text-uppercase" id="posto_graduacao" name="posto_graduacao">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Quadro/QBMP</label>
                                    <input type="text" class="form-control text-uppercase" id="quadro_qbmp" name="quadro_qbmp">
                                </div>
                                <div class="form-group col-12 col-md-9 pb-3">
                                    <label class="form-label">Lotação</label>
                                    <input type="text" class="form-control text-uppercase" id="lotacao" name="lotacao">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Boletim</label>
                                    <input type="text" class="form-control text-uppercase" id="boletim" name="boletim">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para importação do militares -->
<div class="modal fade modal-importar-militares" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Importar Militares</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="frm_importar_ressarcimento_militar">
                    @csrf
                    @method('POST')

                    <div class="mb-3">
                        <label class="form-label small">Referência</label>
                        <select class="form-select form-select-sm" name="ressarcimento_militar_referencia" id="ressarcimento_militar_referencia" required>
                            <option value="">Selecione...</option>

                            @foreach ($referencias as $referencia)
                                <option value="{{ $referencia }}">{{ getReferencia(1, $referencia) }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Arquivo</label>
                        <div class="input-group">
                            <input type="file" class="form-control form-control-sm" name="ressarcimento_militar_file" id="ressarcimento_militar_file">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-12 text-end" id="modal-importar-militares-footer-1">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-primary" id="btnConfirmarImportacaoMilitar">Confirmar Importação</button>
                </div>
                <div class="col-12 text-center" id="modal-importar-militares-footer-2" style="display: none;">
                    <i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i> Processando...
                </div>
            </div>
        </div>
    </div>
</div>
