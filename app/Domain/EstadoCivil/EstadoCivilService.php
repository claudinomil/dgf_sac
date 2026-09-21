<?php

namespace App\Domain\EstadoCivil;

class EstadoCivilService
{
    public function __construct(
        private EstadoCivilRepository $repository
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }
}
