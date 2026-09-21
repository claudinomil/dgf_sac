<?php

namespace App\Http\Controllers\Web;

use App\Domain\TokenService\TokenServiceService;
use App\Http\Controllers\Controller;

class TokenServiceController extends Controller
{
    public function __construct(
        private TokenServiceService $tokenServiceService
    ) {}

    public function gerar(string $scopo, int $id)
    {
        $token = $this->tokenServiceService->getGerar($scopo, $id);

        if (!$token) {
            return response()->json(['error' => 'Token não gerado']);
        }

        return response()->json(['success' => $token]);
    }

    public function validar(string $token)
    {
        $validado = $this->tokenServiceService->getValidar($token);

        if (!$validado) {
            return response()->json(['error' => 'Token não validado']);
        }

        return response()->json(['success' => $validado]);
    }

    public function scope(string $token)
    {
        $scope = $this->tokenServiceService->getScope($token);

        if (!$scope) {
            return response()->json(['error' => 'Scope não validado']);
        }

        return response()->json(['success' => $scope]);
    }

    public function id(string $token)
    {
        $id = $this->tokenServiceService->getId($token);

        if (!$id) {
            return response()->json(['error' => 'Id não validado']);
        }

        return response()->json(['success' => $id]);
    }
}
