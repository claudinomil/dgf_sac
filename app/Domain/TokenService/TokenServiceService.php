<?php

namespace App\Domain\TokenService;

use App\Services\TokenService;

class TokenServiceService
{
    public function getGerar(string $scopo, int $id)
    {
        return TokenService::gerar($scopo, $id);
    }

    public function getValidar(string $token)
    {
        return TokenService::validar($token);
    }

    public function getScope(string $token)
    {
        return TokenService::scope($token);
    }

    public function getId(string $token)
    {
        return TokenService::id($token);
    }
}
