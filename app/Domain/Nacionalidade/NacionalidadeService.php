<?php

namespace App\Domain\Nacionalidade;

class NacionalidadeService
{
    public function __construct(
        private NacionalidadeRepository $repository
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }
}
