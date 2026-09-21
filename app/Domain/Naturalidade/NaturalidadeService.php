<?php

namespace App\Domain\Naturalidade;

class NaturalidadeService
{
    public function __construct(
        private NaturalidadeRepository $repository
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }
}
