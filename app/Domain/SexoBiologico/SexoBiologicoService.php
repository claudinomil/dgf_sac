<?php

namespace App\Domain\SexoBiologico;

class SexoBiologicoService
{
    public function __construct(
        private SexoBiologicoRepository $repository
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }
}
