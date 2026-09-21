<?php

namespace App\Domain\AuxilioFardamentoTipo;

class AuxilioFardamentoTipoService
{
    public function __construct(
        private AuxilioFardamentoTipoRepository $repository
    ) {}

    public function getAuxilioFardamentoTipos()
    {
        return $this->repository->all();
    }
}
