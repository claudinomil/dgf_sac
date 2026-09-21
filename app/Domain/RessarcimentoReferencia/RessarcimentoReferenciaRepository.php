<?php

namespace App\Domain\RessarcimentoReferencia;

use App\Models\RessarcimentoCobranca;
use App\Models\RessarcimentoMilitar;
use App\Models\RessarcimentoReferencia;
use Illuminate\Support\Facades\DB;

class RessarcimentoReferenciaRepository
{
    public function all()
    {
        return RessarcimentoReferencia::all();
    }

    public function index($limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        return RessarcimentoReferencia::orderby('referencia', 'desc')->orderby('mes', 'desc')->orderby('parte', 'desc')->limit($limit)->get();
    }

    public function filter($array_dados, $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = RessarcimentoReferencia::select(['ressarcimento_referencias.*'])
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
        return RessarcimentoReferencia::find($id);
    }

    public function find_referencia($referencia)
    {
        return RessarcimentoReferencia::where('referencia', $referencia)->first();
    }

    public function create(array $data)
    {
        return RessarcimentoReferencia::create($data);
    }

    public function update($id, array $data)
    {
        $ressarcimento_referencia = $this->find($id);

        $ressarcimento_referencia->update($data);

        return $ressarcimento_referencia;
    }

    public function delete($id)
    {
        $ressarcimento_referencia = $this->find($id);

        // Verificar relacionamentos
        $relacionamento = $this->relacionamento($id);
        if ($relacionamento['status'] === false) {
            throw new \Exception($relacionamento['message']);
        }

        return $ressarcimento_referencia->delete();
    }

    public function relacionamento(int $id)
    {
        $qtd = DB::table('ressarcimento_cobrancas_dados')->where('ressarcimento_referencia_id', $id)->count();

        if ($qtd > 0) {
            return ['status' => false, 'message' => 'Operação não permitida.<br> Relacionamento com Cobranças.'];
        }

        return ['status' => true];
    }

    public function referenciasAtivas()
    {
        // Referências (com Cobranças abertas)''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $referencias = RessarcimentoReferencia::orderBy('referencia')
            ->whereNotIn(
                'referencia',
                RessarcimentoCobranca::where('cobranca_encerrada', 1)
                    ->select('referencia')
            )
            ->pluck('referencia')
            ->toArray();
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        return $referencias;
    }

    public function referenciasComMilitares()
    {
        // Referências (com Militares Importados)
        return RessarcimentoMilitar::orderBy('referencia', 'DESC')
            ->distinct()
            ->pluck('referencia')
            ->toArray();
    }

    public function referenciaExiste($referencia)
    {
        $existe = RessarcimentoReferencia::where('referencia', $referencia)->first();

        if ($existe) {
            return true;
        }

        return false;
    }
}
