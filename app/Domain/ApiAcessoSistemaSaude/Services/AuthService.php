<?php

namespace App\Domain\ApiAcessoSistemaSaude\Services;

use App\Domain\ApiAcessoSistemaSaude\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(private readonly AuthRepository $repository)
    {}

    public function autenticar(string $usuario, string $senha): ?array
    {
        $integracao = $this->repository->buscarPorUsuario($usuario);

        if (!$integracao || !$integracao->ativo || !Hash::check($senha, $integracao->password)) {
            return null;
        }

        $expiraEm = now()->addMinutes(1);

        $token = $integracao->createToken('api-acesso-fundo-saude', ['consultar-sistema-saude'], $expiraEm);

        return [
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'expires_at' => $expiraEm->toIso8601String(),
        ];
    }
}
