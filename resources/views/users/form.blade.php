<!-- Formulario -->
<div class="font-size-12" id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">
                        <!-- store or update -->
                        @if(temPermissao('users_create') || temPermissao('users_edit'))
                        <!-- Botão Confirnar Operação -->
                            <x-button-crud op="5" onclick="crudConfirmOperation();" />
                    @endif

                    <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" />
                    </div>
                    <div class="modal-buttons" id="crudFormButtons2">
                        <!-- edit or delete -->
                         @if(temPermissao('users_edit'))
                        <!-- Botão Alterar Registro -->
                            <x-button-crud op="2" onclick="crudEdit(0)" />
                    @endif

                    @if(temPermissao('users_destroy'))
                        <!-- Botão Excluir Registro -->
                            <x-button-crud op="3" onclick="crudDelete(0);" />
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
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Usuário</label>
                                    <input type="text" class="form-control" id="user" name="user" readonly>
                                </div>
                                <div class="form-group col-12 col-md-5 pb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control text-uppercase" id="name" name="name" required="required">
                                </div>
                                <div class="form-group col-12 col-md-5 pb-3">
                                    <label class="form-label">E-mail</label>
                                    <input type="text" class="form-control text-lowercase" id="email" name="email" required="required">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Usuário Situação</label>
                                    <select class="form-control" name="user_situacao_id" id="user_situacao_id">
                                        <option value="">Selecione...</option>

                                        @foreach ($userSituacoes as $userSituacao)
                                            <option value="{{ $userSituacao['id'] }}">{{ $userSituacao['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-5 pb-3">
                                    <label class="form-label">Grupo</label>
                                    <select class="form-control" name="grupo_id" id="grupo_id">
                                        <option value="">Selecione...</option>

                                        @foreach ($grupos as $grupo)
                                            <option value="{{ $grupo['id'] }}">{{ $grupo['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Menu</label>
                                    <select class="form-control" name="layout_menu" id="layout_menu">
                                        <option value="">Selecione...</option>
                                        <option value="1">Vertical</option>
                                        <option value="2">Horizontal</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Usuário Tipo</label>
                                    <select class="form-control" name="user_tipo_id" id="user_tipo_id">
                                        <option value="">Selecione...</option>

                                        @foreach ($userTipos as $userTipo)
                                            <option value="{{ $userTipo['id'] }}">{{ $userTipo['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row pt-4" id="divReferenciaMilitar">
                                <div class="font-size-16 pb-4"><i class="fas fa-person-military-to-person"></i> - <b>Referência Militar</b></div>
                                <div class="form-group col-12 col-md-12 pb-3" id="divPesquisarMilitar" style="display: none;">
                                    <label class="form-label">Nome / RG / Id. Funcional</label>
                                    <input type="hidden" id="militar_id" name="militar_id">
                                    <input type="text" class="form-control" id="pesquisar_militar" name="pesquisar_militar">
                                    <div id="autocomplete_militar" class="list-group position-absolute col-12 col-md-8" style="z-index:999;"></div>
                                </div>
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
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
