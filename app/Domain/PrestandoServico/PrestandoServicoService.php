<?php

namespace App\Domain\PrestandoServico;

class PrestandoServicoService
{
    public function __construct(
        private PrestandoServicoRepository $repository
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }
}
