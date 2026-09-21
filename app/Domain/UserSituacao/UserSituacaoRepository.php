<?php

namespace App\Domain\UserSituacao;

use App\Models\UserSituacao;

class UserSituacaoRepository
{
    public function all()
    {
        return UserSituacao::orderBy('name')->get();
    }
}
