<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title>DGF SAC</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="shortcut icon" href="{{ asset('assets/images/image_favicon.png') }}">

        @vite(['resources/css/app.css','resources/js/app.js'])
        @include('layouts.head-css')
    </head>

    <body style="background-color: #f8f8fb;">
        <div class="container-fluid">
            <div class="row">
                @if (session('userContext.user.id') == 1)
                <!-- Homologação Solicitações Seeder -->
                <div class="col-12 mt-5">
                    <h1 class="text-success">Homologação Solicitações Seeder</h1>
                    <div class="col-12 font-size-10">
                        @foreach ($solicitacoes as $solicitacao)
                            @php
                                $campos = [
                                    'id' => $solicitacao->id,
                                    'submodulo_id' => $solicitacao->submodulo_id,
                                    'user_id' => $solicitacao->user_id,
                                    'solicitacao' => $solicitacao->solicitacao,
                                    'solicitacao_tipo' => $solicitacao->solicitacao_tipo,
                                    'solicitacao_prioridade' => $solicitacao->solicitacao_prioridade,
                                    'solicitacao_data' => $solicitacao->solicitacao_data ? \Carbon\Carbon::parse($solicitacao->solicitacao_data)->format('Y-m-d') : null,
                                    'solicitacao_imagem' => $solicitacao->solicitacao_imagem,
                                    'resposta' => $solicitacao->resposta,
                                    'resposta_status' => $solicitacao->resposta_status,
                                    'resposta_data' => $solicitacao->resposta_data ? \Carbon\Carbon::parse($solicitacao->resposta_data)->format('Y-m-d') : null,
                                ];

                                $formatarValor = function ($valor) {
                                    if (is_null($valor)) {
                                        return 'null';
                                    }

                                    if (is_bool($valor)) {
                                        return $valor ? 'true' : 'false';
                                    }

                                    if (is_int($valor) || is_float($valor)) {
                                        return (string) $valor;
                                    }

                                    return "'" . str_replace(
                                        ["\\", "'"],
                                        ["\\\\", "\\'"],
                                        (string) $valor
                                    ) . "'";
                                };

                                $camposFormatados = [];

                                foreach ($campos as $campo => $valor) {
                                    $camposFormatados[] = "'" . $campo . "' => " . $formatarValor($valor);
                                }
                            @endphp

                            HomologacaoSolicitacao::create([{!! implode(', ', $camposFormatados) !!}]);
                            <br>
                        @endforeach
                    </div>
                </div>

                <!-- Users Seeder -->
                <div class="col-12 mt-5">
                    <h1 class="text-success">Users Seeder</h1>
                    <div class="col-12 font-size-10">
                        @foreach ($users as $user)
                            @php
                                $campos = [
                                    'id' => $user->id,
                                    'name' => $user->name,
                                    'user' => $user->user,
                                    'email' => $user->email ? $user->email : null,
                                    'password' => '$2y$12$FwOqeyhDSI9NZKW2gmfoF.LYgE.obK6AU232aD/cZHPFSyxxuQXL6',
                                    'grupo_id' => $user->grupo_id ? $user->grupo_id : null,
                                    'user_situacao_id' => $user->user_situacao_id ? $user->user_situacao_id : null,
                                    'user_tipo_id' => $user->user_tipo_id,
                                    'avatar' => $user->avatar,
                                    'militar_id' => $user->militar_id ? $user->militar_id : null,
                                    'layout_menu' => $user->layout_menu,
                                ];

                                $camposFormatados = [];

                                foreach ($campos as $campo => $valor) {
                                    $camposFormatados[] = var_export($campo, true)
                                        . ' => '
                                        . var_export($valor, true);
                                }
                            @endphp

                            User::create([{!! implode(', ', $camposFormatados) !!}]);
                            <br>
                        @endforeach
                    </div>
                </div>

                <!-- Grupos Seeder -->
                <div class="col-12 mt-5">
                    <h1 class="text-success">Grupos Seeder</h1>
                    <div class="col-12 font-size-10">
                        @foreach ($grupos as $grupo)
                            @php
                                $campos = [
                                    'id' => $grupo->id,
                                    'name' => $grupo->name,
                                    'militares_permissoes_list_situacoes_ids' => $grupo->militares_permissoes_list_situacoes_ids,
                                    'militares_permissoes_show_situacoes_ids' => $grupo->militares_permissoes_show_situacoes_ids,
                                    'militares_permissoes_create_situacoes_ids' => $grupo->militares_permissoes_create_situacoes_ids,
                                    'militares_permissoes_edit_situacoes_ids' => $grupo->militares_permissoes_edit_situacoes_ids,
                                    'militares_permissoes_destroy_situacoes_ids' => $grupo->militares_permissoes_destroy_situacoes_ids,
                                    'militares_ajudas_custos_permissoes_list_situacoes_ids' => $grupo->militares_ajudas_custos_permissoes_list_situacoes_ids,
                                    'militares_ajudas_custos_permissoes_show_situacoes_ids' => $grupo->militares_ajudas_custos_permissoes_show_situacoes_ids,
                                    'militares_ajudas_custos_permissoes_create_situacoes_ids' => $grupo->militares_ajudas_custos_permissoes_create_situacoes_ids,
                                    'militares_ajudas_custos_permissoes_edit_situacoes_ids' => $grupo->militares_ajudas_custos_permissoes_edit_situacoes_ids,
                                    'militares_ajudas_custos_permissoes_destroy_situacoes_ids' => $grupo->militares_ajudas_custos_permissoes_destroy_situacoes_ids,
                                    'militares_auxilios_fardamentos_permissoes_list_situacoes_ids' => $grupo->militares_auxilios_fardamentos_permissoes_list_situacoes_ids,
                                    'militares_auxilios_fardamentos_permissoes_show_situacoes_ids' => $grupo->militares_auxilios_fardamentos_permissoes_show_situacoes_ids,
                                    'militares_auxilios_fardamentos_permissoes_create_situacoes_ids' => $grupo->militares_auxilios_fardamentos_permissoes_create_situacoes_ids,
                                    'militares_auxilios_fardamentos_permissoes_edit_situacoes_ids' => $grupo->militares_auxilios_fardamentos_permissoes_edit_situacoes_ids,
                                    'militares_auxilios_fardamentos_permissoes_destroy_situacoes_ids' => $grupo->militares_auxilios_fardamentos_permissoes_destroy_situacoes_ids,
                                    'militares_cursos_permissoes_list_situacoes_ids' => $grupo->militares_cursos_permissoes_list_situacoes_ids,
                                    'militares_cursos_permissoes_show_situacoes_ids' => $grupo->militares_cursos_permissoes_show_situacoes_ids,
                                    'militares_cursos_permissoes_create_situacoes_ids' => $grupo->militares_cursos_permissoes_create_situacoes_ids,
                                    'militares_cursos_permissoes_edit_situacoes_ids' => $grupo->militares_cursos_permissoes_edit_situacoes_ids,
                                    'militares_cursos_permissoes_destroy_situacoes_ids' => $grupo->militares_cursos_permissoes_destroy_situacoes_ids,
                                    'militares_contatos_permissoes_list_situacoes_ids' => $grupo->militares_contatos_permissoes_list_situacoes_ids,
                                    'militares_contatos_permissoes_show_situacoes_ids' => $grupo->militares_contatos_permissoes_show_situacoes_ids,
                                    'militares_contatos_permissoes_create_situacoes_ids' => $grupo->militares_contatos_permissoes_create_situacoes_ids,
                                    'militares_contatos_permissoes_edit_situacoes_ids' => $grupo->militares_contatos_permissoes_edit_situacoes_ids,
                                    'militares_contatos_permissoes_destroy_situacoes_ids' => $grupo->militares_contatos_permissoes_destroy_situacoes_ids,
                                    'militares_dependentes_permissoes_list_situacoes_ids' => $grupo->militares_dependentes_permissoes_list_situacoes_ids,
                                    'militares_dependentes_permissoes_show_situacoes_ids' => $grupo->militares_dependentes_permissoes_show_situacoes_ids,
                                    'militares_dependentes_permissoes_create_situacoes_ids' => $grupo->militares_dependentes_permissoes_create_situacoes_ids,
                                    'militares_dependentes_permissoes_edit_situacoes_ids' => $grupo->militares_dependentes_permissoes_edit_situacoes_ids,
                                    'militares_dependentes_permissoes_destroy_situacoes_ids' => $grupo->militares_dependentes_permissoes_destroy_situacoes_ids,
                                    'militares_fundos_saude_permissoes_list_situacoes_ids' => $grupo->militares_fundos_saude_permissoes_list_situacoes_ids,
                                    'militares_fundos_saude_permissoes_show_situacoes_ids' => $grupo->militares_fundos_saude_permissoes_show_situacoes_ids,
                                    'militares_fundos_saude_permissoes_create_situacoes_ids' => $grupo->militares_fundos_saude_permissoes_create_situacoes_ids,
                                    'militares_fundos_saude_permissoes_edit_situacoes_ids' => $grupo->militares_fundos_saude_permissoes_edit_situacoes_ids,
                                    'militares_fundos_saude_permissoes_destroy_situacoes_ids' => $grupo->militares_fundos_saude_permissoes_destroy_situacoes_ids,
                                    'militares_ferias_permissoes_list_situacoes_ids' => $grupo->militares_ferias_permissoes_list_situacoes_ids,
                                    'militares_ferias_permissoes_show_situacoes_ids' => $grupo->militares_ferias_permissoes_show_situacoes_ids,
                                    'militares_ferias_permissoes_create_situacoes_ids' => $grupo->militares_ferias_permissoes_create_situacoes_ids,
                                    'militares_ferias_permissoes_edit_situacoes_ids' => $grupo->militares_ferias_permissoes_edit_situacoes_ids,
                                    'militares_ferias_permissoes_destroy_situacoes_ids' => $grupo->militares_ferias_permissoes_destroy_situacoes_ids,
                                    'militares_pensoes_permissoes_list_situacoes_ids' => $grupo->militares_pensoes_permissoes_list_situacoes_ids,
                                    'militares_pensoes_permissoes_show_situacoes_ids' => $grupo->militares_pensoes_permissoes_show_situacoes_ids,
                                    'militares_pensoes_permissoes_create_situacoes_ids' => $grupo->militares_pensoes_permissoes_create_situacoes_ids,
                                    'militares_pensoes_permissoes_edit_situacoes_ids' => $grupo->militares_pensoes_permissoes_edit_situacoes_ids,
                                    'militares_pensoes_permissoes_destroy_situacoes_ids' => $grupo->militares_pensoes_permissoes_destroy_situacoes_ids,
                                    'militares_tempos_averbados_permissoes_list_situacoes_ids' => $grupo->militares_tempos_averbados_permissoes_list_situacoes_ids,
                                    'militares_tempos_averbados_permissoes_show_situacoes_ids' => $grupo->militares_tempos_averbados_permissoes_show_situacoes_ids,
                                    'militares_tempos_averbados_permissoes_create_situacoes_ids' => $grupo->militares_tempos_averbados_permissoes_create_situacoes_ids,
                                    'militares_tempos_averbados_permissoes_edit_situacoes_ids' => $grupo->militares_tempos_averbados_permissoes_edit_situacoes_ids,
                                    'militares_tempos_averbados_permissoes_destroy_situacoes_ids' => $grupo->militares_tempos_averbados_permissoes_destroy_situacoes_ids
                                ];

                                $camposFormatados = [];

                                foreach ($campos as $campo => $valor) {
                                    $camposFormatados[] = var_export($campo, true)
                                        . ' => '
                                        . var_export($valor, true);
                                }
                            @endphp

                            Grupo::create([{!! implode(', ', $camposFormatados) !!}]);
                            <br>
                        @endforeach
                    </div>
                </div>

                <!-- Missões -->
                <div class="col-12 mt-5">
                    <h1 class="text-primary mt-5">Missões</h1>
                    <div class="col-12 font-size-10">
                        @foreach ($solicitacoes as $dado)
                            @if (empty($dado->resposta))
                            {{ '##. ' . $dado->solicitacao }};<br>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        @include('layouts.vendor-scripts')
    </body>
</html>
