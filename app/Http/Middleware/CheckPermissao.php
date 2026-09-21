<?php

/*
Usar nas rotas:

    Route::get('/users', [UserController::class,'index'])->middleware('permissao:users.view');

    ou

    Route::middleware(['auth','permissao:users.view'])->group(function () {
        Route::get('/users',[UserController::class,'index']);
    });

    ou API

    Route::middleware(['auth:sanctum','permissao:users.view'])->group(function () {
        Route::get('/users',[UserController::class,'index']);
    });
*/

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermissao
{
    public function handle(Request $request, Closure $next, $permissao)
    {
        $user = $request->user();

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Não autenticado'], 200);
            }

            abort(401, 'Não autenticado');
        }

        $context = session('userContext');

        if (!$context) {
            return redirect('/login');
        }

        $permissoes = $context['permissoes'] ?? [];

        if (!in_array($permissao, $permissoes)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Sem permissão'], 200);
            }

            abort(403, 'Sem permissão');
        }

        return $next($request);
    }
}
