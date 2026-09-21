<?php

namespace App\Domain\PrestandoServico;

use App\Models\Unidade;

class PrestandoServicoRepository
{
    public function all()
    {
        return Unidade::orderby('name')->get();
    }
}
