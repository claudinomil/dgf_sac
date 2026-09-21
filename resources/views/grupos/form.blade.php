<!-- Formulario -->
<div class="font-size-12" id="crudForm" style="display: none;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="modal-buttons" id="crudFormButtons1">
                        <!-- store or update -->
                        @if(temPermissao('grupos_create') || temPermissao('grupos_edit'))
                        <!-- Botão Confirnar Operação -->
                         <x-button-crud op="5" onclick="crudConfirmOperation();" />
                         @endif

                         <!-- Botão Cancelar Operação -->
                        <x-button-crud op="4" onclick="crudCancelOperation();" />
                    </div>
                    <div class="modal-buttons" id="crudFormButtons2">
                        <!-- edit or delete -->
                        @if(temPermissao('grupos_edit'))
                        <!-- Botão Alterar Registro -->
                        <x-button-crud op="2" onclick="crudEdit(0)" />
                        @endif

                        @if(temPermissao('grupos_destroy'))
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
                                <div class="form-group col-12 col-md-12 pb-3">
                                    <label class="form-label">Nome</label>
                                    <input type="text" class="form-control text-uppercase" id="name" name="name" required="required">
                                </div>
                            </div>
                            <div class="row pt-4">
                                <div class="font-size-16 pb-4"><i class="fas fas fa-key text-start"></i>- <b>Permissões</b></div>
                                <div class="form-group col-12 col-md-12 pb-3">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Submódulo</th>
                                                <th>
                                                    <div class="form-check form-checkbox-outline form-check-primary">
                                                        <input class="form-check-input" type="checkbox" id="all_list" name="all_list" onchange="checkedPermissaoTable('all_list');">
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="form-check form-checkbox-outline form-check-info">
                                                        <input class="form-check-input" type="checkbox" id="all_show" name="all_show" onchange="checkedPermissaoTable('all_show');">
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="form-check form-checkbox-outline form-check-success">
                                                        <input class="form-check-input" type="checkbox" id="all_create" name="all_create" onchange="checkedPermissaoTable('all_create');">
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="form-check form-checkbox-outline form-check-warning">
                                                        <input class="form-check-input" type="checkbox" id="all_edit" name="all_edit" onchange="checkedPermissaoTable('all_edit');">
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="form-check form-checkbox-outline form-check-danger">
                                                        <input class="form-check-input" type="checkbox" id="all_destroy" name="all_destroy" onchange="checkedPermissaoTable('all_destroy');">
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($submodulos as $submodulo)
                                            <tr>
                                                <td>{{ $submodulo['name'] }}</td>
                                                <td class="text-center">
                                                    <div class="form-check form-checkbox-outline form-check-primary">
                                                        @php($permissao_id = $permissoes->firstWhere('name', $submodulo['prefix_permissao'].'_list')?->id)
                                                        @if(isset($permissao_id))
                                                        <input class="form-check-input check_list" type="checkbox" id="{{ $submodulo['prefix_permissao'] }}_list" name="permissoes[]" value="{{ $permissao_id }}" onchange="checkedPermissaoTable('list', `{{$submodulo['prefix_permissao']}}`);">
                                                        <label class="form-check-label" for="{{ $submodulo['prefix_permissao'] }}_list">Listar</label>
                                                        @endif
                                                    </div>

                                                    @if(in_array($submodulo['prefix_permissao'], ['militares', 'militares_cursos', 'militares_contatos', 'militares_ajudas_custos', 'militares_auxilios_fardamentos', 'militares_dependentes', 'militares_fundos_saude']))
                                                    <input type="hidden" id="{{ $submodulo['prefix_permissao'] }}_permissoes_list_situacoes_ids" name="{{ $submodulo['prefix_permissao'] }}_permissoes_list_situacoes_ids">

                                                    <div class="text-start pt-2">
                                                        <div class="text-success pb-2">Militares (Situações Permitidas)</div>
                                                        @foreach ($situacoes as $situacao)
                                                        <div class="form-check form-checkbox-outline form-check-success">
                                                            <input class="form-check-input" type="checkbox" id="{{ $submodulo['prefix_permissao'].'_list_situacao_id_'.$situacao['id'] }}" name="{{ $submodulo['prefix_permissao'].'_list_situacao_id_'.$situacao['id'] }}" value="{{ $situacao['id'] }}" onclick="montarCamposPermissoesSituacoesIds('{{ $submodulo['prefix_permissao'] }}', 'list')">
                                                            <label class="form-check-label" for="{{ $submodulo['prefix_permissao'].'_list_situacao_id_'.$situacao['id'] }}">{{ primeiraMaiuscula($situacao['name']) }}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-checkbox-outline form-check-info">
                                                        @php($permissao_id = $permissoes->firstWhere('name', $submodulo['prefix_permissao'].'_show')?->id)
                                                        @if(isset($permissao_id))
                                                        <input class="form-check-input check_show" type="checkbox" id="{{ $submodulo['prefix_permissao'] }}_show" name="permissoes[]" value="{{ $permissao_id }}" onchange="checkedPermissaoTable('show', `{{$submodulo['prefix_permissao']}}`);">
                                                        <label class="form-check-label" for="{{ $submodulo['prefix_permissao'] }}_show">Mostrar</label>
                                                        @endif
                                                    </div>

                                                    @if(in_array($submodulo['prefix_permissao'], ['militares', 'militares_cursos', 'militares_contatos', 'militares_ajudas_custos', 'militares_auxilios_fardamentos', 'militares_dependentes', 'militares_fundos_saude']))
                                                    <input type="hidden" id="{{ $submodulo['prefix_permissao'] }}_permissoes_show_situacoes_ids" name="{{ $submodulo['prefix_permissao'] }}_permissoes_show_situacoes_ids">

                                                    <div class="text-start pt-2">
                                                        <div class="text-success pb-2">Militares (Situações Permitidas)</div>
                                                        @foreach ($situacoes as $situacao)
                                                        <div class="form-check form-checkbox-outline form-check-success">
                                                            <input class="form-check-input" type="checkbox" id="{{ $submodulo['prefix_permissao'].'_show_situacao_id_'.$situacao['id'] }}" name="{{ $submodulo['prefix_permissao'].'_show_situacao_id_'.$situacao['id'] }}" value="{{ $situacao['id'] }}" onclick="montarCamposPermissoesSituacoesIds('{{ $submodulo['prefix_permissao'] }}', 'show')">
                                                            <label class="form-check-label" for="{{ $submodulo['prefix_permissao'].'_show_situacao_id_'.$situacao['id'] }}">{{ primeiraMaiuscula($situacao['name']) }}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-checkbox-outline form-check-success">
                                                        @php($permissao_id = $permissoes->firstWhere('name', $submodulo['prefix_permissao'].'_create')?->id)
                                                        @if(isset($permissao_id))
                                                        <input class="form-check-input check_create" type="checkbox" id="{{ $submodulo['prefix_permissao'] }}_create" name="permissoes[]" value="{{ $permissao_id }}" onchange="checkedPermissaoTable('create', `{{$submodulo['prefix_permissao']}}`);">
                                                        <label class="form-check-label" for="{{ $submodulo['prefix_permissao'] }}_create">Criar</label>
                                                        @endif
                                                    </div>

                                                    @if(in_array($submodulo['prefix_permissao'], ['militares', 'militares_cursos', 'militares_contatos', 'militares_ajudas_custos', 'militares_auxilios_fardamentos', 'militares_dependentes', 'militares_fundos_saude']))
                                                    <input type="hidden" id="{{ $submodulo['prefix_permissao'] }}_permissoes_create_situacoes_ids" name="{{ $submodulo['prefix_permissao'] }}_permissoes_create_situacoes_ids">

                                                    <div class="text-start pt-2">
                                                        <div class="text-success pb-2">Militares (Situações Permitidas)</div>
                                                        @foreach ($situacoes as $situacao)
                                                        <div class="form-check form-checkbox-outline form-check-success">
                                                            <input class="form-check-input" type="checkbox" id="{{ $submodulo['prefix_permissao'].'_create_situacao_id_'.$situacao['id'] }}" name="{{ $submodulo['prefix_permissao'].'_create_situacao_id_'.$situacao['id'] }}" value="{{ $situacao['id'] }}" onclick="montarCamposPermissoesSituacoesIds('{{ $submodulo['prefix_permissao'] }}', 'create')">
                                                            <label class="form-check-label" for="{{ $submodulo['prefix_permissao'].'_create_situacao_id_'.$situacao['id'] }}">{{ primeiraMaiuscula($situacao['name']) }}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-checkbox-outline form-check-warning">
                                                        @php($permissao_id = $permissoes->firstWhere('name', $submodulo['prefix_permissao'].'_edit')?->id)
                                                        @if(isset($permissao_id))
                                                        <input class="form-check-input check_edit" type="checkbox" id="{{ $submodulo['prefix_permissao'] }}_edit" name="permissoes[]" value="{{ $permissao_id }}" onchange="checkedPermissaoTable('edit', `{{$submodulo['prefix_permissao']}}`);">
                                                        <label class="form-check-label" for="{{ $submodulo['prefix_permissao'] }}_edit">Editar</label>
                                                        @endif
                                                    </div>

                                                    @if(in_array($submodulo['prefix_permissao'], ['militares', 'militares_cursos', 'militares_contatos', 'militares_ajudas_custos', 'militares_auxilios_fardamentos', 'militares_dependentes', 'militares_fundos_saude']))
                                                    <input type="hidden" id="{{ $submodulo['prefix_permissao'] }}_permissoes_edit_situacoes_ids" name="{{ $submodulo['prefix_permissao'] }}_permissoes_edit_situacoes_ids">

                                                    <div class="text-start pt-2">
                                                        <div class="text-success pb-2">Militares (Situações Permitidas)</div>
                                                        @foreach ($situacoes as $situacao)
                                                        <div class="form-check form-checkbox-outline form-check-success">
                                                            <input class="form-check-input" type="checkbox" id="{{ $submodulo['prefix_permissao'].'_edit_situacao_id_'.$situacao['id'] }}" name="{{ $submodulo['prefix_permissao'].'_edit_situacao_id_'.$situacao['id'] }}" value="{{ $situacao['id'] }}" onclick="montarCamposPermissoesSituacoesIds('{{ $submodulo['prefix_permissao'] }}', 'edit')">
                                                            <label class="form-check-label" for="{{ $submodulo['prefix_permissao'].'_edit_situacao_id_'.$situacao['id'] }}">{{ primeiraMaiuscula($situacao['name']) }}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-check form-checkbox-outline form-check-danger">
                                                        @php($permissao_id = $permissoes->firstWhere('name', $submodulo['prefix_permissao'].'_destroy')?->id)
                                                        @if(isset($permissao_id))
                                                        <input class="form-check-input check_destroy" type="checkbox" id="{{ $submodulo['prefix_permissao'] }}_destroy" name="permissoes[]" value="{{ $permissao_id }}" onchange="checkedPermissaoTable('destroy', `{{$submodulo['prefix_permissao']}}`);">
                                                        <label class="form-check-label" for="{{ $submodulo['prefix_permissao'] }}_destroy">Deletar</label>
                                                        @endif
                                                    </div>

                                                    @if(in_array($submodulo['prefix_permissao'], ['militares', 'militares_cursos', 'militares_contatos', 'militares_ajudas_custos', 'militares_auxilios_fardamentos', 'militares_dependentes', 'militares_fundos_saude']))
                                                    <input type="hidden" id="{{ $submodulo['prefix_permissao'] }}_permissoes_destroy_situacoes_ids" name="{{ $submodulo['prefix_permissao'] }}_permissoes_destroy_situacoes_ids">

                                                    <div class="text-start pt-2">
                                                        <div class="text-success pb-2">Militares (Situações Permitidas)</div>
                                                        @foreach ($situacoes as $situacao)
                                                        <div class="form-check form-checkbox-outline form-check-success">
                                                            <input class="form-check-input" type="checkbox" id="{{ $submodulo['prefix_permissao'].'_destroy_situacao_id_'.$situacao['id'] }}" name="{{ $submodulo['prefix_permissao'].'_destroy_situacao_id_'.$situacao['id'] }}" value="{{ $situacao['id'] }}" onclick="montarCamposPermissoesSituacoesIds('{{ $submodulo['prefix_permissao'] }}', 'destroy')">
                                                            <label class="form-check-label" for="{{ $submodulo['prefix_permissao'].'_destroy_situacao_id_'.$situacao['id'] }}">{{ primeiraMaiuscula($situacao['name']) }}</label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="row pt-4">
                                        <div class="font-size-16 pb-4"><i class="fas fas fa-list text-start"></i>- <b>Relatórios</b></div>
                                        <div class="row">
                                            @foreach ($relatorios as $relatorio)
                                            <div class="col-6">
                                                <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                    <input class="form-check-input" type="checkbox" id="relatorio_{{ $relatorio['relatorioId'] }}" name="relatorios[]" value="{{ $relatorio['relatorioId'] }}">
                                                    <label class="form-check-label" for="relatorio_{{ $relatorio['relatorioId'] }}">{{ primeiraMaiuscula($relatorio['relatorioGrupoName'].' - '.$relatorio['relatorioName']) }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="row pt-4">
                                        <div class="font-size-16 pb-4"><i class="fas fas fa-list text-start"></i>- <b>Gráficos</b></div>
                                        <div class="row">
                                            @foreach ($graficos as $grafico)
                                            <div class="col-6">
                                                <div class="form-check form-checkbox-outline form-check-primary mb-3">
                                                    <input class="form-check-input" type="checkbox" id="grafico_{{ $grafico['graficoId'] }}" name="graficos[]" value="{{ $grafico['graficoId'] }}">
                                                    <label class="form-check-label" for="grafico_{{ $grafico['graficoId'] }}">{{ primeiraMaiuscula($grafico['graficoGrupoName'].' - '.$grafico['graficoName']) }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
