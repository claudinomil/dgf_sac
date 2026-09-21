<?php

namespace App\Domain\Escolaridade;

class EscolaridadeService
{
    public function __construct(
        private EscolaridadeRepository $repository
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }
}
