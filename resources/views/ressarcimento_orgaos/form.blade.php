<!-- Formulario -->
<div class="font-size-12" id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">
                        <!-- store or update -->
                        @if(temPermissao('ressarcimento_referencias_edit'))
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
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">CNPJ</label>
                                    <input type="text" class="form-control mask_cnpj" id="cnpj" name="cnpj">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">UG</label>
                                    <input type="text" class="form-control" id="ug" name="ug">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control text-uppercase" id="name" name="name" required="required">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Responsável</label>
                                    <input type="text" class="form-control text-uppercase" id="responsavel" name="responsavel">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Esfera</label>
                                    <select class="select2 form-control" name="esfera_id" id="esfera_id" required="required">
                                        <option value="">Selecione...</option>

                                        @foreach ($esferas as $esfera)
                                            <option value="{{ $esfera['id'] }}">{{ $esfera['name'] }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Poder</label>
                                    <select class="select2 form-control" name="poder_id" id="poder_id" required="required">
                                        <option value="">Selecione...</option>

                                        @foreach ($poderes as $poder)
                                            <option value="{{ $poder['id'] }}">{{ $poder['name'] }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Tratamento</label>
                                    <select class="select2 form-control" name="tratamento_id" id="tratamento_id" required="required">
                                        <option value="">Selecione...</option>

                                        @foreach ($tratamentos as $tratamento)
                                            <option value="{{ $tratamento['id'] }}">{{ $tratamento['completo'] }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Vocativo</label>
                                    <select class="select2 form-control" name="vocativo_id" id="vocativo_id" required="required">
                                        <option value="">Selecione...</option>

                                        @foreach ($vocativos as $vocativo)
                                            <option value="{{ $vocativo['id'] }}">{{ $vocativo['name'] }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Função</label>
                                    <select class="select2 form-control" name="ressarcimento_funcao_id" id="ressarcimento_funcao_id" required="required">
                                        <option value="">Selecione...</option>

                                        @foreach ($ressarcimento_funcoes as $ressarcimento_funcao)
                                            <option value="{{ $ressarcimento_funcao['id'] }}">{{ $ressarcimento_funcao['name'] }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Telefone 1</label>
                                    <input type="text" class="form-control mask_phone_with_ddd" id="telefone_1" name="telefone_1">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Telefone 2</label>
                                    <input type="text" class="form-control mask_phone_with_ddd" id="telefone_2" name="telefone_2">
                                </div>
                            </div>

                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-house-user text-start"></i>- <b>Endereço</b></div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">CEP</label>
                                    <input type="text" class="form-control mask_cep" id="cep" name="cep" onblur="pesquisacep(this.value);">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Número</label>
                                    <input type="text" class="form-control" id="numero" name="numero">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Complemento</label>
                                    <input type="text" class="form-control text-uppercase" id="complemento" name="complemento">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Logradouro</label>
                                    <input type="text" class="form-control text-uppercase" id="logradouro" name="logradouro" readonly="readonly">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Bairro</label>
                                    <input type="text" class="form-control text-uppercase" id="bairro" name="bairro" readonly="readonly">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Localidade</label>
                                    <input type="text" class="form-control text-uppercase" id="localidade" name="localidade" readonly="readonly">
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">UF</label>
                                    <input type="text" class="form-control text-uppercase" id="uf" name="uf" readonly="readonly">
                                </div>
                            </div>
                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-file-contract text-start"></i>- <b>Contato</b></div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control text-uppercase" id="contato_nome" name="contato_nome">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Telefone</label>
                                    <input type="text" class="form-control mask_phone_with_ddd" id="contato_telefone" name="contato_telefone">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Celular</label>
                                    <input type="text" class="form-control mask_cell_with_ddd" id="contato_celular" name="contato_celular">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">E-mail</label>
                                    <input type="email" class="form-control text-lowercase" id="contato_email" name="contato_email">
                                </div>
                            </div>
                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-reply text-start"></i>- <b>Lotação (Referência na DGP)</b></div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">ID</label>
                                    <input type="text" class="form-control text-uppercase" id="lotacao_id" name="lotacao_id" readonly>
                                </div>
                                <div class="form-group col-12 col-md-10 pb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control text-uppercase" id="lotacao" name="lotacao" readonly>
                                </div>
                            </div>
                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-money-check text-start"></i>- <b>Cobrança</b></div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Realizar Cobrança</label>
                                    <select class="select2 form-control" name="cobranca_realizar" id="cobranca_realizar" required="required">
                                        <option value="">Selecione...</option>
                                        <option value="1">Cobrar</option>
                                        <option value="2">não Cobrar</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Orgão Principal</label>
                                    <select class="select2 form-control" name="cobranca_ressarcimento_orgao_id" id="cobranca_ressarcimento_orgao_id">
                                        <option value="">Selecione...</option>

                                        @foreach ($ressarcimento_orgaos as $ressarcimento_orgao)
                                            <option value="{{ $ressarcimento_orgao['id'] }}">{{ $ressarcimento_orgao['name'] }}</option>
                                        @endforeach
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
