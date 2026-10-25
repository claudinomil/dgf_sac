<?php

namespace App\Domain\ApiAcessoSistemaSaude\Controllers;

use App\Domain\ApiAcessoSistemaSaude\Requests\AuthRequest;
use App\Domain\ApiAcessoSistemaSaude\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController
{
    public function __construct(private readonly AuthService $service)
    {}

    public function token(AuthRequest $request): JsonResponse
    {
        $dados = $this->service->autenticar(
            $request->validated('usuario'),
            $request->validated('password')
        );

        if ($dados === null) {
            return response()->json([
                'success' => false,
                'error' => [
                    'autenticacao' => 'Credenciais inválidas ou integração inativa.',
                ],
            ], 401);
        }

        return response()->json([
            'success' => true,
            'error' => null,
            'content' => $dados,
        ]);
    }
}
