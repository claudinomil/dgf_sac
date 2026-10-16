<?php

namespace App\Domain\HomologacaoTransacao;

use App\Models\HomologacaoTransacao;

class HomologacaoTransacaoRepository
{
    public function index(int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;



        // Verificar se Usuário é Claudino ou outros
        if (session('userContext.user.id') != 1) {
            return collect();
        }



        // Return
        return HomologacaoTransacao::join('submodulos', 'submodulos.id', 'homologacao_transacoes.submodulo_id')
            ->join('users', 'users.id', 'homologacao_transacoes.user_id')
            ->select(
                'homologacao_transacoes.*',
                'submodulos.name as submoduloName',
                'users.name as userName'
            )
            ->orderby('homologacao_transacoes.data')
            ->orderby('users.name')
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
        $registros = HomologacaoTransacao::join('submodulos', 'submodulos.id', 'homologacao_transacoes.submodulo_id')
            ->join('users', 'users.id', 'homologacao_transacoes.user_id')
            ->select(
                'homologacao_transacoes.*',
                'submodulos.name as submoduloName',
                'users.name as userName'
            )
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
            })
            ->orderby('homologacao_transacoes.data')
            ->orderby('users.name')
            ->limit($limit)
            ->get();

        return $registros;
    }
}
