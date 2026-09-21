<!-- Formulario -->
<div class="font-size-12" id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">
                        <!-- store or update -->
                        @if(temPermissao('militares_create') || temPermissao('militares_edit'))
                        <!-- Botão Confirnar Operação -->
                        <x-button-crud op="5" onclick="crudConfirmOperation();" id="crudFormButtons1ConfirmOperation" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" id="crudFormButtons1CancelOperation" />
                    </div>
                    <div class="modal-buttons" id="crudFormButtons2">
                        <!-- edit or delete -->
                        @if(temPermissao('militares_edit'))
                        <!-- Botão Alterar Registro -->
                        <x-button-crud op="2" onclick="crudEdit(0)" id="crudFormButtons2Edit" />
                        @endif

                        @if(temPermissao('militares_destroy'))
                        <!-- Botão Excluir Registro -->
                        <x-button-crud op="3" onclick="crudDelete(0);" id="crudFormButtons2Delete" />
                        @endif

                        <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" id="crudFormButtons2CancelOperation" />
                    </div>

                    <!-- Formulário - Form -->
                    <form id="{{ session('crudNameFormSubmodulo') }}" name="{{ session('crudNameFormSubmodulo') }}">
                        <fieldset>
                            <input type="hidden" id="frm_operacao" name="frm_operacao">
                            <input type="hidden" id="registro_id" name="registro_id">

                            <input type="hiddenx" id="militarSituacaoId" name="militarSituacaoId" value="0" />
                            <input type="hiddenx" id="militarSituacaoId_token" name="militarSituacaoId_token" value="xxxyyyzzz" />

                            <button type="button" onclick="preenchimento_teste();">Dados Teste</button>

                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fa-info text-start"></i>- <b>Informações Gerais</b></div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">RG</label>
                                    <input type="text" class="form-control text-uppercase mask_rg" id="rg" name="rg" required="required">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Id. Funcional</label>
                                    <input type="text" class="form-control text-uppercase" id="identidade_funcional" name="identidade_funcional" required="required">
                                </div>
                                <div class="form-group col-12 col-md-1 pb-3">
                                    <label class="form-label">Vínculo</label>
                                    <input type="text" class="form-control text-uppercase" id="vinculo" name="vinculo" required="required">
                                </div>
                                <div class="form-group col-12 col-md-5 pb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control text-uppercase" id="nome" name="nome" required="required">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Nome de Guerra</label>
                                    <input type="text" class="form-control text-uppercase" id="nome_guerra" name="nome_guerra" required="required">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Situação</label>
                                    <select class="form-control" name="situacao_id" id="situacao_id" required="required">
                                        <option value="">Selecione...</option>

                                        @foreach ($situacoes as $situacao)
                                        <option value="{{ $situacao['id'] }}">{{ $situacao['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Boletim Situação</label>
                                    <input type="text" class="form-control text-uppercase mask_boletim" id="boletim_situacao" name="boletim_situacao">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Quadro</label>
                                    <select class="form-control" name="quadro_id" id="quadro_id" required="required">
                                        <option value="">Selecione...</option>

                                        @foreach ($quadros as $quadro)
                                            <option value="{{ $quadro['id'] }}">{{ $quadro['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Boletim Quadro</label>
                                    <input type="text" class="form-control text-uppercase mask_boletim" id="boletim_quadro" name="boletim_quadro">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Posto/Graduação</label>
                                    <select class="form-control" name="graduacao_id" id="graduacao_id" required="required">
                                        <option value="">Selecione...</option>

                                        @foreach ($graduacoes as $graduacao)
                                            <option value="{{ $graduacao['id'] }}">{{ $graduacao['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Boletim Promoção</label>
                                    <input type="text" class="form-control text-uppercase mask_boletim" id="boletim_graduacao" name="boletim_graduacao">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Data Ingresso</label>
                                    <input type="text" class="form-control mask_date" id="data_ingresso" name="data_ingresso" required="required">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Boletim Ingresso</label>
                                    <input type="text" class="form-control text-uppercase mask_boletim" id="boletim_ingresso" name="boletim_ingresso">
                                </div>
                                <div class="form-group col-12 col-md-9 pb-3">
                                    <label class="form-label">Unidade</label>
                                    <select class="form-control" name="unidade_id" id="unidade_id" required="required">
                                        <option value="">Selecione...</option>

                                        @foreach ($unidades as $unidade)
                                            <option value="{{ $unidade['id'] }}">{{ $unidade['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Boletim Movimentação</label>
                                    <input type="text" class="form-control text-uppercase mask_boletim" id="boletim_movimentacao" name="boletim_movimentacao">
                                </div>
                                <div class="form-group col-12 col-md-9 pb-3">
                                    <label class="form-label">Prestando Serviço</label>
                                    <select class="form-control" name="prestando_servico_id" id="prestando_servico_id" required="required">
                                        <option value="">Selecione...</option>

                                        @foreach ($prestando_servicos as $prestando_servico)
                                            <option value="{{ $prestando_servico['id'] }}">{{ $prestando_servico['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Boletim Prestando Serviço</label>
                                    <input type="text" class="form-control text-uppercase mask_boletim" id="boletim_prestando_servico" name="boletim_prestando_servico">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Função</label>
                                    <select class="form-control" name="funcao_id" id="funcao_id">
                                        <option value="">Selecione...</option>

                                        @foreach ($funcoes as $funcao)
                                            <option value="{{ $funcao['id'] }}">{{ $funcao['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Boletim Função</label>
                                    <input type="text" class="form-control text-uppercase mask_boletim" id="boletim_funcao" name="boletim_funcao">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Data Segunda Praça</label>
                                    <input type="text" class="form-control mask_date" id="data_segunda_praca" name="data_segunda_praca">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Boletim Segunda Praça</label>
                                    <input type="text" class="form-control text-uppercase mask_boletim" id="boletim_segunda_praca" name="boletim_segunda_praca">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Comportamento</label>
                                    <select class="form-control" name="comportamento_id" id="comportamento_id">
                                        <option value="">Selecione...</option>

                                        @foreach ($comportamentos as $comportamento)
                                            <option value="{{ $comportamento['id'] }}">{{ $comportamento['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Boletim Comportamento</label>
                                    <input type="text" class="form-control text-uppercase mask_boletim" id="boletim_comportamento" name="boletim_comportamento">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Data Nascimento</label>
                                    <input type="text" class="form-control mask_date" id="data_nascimento" name="data_nascimento" required="required">
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Estado Civil</label>
                                    <select class="form-control" name="estado_civil_id" id="estado_civil_id">
                                        <option value="">Selecione...</option>

                                        @foreach ($estados_civis as $estado_civil)
                                            <option value="{{ $estado_civil['id'] }}">{{ $estado_civil['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Tipo Sanguíneo</label>
                                    <select class="form-control" name="tipo_sanguineo_id" id="tipo_sanguineo_id">
                                        <option value="">Selecione...</option>

                                        @foreach ($tipos_sanguineos as $tipo_sanguineo)
                                            <option value="{{ $tipo_sanguineo['id'] }}">{{ $tipo_sanguineo['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Fator RH</label>
                                    <select class="form-control" name="fator_rh_id" id="fator_rh_id">
                                        <option value="">Selecione...</option>

                                        @foreach ($fatores_rh as $fator_rh)
                                            <option value="{{ $fator_rh['id'] }}">{{ $fator_rh['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Sexo Biológico</label>
                                    <select class="form-control" name="sexo_biologico_id" id="sexo_biologico_id">
                                        <option value="">Selecione...</option>

                                        @foreach ($sexos_biologicos as $sexo_biologico)
                                            <option value="{{ $sexo_biologico['id'] }}">{{ $sexo_biologico['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Gênero</label>
                                    <select class="form-control" name="genero_id" id="genero_id">
                                        <option value="">Selecione...</option>

                                        @foreach ($generos as $genero)
                                            <option value="{{ $genero['id'] }}">{{ $genero['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Nacionalidade</label>
                                    <select class="form-control" name="nacionalidade_id" id="nacionalidade_id">
                                        <option value="">Selecione...</option>

                                        @foreach ($nacionalidades as $nacionalidade)
                                            <option value="{{ $nacionalidade['id'] }}">{{ $nacionalidade['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-3 pb-3">
                                    <label class="form-label">Naturalidade</label>
                                    <select class="form-control" name="naturalidade_id" id="naturalidade_id">
                                        <option value="">Selecione...</option>

                                        @foreach ($naturalidades as $naturalidade)
                                            <option value="{{ $naturalidade['id'] }}">{{ $naturalidade['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-4 pb-3">
                                    <label class="form-label">Escolaridade</label>
                                    <select class="form-control" name="escolaridade_id" id="escolaridade_id">
                                        <option value="">Selecione...</option>

                                        @foreach ($escolaridades as $escolaridade)
                                            <option value="{{ $escolaridade['id'] }}">{{ $escolaridade['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Banco</label>
                                    <select class="form-control" name="banco_id" id="banco_id">
                                        <option value="">Selecione...</option>

                                        @foreach ($bancos as $banco)
                                            <option value="{{ $banco['id'] }}">{{ $banco['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Agência</label>
                                    <input type="text" class="form-control text-uppercase" id="agencia" name="agencia">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Conta Corrente</label>
                                    <input type="text" class="form-control text-uppercase" id="conta_corrente" name="conta_corrente">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">CPF</label>
                                    <input type="text" class="form-control mask_cpf text-uppercase" id="cpf" name="cpf" required="required">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">PASEP</label>
                                    <input type="text" class="form-control mask_pasep text-uppercase" id="pasep" name="pasep">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Título Eleitor</label>
                                    <input type="text" class="form-control mask_titulo_eleitor text-uppercase" id="titulo_eleitoral" name="titulo_eleitoral">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Título Zona</label>
                                    <input type="text" class="form-control text-uppercase" id="titulo_eleitoral_zona" name="titulo_eleitoral_zona">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Título Seção</label>
                                    <input type="text" class="form-control text-uppercase" id="titulo_eleitoral_secao" name="titulo_eleitoral_secao">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Certificado Reservista</label>
                                    <input type="text" class="form-control text-uppercase" id="certificado_reservista" name="certificado_reservista">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Certificado Série</label>
                                    <input type="text" class="form-control text-uppercase" id="certificado_reservista_serie" name="certificado_reservista_serie">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Certificado Categoria</label>
                                    <input type="text" class="form-control text-uppercase" id="certificado_reservista_categoria" name="certificado_reservista_categoria">
                                </div>
                                <div class="form-group col-12 col-md-2 pb-3">
                                    <label class="form-label">Temporário</label>
                                    <select class="form-control" name="temporario" id="temporario">
                                        <option value="">Selecione...</option>
                                        <option value="0">Não</option>
                                        <option value="1">Sim</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-6 pb-3">
                                    <label class="form-label">Pai</label>
                                    <input type="text" class="form-control text-uppercase" id="pai" name="pai">
                                </div>
                                <div class="form-group col-12 col-md-6 pb-3">
                                    <label class="form-label">Mãe</label>
                                    <input type="text" class="form-control text-uppercase" id="mae" name="mae">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
