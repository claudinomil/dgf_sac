<?php

namespace App\Domain\Naturalidade;

use App\Models\Naturalidade;

class NaturalidadeRepository
{
    public function all()
    {
        return Naturalidade::orderby('name')->get();
    }
}
