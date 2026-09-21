<?php

namespace App\Domain\Escolaridade;

use App\Models\Escolaridade;

class EscolaridadeRepository
{
    public function all()
    {
        return Escolaridade::orderby('name')->get();
    }
}
