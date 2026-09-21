<?php

namespace App\Domain\Esfera;

class EsferaService
{
    public function __construct(
        private EsferaRepository $repository
    ) {}

    public function getEsferas($limit=null)
    {
        return $this->repository->index($limit);
    }

    public function getEsfera($id)
    {
        return $this->repository->find($id);
    }
}
