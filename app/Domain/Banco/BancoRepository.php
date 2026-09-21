<?php

namespace App\Domain\Banco;

use App\Models\Banco;

class BancoRepository
{
    public function all()
    {
        return Banco::orderby('name')->get();
    }
}
