<?php

namespace App\Domain\RessarcimentoFuncao;

class RessarcimentoFuncaoService
{
    public function __construct(
        private RessarcimentoFuncaoRepository $repository
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getRessarcimentoFuncoes($limit=null)
    {
        return $this->repository->index($limit);
    }

    public function getRessarcimentoFuncao($id)
    {
        return $this->repository->find($id);
    }
}
