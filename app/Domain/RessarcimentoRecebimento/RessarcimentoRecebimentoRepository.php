<?php

namespace App\Domain\RessarcimentoRecebimento;

use App\Models\RessarcimentoCobrancaDado;
use App\Models\RessarcimentoRecebimento;
use App\Models\RessarcimentoReferencia;

class RessarcimentoRecebimentoRepository
{
    public function index($limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        return RessarcimentoCobrancaDado::join('ressarcimento_referencias', 'ressarcimento_referencias.id', 'ressarcimento_cobrancas_dados.ressarcimento_referencia_id')
            ->join('ressarcimento_orgaos', 'ressarcimento_orgaos.id', 'ressarcimento_cobrancas_dados.ressarcimento_orgao_id')
            ->join('ressarcimento_militares', 'ressarcimento_militares.id', 'ressarcimento_cobrancas_dados.ressarcimento_militar_id')
            ->join('ressarcimento_pagamentos', 'ressarcimento_pagamentos.id', 'ressarcimento_cobrancas_dados.ressarcimento_pagamento_id')
            ->join('ressarcimento_recebimentos', 'ressarcimento_recebimentos.ressarcimento_cobranca_dado_id', 'ressarcimento_cobrancas_dados.id')
            ->select(
                'ressarcimento_cobrancas_dados.militar_posto_graduacao as posto_graduacao',
                'ressarcimento_cobrancas_dados.militar_nome as nome',
                'ressarcimento_cobrancas_dados.militar_rg as rg',
                'ressarcimento_cobrancas_dados.listagem_valor_total as valor',
                'ressarcimento_cobrancas_dados.orgao_name as orgao',
                'ressarcimento_cobrancas_dados.referencia as referencia',
                'ressarcimento_recebimentos.id as id',
                'ressarcimento_recebimentos.data_recebimento as data_recebimento',
                'ressarcimento_recebimentos.valor_recebido as valor_recebido',
                'ressarcimento_recebimentos.saldo_restante as saldo_restante',
                'ressarcimento_recebimentos.guia_recolhimento as guia_recolhimento',
                'ressarcimento_recebimentos.documento as documento'
            )
            ->limit($limit)
            ->get();
    }

    public function filter($array_dados, $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = RessarcimentoCobrancaDado::join('ressarcimento_referencias', 'ressarcimento_referencias.id', 'ressarcimento_cobrancas_dados.ressarcimento_referencia_id')
            ->join('ressarcimento_orgaos', 'ressarcimento_orgaos.id', 'ressarcimento_cobrancas_dados.ressarcimento_orgao_id')
            ->join('ressarcimento_militares', 'ressarcimento_militares.id', 'ressarcimento_cobrancas_dados.ressarcimento_militar_id')
            ->join('ressarcimento_pagamentos', 'ressarcimento_pagamentos.id', 'ressarcimento_cobrancas_dados.ressarcimento_pagamento_id')
            ->join('ressarcimento_recebimentos', 'ressarcimento_recebimentos.ressarcimento_cobranca_dado_id', 'ressarcimento_cobrancas_dados.id')
            ->select(
                'ressarcimento_cobrancas_dados.militar_posto_graduacao as posto_graduacao',
                'ressarcimento_cobrancas_dados.militar_nome as nome',
                'ressarcimento_cobrancas_dados.militar_rg as rg',
                'ressarcimento_cobrancas_dados.listagem_valor_total as valor',
                'ressarcimento_cobrancas_dados.orgao_name as orgao',
                'ressarcimento_cobrancas_dados.referencia as referencia',
                'ressarcimento_recebimentos.id as id',
                'ressarcimento_recebimentos.data_recebimento as data_recebimento',
                'ressarcimento_recebimentos.valor_recebido as valor_recebido',
                'ressarcimento_recebimentos.saldo_restante as saldo_restante',
                'ressarcimento_recebimentos.guia_recolhimento as guia_recolhimento',
                'ressarcimento_recebimentos.documento as documento'
            )
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

    public function create(array $data)
    {
        return RessarcimentoRecebimento::create($data);
    }

    public function update_recebimento($request)
    {
        try {
            $referencia = $request['grade_recebimentos_referencia'];
            $orgao_id = $request['grade_recebimentos_orgao_id'];

            $registros = RessarcimentoCobrancaDado
                ::join('ressarcimento_recebimentos', 'ressarcimento_recebimentos.ressarcimento_cobranca_dado_id', 'ressarcimento_cobrancas_dados.id')
                ->select('ressarcimento_recebimentos.id as id')
                ->where('ressarcimento_cobrancas_dados.referencia', $referencia)
                ->where('ressarcimento_cobrancas_dados.ressarcimento_orgao_id', $orgao_id)
                ->get();

            //Varrer para alterar individualmente
            foreach ($registros as $registro) {
                $data = array();

                $id = $registro['id'];
                $data['data_recebimento'] = $request['data_recebimento'];
                $data['valor_recebido'] = $request['valor_recebido_'.$id];
                $data['saldo_restante'] = $request['saldo_restante_'.$id];
                $data['guia_recolhimento'] = $request['guia_recolhimento'];
                $data['documento'] = $request['documento'];

                RessarcimentoRecebimento::find($id)->update($data);
            }

            return [];
        } catch (\Exception $e) {
            throw new \Exception('Erro ao processar:'.$e, 0, $e);
        }
    }

    public function dados_modal($referencia)
    {
        // Data
        $data = array();

        // Referências
        $data['referencias'] = RessarcimentoReferencia::all();

        // Órgãos
        if ($referencia != 'ref') {
            $data['orgaos'] = RessarcimentoCobrancaDado::select('ressarcimento_orgao_id as id', 'orgao_name as name')
                ->distinct('orgao_name as name')
                ->where('referencia', $referencia)
                ->get();
        }

        return $data;
    }

    public function registros_alterar($referencia, $orgao_id)
    {
        $registros = RessarcimentoCobrancaDado::join('ressarcimento_referencias', 'ressarcimento_referencias.id', 'ressarcimento_cobrancas_dados.ressarcimento_referencia_id')
            ->join('ressarcimento_orgaos', 'ressarcimento_orgaos.id', 'ressarcimento_cobrancas_dados.ressarcimento_orgao_id')
            ->join('ressarcimento_militares', 'ressarcimento_militares.id', 'ressarcimento_cobrancas_dados.ressarcimento_militar_id')
            ->join('ressarcimento_pagamentos', 'ressarcimento_pagamentos.id', 'ressarcimento_cobrancas_dados.ressarcimento_pagamento_id')
            ->join('ressarcimento_recebimentos', 'ressarcimento_recebimentos.ressarcimento_cobranca_dado_id', 'ressarcimento_cobrancas_dados.id')
            ->select(
                'ressarcimento_cobrancas_dados.militar_posto_graduacao as posto_graduacao',
                'ressarcimento_cobrancas_dados.militar_nome as nome',
                'ressarcimento_cobrancas_dados.militar_rg as rg',
                'ressarcimento_cobrancas_dados.listagem_valor_total as valor',
                'ressarcimento_cobrancas_dados.orgao_name as orgao',
                'ressarcimento_cobrancas_dados.referencia as referencia',
                'ressarcimento_recebimentos.id as id',
                'ressarcimento_recebimentos.data_recebimento as data_recebimento',
                'ressarcimento_recebimentos.valor_recebido as valor_recebido',
                'ressarcimento_recebimentos.saldo_restante as saldo_restante',
                'ressarcimento_recebimentos.guia_recolhimento as guia_recolhimento',
                'ressarcimento_recebimentos.documento as documento'
            )
            ->where('ressarcimento_cobrancas_dados.referencia', $referencia)
            ->where('ressarcimento_cobrancas_dados.ressarcimento_orgao_id', $orgao_id)
            ->orderby('ressarcimento_cobrancas_dados.orgao_name')
            ->get();

        return $registros;
    }
}
