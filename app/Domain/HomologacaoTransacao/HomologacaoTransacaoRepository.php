<?php

namespace App\Domain\HomologacaoTransacao;

use App\Models\HomologacaoTransacao;
use App\Models\User;

class HomologacaoTransacaoRepository
{
    public function index(int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Return
        return HomologacaoTransacao::join('submodulos', 'submodulos.id', 'homologacao_transacoes.submodulo_id')
            ->join('users', 'users.id', 'homologacao_transacoes.user_id')
            ->select(
                'homologacao_transacoes.*',
                'submodulos.name as submoduloName',
                'users.name as userName'
            )
            ->where('users.id', '!=', 1)
            ->orderby('homologacao_transacoes.data')
            ->orderby('users.name')
            ->limit($limit)
            ->get();
    }

    public function dados_users()
    {
        // Return
        return User::leftJoin('homologacao_transacoes', 'homologacao_transacoes.user_id', '=', 'users.id')
            ->selectRaw("
                users.name as userName,
                SUM(CASE WHEN homologacao_transacoes.operacao = 'Consulta' THEN 1 ELSE 0 END) as c,
                SUM(CASE WHEN homologacao_transacoes.operacao = 'Inclusão' THEN 1 ELSE 0 END) as i,
                SUM(CASE WHEN homologacao_transacoes.operacao = 'Alteração' THEN 1 ELSE 0 END) as a,
                SUM(CASE WHEN homologacao_transacoes.operacao = 'Exclusão' THEN 1 ELSE 0 END) as e,
                SUM(CASE WHEN homologacao_transacoes.operacao IN ('Inclusão', 'Alteração', 'Exclusão') THEN 1 ELSE 0 END) as iae,
                COUNT(homologacao_transacoes.id) as tot
            ")
            ->where('users.id', '!=', 1)
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('iae')
            ->orderByDesc('tot')
            ->get();
    }
}
