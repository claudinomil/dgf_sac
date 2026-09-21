<?php

namespace App\Domain\Submodulo;

class SubmoduloService
{
    public function __construct(
        private SubmoduloRepository $repository
    ) {}

    public function getSubmodulos()
    {
        return $this->repository->all();
    }

    public function getSubmodulosMenu()
    {
        return $this->repository->getSubmodulosMenu();
    }

    public function getSubmodulosGradeGrupos()
    {
        return $this->repository->getSubmodulosGradeGrupos();
    }

    public function getSubmoduloPrefixPermissao($prefix_permissao)
    {
        return $this->repository->getSubmoduloPrefixPermissao($prefix_permissao);
    }

    public function getColumnListing($prefix_permissao)
    {
        return $this->repository->getColumnListing($prefix_permissao);
    }
}
