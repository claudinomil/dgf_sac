<?php

namespace App\Domain\SexoBiologico;

use App\Models\SexoBiologico;

class SexoBiologicoRepository
{
    public function all()
    {
        return SexoBiologico::orderby('name')->get();
    }
}
