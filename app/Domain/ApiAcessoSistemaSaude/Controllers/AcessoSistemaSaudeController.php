<?php

namespace App\Domain\ApiAcessoSistemaSaude\Controllers;

use App\Domain\ApiAcessoSistemaSaude\Requests\AcessoSistemaSaudeRequest;
use App\Domain\ApiAcessoSistemaSaude\Services\AcessoSistemaSaudeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AcessoSistemaSaudeController
{
    public function __construct(
        private readonly AcessoSistemaSaudeService $acessoSistemaSaudeService
    ) {
    }

    public function consultar(AcessoSistemaSaudeRequest $request): JsonResponse
    {
        $api_acesso_sistema_saude_usuario_id = $request->user()->id;

        $dados = $this->acessoSistemaSaudeService->consultar($request->validated('cpf'), $api_acesso_sistema_saude_usuario_id);

        if ($dados === null) {
            return response()->json([
                'success' => false,
                'message' => 'Titular não encontrado.',
                'error' => [
                    'code' => 404,
                    'message' => 'Não foi encontrado militar cadastrado para o CPF informado.'
                ],
                'content' => null,
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Consulta realizada com sucesso.',
            'error' => null,
            'content' => $dados,
        ], 200);
    }
    
    public function retornar_controle(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $registros = $this->acessoSistemaSaudeService->retornar_controle();
            
            return response()->json(['success' => $registros]);
        }
    }
}