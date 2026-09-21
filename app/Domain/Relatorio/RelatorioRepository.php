<?php

namespace App\Domain\Relatorio;

use App\Models\Grupo;
use App\Models\GrupoRelatorio;
use App\Models\Militar;
use App\Models\Operacao;
use App\Models\Relatorio;
use App\Models\RessarcimentoCobrancaDado;
use App\Models\RessarcimentoOrgao;
use App\Models\Submodulo;
use App\Models\Transacao;
use App\Models\User;
use App\Models\UserSituacao;
use App\Models\UserTipo;
use Illuminate\Support\Facades\DB;

class RelatorioRepository
{
    public function relatorios_grupo(int $grupo_id)
    {
        return GrupoRelatorio::join('relatorios', 'relatorios.id', 'grupos_relatorios.relatorio_id')
            ->join('relatorio_grupos', 'relatorio_grupos.id', 'relatorios.relatorio_grupo_id')
            ->where('grupos_relatorios.grupo_id', $grupo_id)
            ->select('relatorio_grupos.id as relatorioGrupoId', 'relatorios.id as relatorioId', 'relatorios.name as relatorioName')
            ->orderby('relatorio_grupos.ordem')
            ->orderby('relatorios.ordem')
            ->get();
    }

    public function relatorio_1(int $grupo_id)
    {
        // Relatório Data
        $relatorio_data = date('d/m/Y');

        // Relatório Hora
        $relatorio_hora = date('H:i:s');

        // Relatório Nome
        $relatorio = Relatorio::where('id', 1)->get();
        $relatorio_nome = $relatorio[0]['name'];

        // Parâmetros
        $relatorio_parametros = '';
        if ($grupo_id == 0) {
            $relatorio_parametros .= 'Todos os Grupos';
        } else {
            $grupo = Grupo::where('id', $grupo_id)->get();
            $relatorio_parametros .= $grupo[0]['name'];
        }

        // Registros
        $relatorio_registros = Grupo::select('grupos.*')
            ->where(function ($query) use ($grupo_id) {
                if ($grupo_id != 0) {
                    $query->where('grupos.id', $grupo_id);
                }
            })
            ->orderby('grupos.name')
            ->get();

        // Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $content;
    }

    public function relatorio_2(int $grupo_id, int $user_situacao_id, int $user_tipo_id)
    {
        // Relatório Data
        $relatorio_data = date('d/m/Y');

        // Relatório Hora
        $relatorio_hora = date('H:i:s');

        // Relatório Nome
        $relatorio = Relatorio::where('id', 2)->get();
        $relatorio_nome = $relatorio[0]['name'];

        // Parâmetros
        $relatorio_parametros = '';
        if ($grupo_id == 0) {
            $relatorio_parametros .= 'Todos os Grupos';
        } else {
            $grupo = Grupo::where('id', $grupo_id)->get();
            $relatorio_parametros .= $grupo[0]['name'];
        }
        if ($user_situacao_id == 0) {
            $relatorio_parametros .= ' / ' . 'Todos as Situações';
        } else {
            $situacao = UserSituacao::where('id', $user_situacao_id)->get();
            $relatorio_parametros .= ' / ' . $situacao[0]['name'];
        }
        if ($user_tipo_id == 0) {
            $relatorio_parametros .= ' / ' . 'Todos os Tipos';
        } else {
            $tipo = UserTipo::where('id', $user_tipo_id)->get();
            $relatorio_parametros .= ' / ' . $tipo[0]['name'];
        }

        // Registros
        $relatorio_registros = User::join('grupos', 'grupos.id', 'users.grupo_id')
            ->join('user_situacoes', 'user_situacoes.id', 'users.user_situacao_id')
            ->join('user_tipos', 'user_tipos.id', 'users.user_tipo_id')
            ->select('users.*', 'grupos.name as grupo', 'user_situacoes.name as user_situacao', 'user_tipos.name as user_tipo')
            ->where(function ($query) use ($grupo_id, $user_situacao_id, $user_tipo_id) {
                if ($grupo_id != 0) {
                    $query->where('grupos.id', $grupo_id);
                }
                if ($user_situacao_id != 0) {
                    $query->where('user_situacoes.id', $user_situacao_id);
                }
                if ($user_tipo_id != 0) {
                    $query->where('user_tipos.id', $user_tipo_id);
                }
            })
            ->orderby('users.name')
            ->get();

        // Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $content;
    }

    public function relatorio_3(string $data, int $user_id, int $submodulo_id, int $operacao_id, string $dado)
    {
        // Relatório Data
        $relatorio_data = date('d/m/Y');

        // Relatório Hora
        $relatorio_hora = date('H:i:s');

        // Relatório Nome
        $relatorio = Relatorio::where('id', 3)->get();
        $relatorio_nome = $relatorio[0]['name'];

        // Parâmetros
        $relatorio_parametros = '';
        if ($data != 'xxxyyyzzz') {
            $relatorio_parametros .= getDataFormatada(1, $data);
        }
        if ($user_id == 0) {
            if ($relatorio_parametros != '') {
                $relatorio_parametros .= ' / ';
            }
            $relatorio_parametros .= 'Todos os Usuários';
        } else {
            $user = User::where('id', $user_id)->get();
            if ($relatorio_parametros != '') {
                $relatorio_parametros .= ' / ';
            }
            $relatorio_parametros .= $user[0]['name'];
        }
        if ($submodulo_id == 0) {
            if ($relatorio_parametros != '') {
                $relatorio_parametros .= ' / ';
            }
            $relatorio_parametros .= 'Todos os Submódulos';
        } else {
            $submodulo = Submodulo::where('id', $submodulo_id)->get();
            if ($relatorio_parametros != '') {
                $relatorio_parametros .= ' / ';
            }
            $relatorio_parametros .= $submodulo[0]['name'];
        }
        if ($operacao_id == 0) {
            if ($relatorio_parametros != '') {
                $relatorio_parametros .= ' / ';
            }
            $relatorio_parametros .= 'Todas as Operações';
        } else {
            $operacao = Operacao::where('id', $operacao_id)->get();
            if ($relatorio_parametros != '') {
                $relatorio_parametros .= ' / ';
            }
            $relatorio_parametros .= $operacao[0]['name'];
        }
        if ($dado != 'xxxyyyzzz') {
            if ($relatorio_parametros != '') {
                $relatorio_parametros .= ' / ';
            }
            $relatorio_parametros .= $dado;
        }

        // Registros
        $relatorio_registros = Transacao::join('users', 'users.id', 'transacoes.user_id')
            ->join('submodulos', 'submodulos.id', 'transacoes.submodulo_id')
            ->join('operacoes', 'operacoes.id', 'transacoes.operacao_id')
            ->select('transacoes.*', 'users.name as user', 'submodulos.name as submodulo', 'operacoes.name as operacao')
            ->where(function ($query) use ($data, $user_id, $submodulo_id, $operacao_id, $dado) {
                if ($data != 'xxxyyyzzz') {
                    $query->where('transacoes.date', $data);
                }
                if ($user_id != 0) {
                    $query->where('transacoes.user_id', $user_id);
                }
                if ($submodulo_id != 0) {
                    $query->where('transacoes.submodulo_id', $submodulo_id);
                }
                if ($operacao_id != 0) {
                    $query->where('transacoes.operacao_id', $operacao_id);
                }
                if ($dado != 'xxxyyyzzz') {
                    $query->where('transacoes.dados', 'LIKE', '%' . $dado . '%');
                }
            })
            ->orderby('transacoes.date')
            ->orderby('submodulos.name')
            ->orderby('users.name')
            ->get();

        //Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $content;
    }

    public function relatorio_4(string $referencia, int $orgao_id)
    {
        // Relatório Data
        $relatorio_data = date('d/m/Y');

        // Relatório Hora
        $relatorio_hora = date('H:i:s');

        // Relatório Nome
        $relatorio = Relatorio::where('id', 4)->get();
        $relatorio_nome = $relatorio[0]['name'];

        // Parâmetros
        $relatorio_parametros = getReferencia(1, $referencia);
        if ($orgao_id == 0) {
            $relatorio_parametros .= ' / ' . 'Todos os Órgãos';
        } else {
            $orgao = RessarcimentoOrgao::where('id', $orgao_id)->get();
            $relatorio_parametros .= ' / ' . $orgao[0]['name'];
        }

        // Militares pela referencia e pelo(s) Órgão(s)
        $relatorio_registros = RessarcimentoCobrancaDado::join('ressarcimento_militares', 'ressarcimento_militares.id', 'ressarcimento_cobrancas_dados.ressarcimento_militar_id')
            ->join('ressarcimento_orgaos', 'ressarcimento_orgaos.id', 'ressarcimento_cobrancas_dados.ressarcimento_orgao_id')
            ->select(
                'ressarcimento_cobrancas_dados.referencia',
                'ressarcimento_orgaos.name as orgao_nome',
                'ressarcimento_militares.identidade_funcional as militar_identidade_funcional',
                'ressarcimento_militares.rg as militar_rg',
                'ressarcimento_militares.nome as militar_nome',
                'ressarcimento_militares.posto_graduacao as militar_posto_graduacao',
                'ressarcimento_militares.quadro_qbmp as militar_quadro'
            )
            ->where(function ($query) use ($referencia, $orgao_id) {
                $query->where('ressarcimento_cobrancas_dados.referencia', $referencia);

                if ($orgao_id != 0) {
                    $query->where('ressarcimento_orgaos.id', $orgao_id);
                }
            })
            ->orderby('ressarcimento_cobrancas_dados.referencia')
            ->orderby('ressarcimento_orgaos.name')
            ->get();

        // Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $content;
    }

    public function relatorio_5(string $referencia, int $orgao_id)
    {
        // Relatório Data
        $relatorio_data = date('d/m/Y');

        // Relatório Hora
        $relatorio_hora = date('H:i:s');

        // Relatório Nome
        $relatorio = Relatorio::where('id', 5)->get();
        $relatorio_nome = $relatorio[0]['name'];

        // Parâmetros
        $relatorio_parametros = getReferencia(1, $referencia);
        if ($orgao_id == 0) {
            $relatorio_parametros .= ' / ' . 'Todos os Órgãos';
        } else {
            $orgao = RessarcimentoOrgao::where('id', $orgao_id)->get();
            $relatorio_parametros .= ' / ' . $orgao[0]['name'];
        }

        // Registros
        $relatorio_registros = RessarcimentoCobrancaDado::join('ressarcimento_orgaos', 'ressarcimento_orgaos.id', 'ressarcimento_cobrancas_dados.ressarcimento_orgao_id')
            ->select(
                'ressarcimento_cobrancas_dados.referencia',
                'ressarcimento_cobrancas_dados.orgao_name',
                DB::raw('SUM(ressarcimento_cobrancas_dados.listagem_fonte10 + ressarcimento_cobrancas_dados.listagem_vencimento_bruto + ressarcimento_cobrancas_dados.listagem_folha_suplementar) as vencimentos_brutos'),
                DB::raw('SUM(ressarcimento_cobrancas_dados.listagem_rioprevidencia22 + ressarcimento_cobrancas_dados.listagem_fundo_saude_10) as encargos_sociais_e_patronais'),
                DB::raw('SUM(ressarcimento_cobrancas_dados.listagem_fonte10 + ressarcimento_cobrancas_dados.listagem_vencimento_bruto + ressarcimento_cobrancas_dados.listagem_folha_suplementar + ressarcimento_cobrancas_dados.listagem_rioprevidencia22 + ressarcimento_cobrancas_dados.listagem_fundo_saude_10) as ressarcimento')
            )
            ->where(function ($query) use ($referencia, $orgao_id) {
                $query->where('ressarcimento_cobrancas_dados.referencia', $referencia);

                if ($orgao_id != 0) {
                    $query->where('ressarcimento_orgaos.id', $orgao_id);
                }
            })
            ->groupby('ressarcimento_cobrancas_dados.referencia')
            ->groupby('ressarcimento_cobrancas_dados.orgao_name')
            ->orderby('ressarcimento_cobrancas_dados.orgao_name')
            ->get();

        // Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $content;
    }

    public function relatorio_6(string $referencia, int $orgao_id, float $saldo)
    {
        // Relatório Data
        $relatorio_data = date('d/m/Y');

        // Relatório Hora
        $relatorio_hora = date('H:i:s');

        // Relatório Nome
        $relatorio = Relatorio::where('id', 6)->get();
        $relatorio_nome = $relatorio[0]['name'];

        // Parâmetros
        $relatorio_parametros = getReferencia(1, $referencia);
        if ($orgao_id == 0) {
            $relatorio_parametros .= ' / ' . 'Todos os Órgãos';
        } else {
            $orgao = RessarcimentoOrgao::where('id', $orgao_id)->get();
            $relatorio_parametros .= ' / ' . $orgao[0]['name'];
        }
        if ($saldo == 0) {
            $relatorio_parametros .= ' / ' . 'Qualquer Saldo';
        } else if ($saldo == 1) {
            $relatorio_parametros .= ' / ' . 'Saldo igual a 0(zero)';
        } else if ($saldo == 2) {
            $relatorio_parametros .= ' / ' . 'Saldo menor que 0(zero)';
        } else if ($saldo == 3) {
            $relatorio_parametros .= ' / ' . 'Saldo maior que 0(zero)';
        }

        // Registros
        $relatorio_registros = RessarcimentoCobrancaDado::join('ressarcimento_orgaos', 'ressarcimento_orgaos.id', 'ressarcimento_cobrancas_dados.ressarcimento_orgao_id')
            ->join('ressarcimento_recebimentos', 'ressarcimento_recebimentos.ressarcimento_cobranca_dado_id', 'ressarcimento_cobrancas_dados.id')
            ->select(
                'ressarcimento_cobrancas_dados.referencia',
                'ressarcimento_cobrancas_dados.orgao_name',
                DB::raw('SUM(ressarcimento_cobrancas_dados.listagem_fonte10 + ressarcimento_cobrancas_dados.listagem_vencimento_bruto + ressarcimento_cobrancas_dados.listagem_folha_suplementar + ressarcimento_cobrancas_dados.listagem_rioprevidencia22 + ressarcimento_cobrancas_dados.listagem_fundo_saude_10) as ressarcimento'),
                DB::raw('SUM(ressarcimento_recebimentos.valor_recebido) as recebimento'),
                DB::raw('SUM((ressarcimento_cobrancas_dados.listagem_fonte10 + ressarcimento_cobrancas_dados.listagem_vencimento_bruto + ressarcimento_cobrancas_dados.listagem_folha_suplementar + ressarcimento_cobrancas_dados.listagem_rioprevidencia22 + ressarcimento_cobrancas_dados.listagem_fundo_saude_10) - (ressarcimento_recebimentos.valor_recebido)) as saldo')
            )->where(function ($query) use ($referencia, $orgao_id) {
                $query->where('ressarcimento_cobrancas_dados.referencia', $referencia);

                if ($orgao_id != 0) {
                    $query->where('ressarcimento_orgaos.id', $orgao_id);
                }
            })
            ->groupby('ressarcimento_cobrancas_dados.referencia')
            ->groupby('ressarcimento_cobrancas_dados.orgao_name')
            ->orderby('ressarcimento_cobrancas_dados.orgao_name')
            ->get();

        // Verificar se é para filtrar os registros
        $dados = array();
        foreach ($relatorio_registros as $registro) {
            // Qualquer Saldo
            if ($saldo == 0) {
                $dados[] = $registro;
            }

            // Saldo igual a 0(zero)
            if ($saldo == 1) {
                if ($registro['saldo'] == 0) {
                    $dados[] = $registro;
                }
            }

            // Saldo menor que 0(zero)
            if ($saldo == 2) {
                if ($registro['saldo'] < 0) {
                    $dados[] = $registro;
                }
            }

            // Saldo maior que 0(zero)
            if ($saldo == 3) {
                if ($registro['saldo'] > 0) {
                    $dados[] = $registro;
                }
            }
        }
        $relatorio_registros = $dados;

        // Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $content;
    }

    public function relatorio_7()
    {
        // Relatório Data
        $relatorio_data = date('d/m/Y');

        // Relatório Hora
        $relatorio_hora = date('H:i:s');

        // Relatório Nome
        $relatorio = Relatorio::where('id', 7)->get();
        $relatorio_nome = $relatorio[0]['name'];

        // Parâmetros
        $relatorio_parametros = '';

        // Registros
        $relatorio_registros = Militar::join('situacoes', 'situacoes.id', '=', 'militares.situacao_id')
            ->select(
                'situacoes.name',
                DB::raw('COUNT(militares.id) as quantidade')
            )
            ->groupBy('situacoes.name')
            ->orderBy('situacoes.name')
            ->get();

        // Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $content;
    }

    public function relatorio_8()
    {
        // Relatório Data
        $relatorio_data = date('d/m/Y');

        // Relatório Hora
        $relatorio_hora = date('H:i:s');

        // Relatório Nome
        $relatorio = Relatorio::where('id', 8)->get();
        $relatorio_nome = $relatorio[0]['name'];

        // Parâmetros
        $relatorio_parametros = '';

        // Registros
        $relatorio_registros = Militar::join('graduacoes', 'graduacoes.id', '=', 'militares.graduacao_id')
            ->select(
                'graduacoes.id',
                'graduacoes.name',
                DB::raw('COUNT(militares.id) as quantidade')
            )
            ->groupBy('graduacoes.id', 'graduacoes.name')
            ->orderBy('graduacoes.id')
            ->get();

        // Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $content;
    }

    public function relatorio_9()
    {
        // Relatório Data
        $relatorio_data = date('d/m/Y');

        // Relatório Hora
        $relatorio_hora = date('H:i:s');

        // Relatório Nome
        $relatorio = Relatorio::where('id', 9)->get();
        $relatorio_nome = $relatorio[0]['name'];

        // Parâmetros
        $relatorio_parametros = '';

        // Registros
        $relatorio_registros = Militar::join('unidades', 'unidades.id', '=', 'militares.unidade_id')
            ->select(
                'unidades.name',
                DB::raw('COUNT(militares.id) as quantidade')
            )
            ->groupBy('unidades.name')
            ->orderBy('unidades.name')
            ->get();

        // Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $content;
    }

    public function relatorio_10()
    {
        // Relatório Data
        $relatorio_data = date('d/m/Y');

        // Relatório Hora
        $relatorio_hora = date('H:i:s');

        // Relatório Nome
        $relatorio = Relatorio::where('id', 10)->get();
        $relatorio_nome = $relatorio[0]['name'];

        // Parâmetros
        $relatorio_parametros = '';

        // Registros
        $relatorio_registros = Militar::join('quadros', 'quadros.id', '=', 'militares.quadro_id')
            ->select(
                'quadros.name',
                DB::raw('COUNT(militares.id) as quantidade')
            )
            ->groupBy('quadros.name')
            ->orderBy('quadros.name')
            ->get();

        // Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $content;
    }

    public function relatorio_11()
    {
        // Relatório Data
        $relatorio_data = date('d/m/Y');

        // Relatório Hora
        $relatorio_hora = date('H:i:s');

        // Relatório Nome
        $relatorio = Relatorio::where('id', 11)->get();
        $relatorio_nome = $relatorio[0]['name'];

        // Parâmetros
        $relatorio_parametros = '';

        // Registros
        $relatorio_registros = Militar::join('comportamentos', 'comportamentos.id', '=', 'militares.comportamento_id')
            ->select(
                'comportamentos.name',
                DB::raw('COUNT(militares.id) as quantidade')
            )
            ->groupBy('comportamentos.name')
            ->orderBy('comportamentos.name')
            ->get();

        // Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $content;
    }

    public function relatorio_12(object $request, string $situacoes, string $graduacoes, string $unidades, string $quadros, string $comportamentos)
    {
        // Relatório Data
        $relatorio_data = date('d/m/Y');

        // Relatório Hora
        $relatorio_hora = date('H:i:s');

        // Relatório Nome
        $relatorio = Relatorio::where('id', 12)->get();
        $relatorio_nome = $relatorio[0]['name'];

        // Parâmetros
        $relatorio_parametros = '';

        // Formatar Parâmetros
        $situacoes = explode(',', $situacoes);
        $graduacoes = explode(',', $graduacoes);
        $unidades = explode(',', $unidades);
        $quadros = explode(',', $quadros);
        $comportamentos = explode(',', $comportamentos);

        // Registros
        $relatorio_registros = DB::table('militares')
            ->leftJoin('situacoes', 'situacoes.id', '=', 'militares.situacao_id')
            ->leftJoin('graduacoes', 'graduacoes.id', '=', 'militares.graduacao_id')
            ->leftJoin('unidades', 'unidades.id', '=', 'militares.unidade_id')
            ->leftJoin('quadros', 'quadros.id', '=', 'militares.quadro_id')
            ->leftJoin('comportamentos', 'comportamentos.id', '=', 'militares.comportamento_id')
            ->leftJoin('sexos_biologicos', 'sexos_biologicos.id', '=', 'militares.sexo_biologico_id')
            ->leftJoin('generos', 'generos.id', '=', 'militares.genero_id')
            ->leftJoin('unidades as prestando_servicos', 'prestando_servicos.id', '=', 'militares.prestando_servico_id')
            ->leftJoin('funcoes', 'funcoes.id', '=', 'militares.funcao_id')
            ->leftJoin('bancos', 'bancos.id', '=', 'militares.banco_id')
            ->leftJoin('estados_civis', 'estados_civis.id', '=', 'militares.estado_civil_id')
            ->leftJoin('tipos_sanguineos', 'tipos_sanguineos.id', '=', 'militares.tipo_sanguineo_id')
            ->leftJoin('fatores_rh', 'fatores_rh.id', '=', 'militares.fator_rh_id')
            ->leftJoin('nacionalidades', 'nacionalidades.id', '=', 'militares.nacionalidade_id')
            ->leftJoin('naturalidades', 'naturalidades.id', '=', 'militares.naturalidade_id')
            ->leftJoin('escolaridades', 'escolaridades.id', '=', 'militares.escolaridade_id')
            ->select(
                'militares.*',
                'situacoes.name as situacaoName',
                'graduacoes.name as graduacaoName',
                'unidades.name as unidadeName',
                'quadros.name as quadroName',
                'comportamentos.name as comportamentoName',
                'sexos_biologicos.name as sexoBiologicoName',
                'generos.name as generoName',
                'prestando_servicos.name as prestandoServicoName',
                'funcoes.name as funcaoName',
                'bancos.name as bancoName',
                'estados_civis.name as estadoCivilName',
                'tipos_sanguineos.name as tipoSanguineoName',
                'fatores_rh.name as fatorRhName',
                'nacionalidades.name as nacionalidadeName',
                'naturalidades.name as naturalidadeName',
                'escolaridades.name as escolaridadeName'
            )
            ->when($situacoes[0] != 0, function ($query) use ($situacoes) {
                $query->whereIn('militares.situacao_id', $situacoes);
            })
            ->when($graduacoes[0] != 0, function ($query) use ($graduacoes) {
                $query->whereIn('militares.graduacao_id', $graduacoes);
            })
            ->when($unidades[0] != 0, function ($query) use ($unidades) {
                $query->whereIn('militares.unidade_id', $unidades);
            })
            ->when($quadros[0] != 0, function ($query) use ($quadros) {
                $query->whereIn('militares.quadro_id', $quadros);
            })
            ->when($comportamentos[0] != 0, function ($query) use ($comportamentos) {
                // Remove string "null"
                $valores = array_filter($comportamentos, function ($v) {
                    return $v !== 'null';
                });

                $query->where(function ($q) use ($valores, $comportamentos) {
                    if (!empty($valores)) {
                        $q->whereIn('militares.comportamento_id', $valores);
                    }

                    if (in_array('null', $comportamentos, true)) {
                        $q->orWhereNull('militares.comportamento_id');
                    }
                });
            })
            ->orderBy('militares.rg')
            ->get();

        // Retorno
        $content = array();
        $content['relatorio_data'] = $relatorio_data;
        $content['relatorio_hora'] = $relatorio_hora;
        $content['relatorio_nome'] = $relatorio_nome;
        $content['relatorio_parametros'] = $relatorio_parametros;
        $content['relatorio_registros'] = $relatorio_registros;

        return $content;
    }
}
