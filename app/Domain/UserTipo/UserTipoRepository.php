<?php

namespace App\Domain\UserTipo;

use App\Models\UserTipo;

class UserTipoRepository
{
    public function all()
    {
        return UserTipo::orderBy('name')->get();
    }
}
