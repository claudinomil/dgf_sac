<?php

namespace App\Domain\RessarcimentoConfiguracao;

use App\Models\RessarcimentoConfiguracao;

class RessarcimentoConfiguracaoRepository
{
    public function all()
    {
        return RessarcimentoConfiguracao::all();
    }

    public function index($limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        return RessarcimentoConfiguracao::orderby('referencia')->limit($limit)->get();
    }

    public function filter($array_dados, $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = RessarcimentoConfiguracao::select(['ressarcimento_configuracoes.*'])
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

    public function find($id)
    {
        return RessarcimentoConfiguracao::find($id);
    }

    public function find_referencia($referencia)
    {
        return RessarcimentoConfiguracao::where('referencia', $referencia)->first();
    }

    public function create(array $data)
    {
        return RessarcimentoConfiguracao::create($data);
    }

    public function update($id, array $data)
    {
        $ressarcimento_configuracao = $this->find($id);

        $ressarcimento_configuracao->update($data);

        return $ressarcimento_configuracao;
    }

    public function quantidade_registros()
    {
        return RessarcimentoConfiguracao::count();
    }

    public function configuracaoExiste($referencia)
    {
        $existe = RessarcimentoConfiguracao::where('referencia', $referencia)->first();

        if ($existe) {
            return true;
        }

        return false;
    }

    public function ultimaConfiguracao()
    {
        return RessarcimentoConfiguracao::orderby('referencia', 'DESC')->first();
    }
}
