<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Autenticação - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Autenticação - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// Fazer Login
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    // Fazer Logout
    Route::post('logout', [AuthController::class, 'logout']);
});

// Esqueceu sua senha
Route::prefix('password')->group(function () {
    Route::post('/forgot', [AuthController::class, 'forgot_password']);
});

// Autenticação - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Autenticação - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

// ApiAcessoSistemaSaude - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// ApiAcessoSistemaSaude - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::prefix('v1')->group(function () {
    // Autenticação da integração
    Route::post('/auth/token', [App\Domain\ApiAcessoSistemaSaude\Controllers\AuthController::class, 'token'])->middleware('throttle:5,1');

    // Endpoints protegidos
    Route::middleware(['auth:sanctum', 'ability:consultar-sistema-saude', 'throttle:10,1'])->group(function () {
        Route::post('/acesso_sistema_saude/consultar', [App\Domain\ApiAcessoSistemaSaude\Controllers\AcessoSistemaSaudeController::class, 'consultar']);
    });
});
// ApiAcessoSistemaSaude - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
// ApiAcessoSistemaSaude - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
