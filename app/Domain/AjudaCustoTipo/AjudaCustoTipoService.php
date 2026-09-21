<?php

namespace App\Domain\AjudaCustoTipo;

class AjudaCustoTipoService
{
    public function __construct(
        private AjudaCustoTipoRepository $repository
    ) {}

    public function getAjudaCustoTipos()
    {
        return $this->repository->all();
    }
}
