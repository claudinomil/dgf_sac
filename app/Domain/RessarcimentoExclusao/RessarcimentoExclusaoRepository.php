<?php

namespace App\Domain\RessarcimentoExclusao;

use App\Models\RessarcimentoCobranca;
use App\Models\RessarcimentoCobrancaDado;
use App\Models\RessarcimentoCobrancaPdfListagem;
use App\Models\RessarcimentoCobrancaPdfListagemDado;
use App\Models\RessarcimentoCobrancaPdfNota;
use App\Models\RessarcimentoCobrancaPdfOficio;
use App\Models\RessarcimentoConfiguracao;
use App\Models\RessarcimentoExclusao;
use App\Models\RessarcimentoMilitar;
use App\Models\RessarcimentoOrgao;
use App\Models\RessarcimentoPagamento;
use App\Models\RessarcimentoRecebimento;
use App\Models\RessarcimentoReferencia;

class RessarcimentoExclusaoRepository
{
    public function index(int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        return RessarcimentoExclusao::orderby('referencia', 'desc')->orderby('mes', 'desc')->orderby('parte', 'desc')->limit($limit)->get();
    }

    public function filter(string $array_dados, int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = RessarcimentoExclusao::select(['ressarcimento_exclusoes.*'])
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

    public function ultima_referencia()
    {
        $data = array();

        $data['referencia'] = RessarcimentoReferencia::join('ressarcimento_militares', 'ressarcimento_militares.referencia', '=', 'ressarcimento_referencias.referencia')
            ->select('ressarcimento_referencias.*')
            ->orderBy('ressarcimento_militares.referencia', 'desc')
            ->first();

        $data['militares'] = RessarcimentoMilitar::where('referencia', $data['referencia']['referencia'])->count();

        return $data;
    }

    public function dados_ressarcimento(string $referencia)
    {
        // Array de retorno
        $content = array();

        // Registros Órgãos
        $content['orgaos'] = RessarcimentoOrgao::join('ressarcimento_militares', 'ressarcimento_militares.lotacao_id', 'ressarcimento_orgaos.lotacao_id')
            ->select('ressarcimento_orgaos.*')
            ->distinct('ressarcimento_orgaos.lotacao_id')
            ->where('ressarcimento_militares.referencia', $referencia)
            ->get();

        // Registros Militares
        $content['militares'] = RessarcimentoMilitar::where('referencia', $referencia)->get();

        // Registros Pagamentos
        $content['pagamentos'] = RessarcimentoPagamento::where('referencia', $referencia)->get();

        // Registros Configurações
        $content['configuracoes'] = RessarcimentoConfiguracao::where('referencia', $referencia)->get();

        // Registros Cobrancas
        $content['cobrancas_dados'] = RessarcimentoCobrancaDado::where('referencia', $referencia)->get();

        // Registros Cobrancas PDFs Listagens
        $content['cobrancas_pdfs_listagens'] = RessarcimentoCobrancaPdfListagem::where('referencia', $referencia)->get();

        // Registros Cobrancas PDFs Notas
        $content['cobrancas_pdfs_notas'] = RessarcimentoCobrancaPdfNota::where('referencia', $referencia)->get();

        // Registros Cobrancas PDFs Ofícios
        $content['cobrancas_pdfs_oficios'] = RessarcimentoCobrancaPdfOficio::where('referencia', $referencia)->get();

        return $content;
    }

    /*
     * Deletar Cobrança de uma determinada Referência
     * Deletará registros de cobrança nas seguintes tabelas:
     * :: ressarcimento_cobrancas
     * :: ressarcimento_cobrancas_dados
     * :: ressarcimento_recebimentos
     * :: ressarcimento_cobrancas_pdfs_listagens
     * :: ressarcimento_cobrancas_pdfs_listagens_dados
     * :: ressarcimento_cobrancas_pdfs_notas
     * :: ressarcimento_cobrancas_pdfs_oficios
     * :: ressarcimento_pagamentos
     * :: ressarcimento_militares
     * :: ressarcimento_configuracoes
     * :: ressarcimento_referencias
     */
    public function deletar_cobranca(string $referencia)
    {
        // Apagando registros tabela ressarcimento_cobrancas
        RessarcimentoCobranca::where('referencia', $referencia)->delete();

        // Apagando registros tabela ressarcimento_cobrancas_dados
        $registros = RessarcimentoCobrancaDado::where('referencia', $referencia)->get();

        foreach ($registros as $registro) {
            $id_excluir = $registro['id'];

            RessarcimentoRecebimento::where('ressarcimento_cobranca_dado_id', $id_excluir)->delete();
            RessarcimentoCobrancaDado::where('id', $id_excluir)->delete();
        }

        // Apagando registros tabela ressarcimento_cobrancas_pdfs_listagens
        $registros = RessarcimentoCobrancaPdfListagem::where('referencia', $referencia)->get();

        foreach ($registros as $registro) {
            $id_excluir = $registro['id'];

            RessarcimentoCobrancaPdfListagemDado::where('ressarcimento_cobranca_pdf_listagem_id', $id_excluir)->delete();
            RessarcimentoCobrancaPdfListagem::where('id', $id_excluir)->delete();
        }

        // Apagando registros tabela ressarcimento_cobrancas_pdfs_notas
        RessarcimentoCobrancaPdfNota::where('referencia', $referencia)->delete();

        // Apagando registros tabela ressarcimento_cobrancas_pdfs_oficios
        RessarcimentoCobrancaPdfOficio::where('referencia', $referencia)->delete();

        // Apagando registros tabela ressarcimento_pagamentos
        RessarcimentoPagamento::where('referencia', $referencia)->delete();

        // Apagando registros tabela ressarcimento_militares
        RessarcimentoMilitar::where('referencia', $referencia)->delete();

        // Apagando registros tabela ressarcimento_configuracoes
        RessarcimentoConfiguracao::where('referencia', $referencia)->delete();

        // Apagando registros tabela ressarcimento_referencias
        RessarcimentoReferencia::where('referencia', $referencia)->delete();

        return true;
    }
}
