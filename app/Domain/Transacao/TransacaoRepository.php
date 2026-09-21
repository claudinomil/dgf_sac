<?php

namespace App\Domain\Transacao;

use App\Models\AjudaCustoTipo;
use App\Models\AuxilioFardamentoTipo;
use App\Models\Banco;
use App\Models\Comportamento;
use App\Models\Curso;
use App\Models\Escolaridade;
use App\Models\Esfera;
use App\Models\EstadoCivil;
use App\Models\FatorRh;
use App\Models\Funcao;
use App\Models\Genero;
use App\Models\Graduacao;
use App\Models\Grupo;
use App\Models\Militar;
use App\Models\Nacionalidade;
use App\Models\Naturalidade;
use App\Models\Parentesco;
use App\Models\Poder;
use App\Models\Quadro;
use App\Models\RessarcimentoOrgao;
use App\Models\SexoBiologico;
use App\Models\Situacao;
use App\Models\TipoSanguineo;
use App\Models\Transacao;
use App\Models\Tratamento;
use App\Models\Unidade;
use App\Models\UserSituacao;
use App\Models\UserTipo;
use App\Models\Vocativo;

class TransacaoRepository
{
    public function all()
    {
        return Transacao::all();
    }

    public function index(int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        return Transacao::join('users', 'transacoes.user_id', '=', 'users.id')
            ->join('operacoes', 'transacoes.operacao_id', '=', 'operacoes.id')
            ->join('submodulos', 'transacoes.submodulo_id', '=', 'submodulos.id')
            ->select(['transacoes.*', 'users.name as userName', 'operacoes.name as operacaoName', 'submodulos.name as submoduloName'])
            ->orderby('transacoes.date', 'DESC')
            ->orderby('transacoes.time', 'DESC')
            ->limit($limit)
            ->get();
    }

    public function filter(string $array_dados, int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = Transacao::join('users', 'transacoes.user_id', '=', 'users.id')
            ->join('operacoes', 'transacoes.operacao_id', '=', 'operacoes.id')
            ->join('submodulos', 'transacoes.submodulo_id', '=', 'submodulos.id')
            ->select(['transacoes.*', 'users.name as userName', 'operacoes.name as operacaoName', 'submodulos.name as submoduloName'])
            ->orderby('transacoes.date', 'DESC')
            ->orderby('transacoes.time', 'DESC')
            ->where(function($query) use($filtros) {
                // Variavel para controle
                $qtdFiltros = count($filtros) / 4;
                $indexCampo = 0;

                for($i=1; $i<=$qtdFiltros; $i++) {
                    // Valores do Filtro
                    $condicao = $filtros[$indexCampo];
                    $campo = $filtros[$indexCampo+1];
                    $operacao = $filtros[$indexCampo+2];
                    $dado = $filtros[$indexCampo+3];

                    // Operações
                    if ($operacao == 1) {
                        if ($condicao == 1) {$query->where($campo, 'like', '%'.$dado.'%');} else {$query->orwhere($campo, 'like', '%'.$dado.'%');}
                    }

                    if ($operacao == 2) {
                        if ($condicao == 1) {$query->where($campo, '=', $dado);} else {$query->orwhere($campo, '=', $dado);}
                    }

                    if ($operacao == 3) {
                        if ($condicao == 1) {$query->where($campo, '>', $dado);} else {$query->orwhere($campo, '>', $dado);}
                    }

                    if ($operacao == 4) {
                        if ($condicao == 1) {$query->where($campo, '>=', $dado);} else {$query->orwhere($campo, '>=', $dado);}
                    }

                    if ($operacao == 5) {
                        if ($condicao == 1) {$query->where($campo, '<', $dado);} else {$query->orwhere($campo, '<', $dado);}
                    }

                    if ($operacao == 6) {
                        if ($condicao == 1) {$query->where($campo, '<=', $dado);} else {$query->orwhere($campo, '<=', $dado);}
                    }

                    if ($operacao == 7) {
                        if ($condicao == 1) {$query->where($campo, 'like', $dado.'%');} else {$query->orwhere($campo, 'like', $dado.'%');}
                    }

                    if ($operacao == 8) {
                        if ($condicao == 1) {$query->where($campo, 'like', '%'.$dado);} else {$query->orwhere($campo, 'like', '%'.$dado);}
                    }

                    // Atualizar indexCampo
                    $indexCampo = $indexCampo + 4;
                }
            }
            )->limit($limit)
            ->get();

        return $registros;
    }

    public function create(array $data)
    {
        return Transacao::create($data);
    }

    public function getModelValue(int $model_op, int $model_id)
    {
        if ($model_op == 1) {
            $registro = Grupo::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 2) {
            $registro = UserSituacao::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 3) {
            $registro = UserTipo::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 4) {
            $registro = Situacao::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 5) {
            $registro = Graduacao::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 6) {
            $registro = Unidade::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 7) {
            $registro = Quadro::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 8) {
            $registro = SexoBiologico::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 9) {
            $registro = AjudaCustoTipo::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 10) {
            $registro = AuxilioFardamentoTipo::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 12) {
            $registro = Genero::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 13) {
            $registro = Unidade::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 14) {
            $registro = Funcao::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 15) {
            $registro = Banco::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 16) {
            $registro = EstadoCivil::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 17) {
            $registro = Comportamento::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 18) {
            $registro = TipoSanguineo::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 19) {
            $registro = FatorRh::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 20) {
            $registro = Nacionalidade::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 21) {
            $registro = Naturalidade::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 22) {
            $registro = Escolaridade::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 23) {
            $registro = Esfera::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 24) {
            $registro = Poder::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 25) {
            $registro = Tratamento::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 26) {
            $registro = Vocativo::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 27) {
            $registro = Militar::join('situacoes', 'situacoes.id', 'militares.situacao_id')
                        ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
                        ->select('militares.rg', 'militares.nome', 'situacoes.name as situacaoName', 'graduacoes.name as graduacaoName')
                        ->where('militares.id', $model_id)
                        ->get()[0];
            if ($registro) {return $registro->nome.'<br>'.$registro->rg.'<br>'.$registro->situacaoName.'<br>'.$registro->graduacaoName;}
            return '';
        }

        if ($model_op == 28) {
            $registro = Curso::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 29) {
            $registro = RessarcimentoOrgao::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        if ($model_op == 30) {
            $registro = Parentesco::find($model_id);
            if ($registro) {return $registro->name;}
            return '';
        }

        // 0 ou 1 - NÃO ou SIM
        if ($model_op == 31) {
            if ($model_id == 0) {return 'NÃO';}
            if ($model_id == 1) {return 'SIM';}

            return '';
        }

        // Tipo Acesso 0(NEGAR)  1(INTEGRAL)  2(AMBULATORIAL)
        if ($model_op == 32) {
            if ($model_id == 0) {return 'NEGAR';}
            if ($model_id == 1) {return 'INTEGRAL';}
            if ($model_id == 2) {return 'AMBULATORIAL';}

            return '';
        }

        // Tipo Curso 1(ESPECIAL)  2(ESPECIALIZAÇÃO)  3(REGULAR)
        if ($model_op == 33) {
            if ($model_id == 1) {return 'ESPECIAL';}
            if ($model_id == 2) {return 'ESPECIALIZAÇÃO';}
            if ($model_id == 3) {return 'REGULAR';}

            return '';
        }

        // Oficial Praça 1(OFICIAL)  2(PRAÇA)  3(OFICIAL/PRAÇA)
        if ($model_op == 34) {
            if ($model_id == 1) {return 'OFICIAL';}
            if ($model_id == 2) {return 'PRAÇA';}
            if ($model_id == 3) {return 'OFICIAL/PRAÇA';}

            return '';
        }

        // Situação Unidade 1(Ativa - recebe efetivo) 2(Inativa - não recebe efetivo)
        if ($model_op == 35) {
            if ($model_id == 1) {return 'Ativa - recebe efetivo';}
            if ($model_id == 2) {return 'Inativa - não recebe efetivo';}

            return '';
        }

        // Tipo Unidade 1(SEDEC)  2(CBMERJ) 3(ÓRGÃO EXTERNO) 4(SAÚDE)
        if ($model_op == 36) {
            if ($model_id == 1) {return 'SEDEC';}
            if ($model_id == 2) {return 'CBMERJ';}
            if ($model_id == 3) {return 'ÓRGÃO EXTERNO';}
            if ($model_id == 4) {return 'SAÚDE';}

            return '';
        }
    }

    public function totais(int $op)
    {
        // Total Geral
        if ($op == 1) {
            return Transacao::count();
        }

        // Total Inclusão
        if ($op == 2) {
            return Transacao::where('operacao_id', 1)->count();
        }

        // Total Alteração
        if ($op == 3) {
            return Transacao::where('operacao_id', 2)->count();
        }

        // Total Exclusão
        if ($op == 4) {
            return Transacao::where('operacao_id', 1)->count();
        }
    }
}
