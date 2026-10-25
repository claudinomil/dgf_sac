<?php

namespace App\Domain\ApiAcessoSistemaSaude\Repositories;

use App\Models\ApiAcessoSistemaSaudeUsuario;

class AuthRepository
{
    public function buscarPorUsuario(string $usuario)
    {
        return ApiAcessoSistemaSaudeUsuario::query()
            ->where('usuario', $usuario)
            ->first();
    }
}
