<?php

namespace App\Domain\ApiAcessoSistemaSaude\Controllers;

use App\Domain\ApiAcessoSistemaSaude\Requests\AcessoSistemaSaudeRequest;
use App\Domain\ApiAcessoSistemaSaude\Services\AcessoSistemaSaudeService;
use Illuminate\Http\JsonResponse;

class AcessoSistemaSaudeController
{
    public function __construct(
        private readonly AcessoSistemaSaudeService $acessoSistemaSaudeService
    ) {
    }

    public function consultar(AcessoSistemaSaudeRequest $request): JsonResponse {
        $dados = $this->acessoSistemaSaudeService->consultar($request->validated('cpf'));

        if ($dados === null) {
            return response()->json([
                'success' => false,
                'error' => [
                    'code' => 404,
                    'message' => 'Titular não encontrado.'
                ]
            ], 404);
        }

        return response()->json([
            'success' => true,
            'content' => $dados,
        ], 200);
    }
}
