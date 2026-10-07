<?php

namespace App\Domain\PensaoTipo;

use App\Models\PensaoTipo;

class PensaoTipoRepository
{
    public function all()
    {
        return PensaoTipo::orderBy('name')->get();
    }
}
