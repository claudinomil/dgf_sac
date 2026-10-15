<?php

namespace App\Domain\ApiAcessoSistemaSaude\Repositories;

use App\Models\ApiAcessoSistemaSaude;

class AuthRepository
{
    public function buscarPorEmail(string $email): ?ApiAcessoSistemaSaude
    {
        return ApiAcessoSistemaSaude::query()
            ->where('email', $email)
            ->first();
    }
}
