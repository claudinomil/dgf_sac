<?php

namespace App\Domain\Modulo;

class ModuloService
{
    public function __construct(
        private ModuloRepository $repository
    ) {}

    public function getModulosMenu()
    {
        return $this->repository->getModulosMenu();
    }
}
