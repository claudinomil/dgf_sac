<?php

namespace App\Domain\EstadoCivil;

use App\Models\EstadoCivil;

class EstadoCivilRepository
{
    public function all()
    {
        return EstadoCivil::orderby('name')->get();
    }
}
