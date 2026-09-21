<?php

namespace App\Domain\AjudaCustoTipo;

use App\Models\AjudaCustoTipo;

class AjudaCustoTipoRepository
{
    public function all()
    {
        return AjudaCustoTipo::orderBy('name')->get();
    }
}
