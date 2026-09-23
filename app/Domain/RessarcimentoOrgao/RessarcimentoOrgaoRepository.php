<?php

namespace App\Domain\RessarcimentoOrgao;

use App\Models\RessarcimentoOrgao;

class RessarcimentoOrgaoRepository
{
    public function all()
    {
        return RessarcimentoOrgao::all();
    }

    public function index($limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        return RessarcimentoOrgao::orderby('name')->limit($limit)->get();
    }

    public function filter($array_dados, $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = RessarcimentoOrgao::select(['ressarcimento_orgaos.*'])
            ->where(
                function ($query) use ($filtros) {
                    // Variavel para controle
                    $qtdFiltros = count($filtros) / 4;
                    $indexCampo = 0;

                    for ($i = 1; $i <= $qtdFiltros; $i++) {
                        // Valores do Filtro
                        $condicao = $filtros[$indexCampo];
                        $campo = $filtros[$indexCampo + 1];
                        $operacao = $filtros[$indexCampo + 2];
                        $dado = $filtros[$indexCampo + 3];

                        // Operações
                        if ($operacao == 1) {
                            if ($condicao == 1) {
                                $query->where($campo, 'like', '%' . $dado . '%');
                            } else {
                                $query->orwhere($campo, 'like', '%' . $dado . '%');
                            }
                        }

                        if ($operacao == 2) {
                            if ($condicao == 1) {
                                $query->where($campo, '=', $dado);
                            } else {
                                $query->orwhere($campo, '=', $dado);
                            }
                        }

                        if ($operacao == 3) {
                            if ($condicao == 1) {
                                $query->where($campo, '>', $dado);
                            } else {
                                $query->orwhere($campo, '>', $dado);
                            }
                        }

                        if ($operacao == 4) {
                            if ($condicao == 1) {
                                $query->where($campo, '>=', $dado);
                            } else {
                                $query->orwhere($campo, '>=', $dado);
                            }
                        }

                        if ($operacao == 5) {
                            if ($condicao == 1) {
                                $query->where($campo, '<', $dado);
                            } else {
                                $query->orwhere($campo, '<', $dado);
                            }
                        }

                        if ($operacao == 6) {
                            if ($condicao == 1) {
                                $query->where($campo, '<=', $dado);
                            } else {
                                $query->orwhere($campo, '<=', $dado);
                            }
                        }

                        if ($operacao == 7) {
                            if ($condicao == 1) {
                                $query->where($campo, 'like', $dado . '%');
                            } else {
                                $query->orwhere($campo, 'like', $dado . '%');
                            }
                        }

                        if ($operacao == 8) {
                            if ($condicao == 1) {
                                $query->where($campo, 'like', '%' . $dado);
                            } else {
                                $query->orwhere($campo, 'like', '%' . $dado);
                            }
                        }

                        // Atualizar indexCampo
                        $indexCampo = $indexCampo + 4;
                    }
                }
            )->limit($limit)
            ->get();

        return $registros;
    }

    public function find(int $id)
    {
        return RessarcimentoOrgao::find($id);
    }

    public function orgaos_referencia(string $referencia)
    {
        return RessarcimentoOrgao::join('ressarcimento_militares', 'ressarcimento_militares.lotacao_id', 'ressarcimento_orgaos.lotacao_id')
            ->join('esferas', 'esferas.id', 'ressarcimento_orgaos.esfera_id')
            ->join('poderes', 'poderes.id', 'ressarcimento_orgaos.poder_id')
            ->join('tratamentos', 'tratamentos.id', 'ressarcimento_orgaos.tratamento_id')
            ->join('vocativos', 'vocativos.id', 'ressarcimento_orgaos.vocativo_id')
            ->join('ressarcimento_funcoes', 'ressarcimento_funcoes.id', 'ressarcimento_orgaos.ressarcimento_funcao_id')
            ->select('ressarcimento_orgaos.*', 'esferas.name as esferaName', 'poderes.name as poderName', 'tratamentos.completo as tratamentoCompleto', 'tratamentos.reduzido as tratamentoReduzido', 'vocativos.name as vocativoName', 'ressarcimento_funcoes.name as funcaoName')
            ->distinct()
            ->where('ressarcimento_militares.referencia', $referencia)
            ->get();
    }

    public function create(array $data)
    {
        return RessarcimentoOrgao::create($data);
    }

    public function update($id, array $data)
    {
        $ressarcimento_orgao = $this->find($id);

        $ressarcimento_orgao->update($data);

        return $ressarcimento_orgao;
    }

    public function quantidade_registros()
    {
        return RessarcimentoOrgao::count();
    }

    public function orgaoExiste($lotacao_id)
    {
        $existe = RessarcimentoOrgao::where('lotacao_id', $lotacao_id)->first();

        if ($existe) {
            return true;
        }

        return false;
    }
}
