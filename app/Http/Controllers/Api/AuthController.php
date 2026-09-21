<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domain\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function login(Request $request)
    {
        $request->validate([
            'user' => 'required|string',
            'password' => 'required'
        ]);

        $user = $this->authService->login(
            $request->user,
            $request->password
        );

        if (!$user) {
            return response()->json([
                'message' => 'Usuário ou senha inválidos'
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'user' => $user->user
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout realizado'
        ]);
    }

    public function forgot_password(Request $request)
    {
        $request->validate([
            'user' => 'required'
        ]);

        $result = $this->authService->forgotPassword($request->user);

        if (!$result['success']) {
            return response()->json([
                'message' => $result['message']
            ], 400);
        }

        return response()->json([
            'message' => $result['message']
        ]);
    }
}
