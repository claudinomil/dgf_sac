<?php

namespace App\Domain\PensaoTipo;

class PensaoTipoService
{
    public function __construct(
        private PensaoTipoRepository $repository
    ) {}

    public function getPensaoTipos()
    {
        return $this->repository->all();
    }
}