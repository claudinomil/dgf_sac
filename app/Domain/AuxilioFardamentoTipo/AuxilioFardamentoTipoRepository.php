<?php

namespace App\Domain\AuxilioFardamentoTipo;

use App\Models\AuxilioFardamentoTipo;

class AuxilioFardamentoTipoRepository
{
    public function all()
    {
        return AuxilioFardamentoTipo::orderBy('name')->get();
    }
}
