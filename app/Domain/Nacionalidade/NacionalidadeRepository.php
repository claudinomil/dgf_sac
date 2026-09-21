<?php

namespace App\Domain\Nacionalidade;

use App\Models\Nacionalidade;

class NacionalidadeRepository
{
    public function all()
    {
        return Nacionalidade::orderby('name')->get();
    }
}
