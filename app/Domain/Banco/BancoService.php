<?php

namespace App\Domain\Banco;

class BancoService
{
    public function __construct(
        private BancoRepository $repository
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }
}
