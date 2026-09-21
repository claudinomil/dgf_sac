<?php

namespace App\Domain\TipoSanguineo;

class TipoSanguineoService
{
    public function __construct(
        private TipoSanguineoRepository $repository
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }
}
