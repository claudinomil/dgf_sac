<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Domain\User\UserService;
use App\Domain\UserContext\UserContextService;
use App\Http\Requests\AvatarUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(
        private UserService $userService,
        private UserContextService $userContextService
    ) {}

    public function updateAvatar(AvatarUpdateRequest $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $this->userService->updateAvatar(Auth::user()->id, $request);

            // Se alteração é no Usuário Logado chama Refresh do UserContext
            $this->userContextService->refresh();

            return response()->json(['success' => 'Avatar atualizado', 'avatar_url' => session('userContext.user.avatar')]);
        }
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $result = $this->userService->updatePassword(Auth::user()->id, $request->profille_current_password, $request->profille_password);

            if (!$result) {
                return response()->json(['error' => 'Senha atual incorreta']);
            }

            return response()->json(['success' => 'Senha atualizada']);
        }
    }
}
