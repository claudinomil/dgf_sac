<?php

namespace App\Domain\Operacao;

class OperacaoService
{
    public function __construct(
        private OperacaoRepository $repository
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getOperacoes($limit=null)
    {
        return $this->repository->index($limit);
    }
}
