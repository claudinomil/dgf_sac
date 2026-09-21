<?php

namespace App\Domain\TipoSanguineo;

use App\Models\TipoSanguineo;

class TipoSanguineoRepository
{
    public function all()
    {
        return TipoSanguineo::orderby('name')->get();
    }
}
