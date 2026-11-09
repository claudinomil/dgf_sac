<?php

namespace App\Domain\HomologacaoTransacao;

use App\Domain\Lock\LockService;

class HomologacaoTransacaoService
{
    public function __construct(
        private HomologacaoTransacaoRepository $repository,
        private LockService $lockService
    ) {}

    public function getHomologacaoTransacoes($limit = null)
    {
        return $this->repository->index($limit);
    }
    
    public function getDadosUsers()
    {
        return $this->repository->dados_users();
    }
}
