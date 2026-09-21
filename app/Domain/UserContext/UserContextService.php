<?php

/*
Usar no sistema

Exemplos:

        1. Ver permissões
        $permissoes = session('userContext.permissoes');

        2. Ver módulos
        $modulos = session('userContext.modulos');

        3. Blade
        @foreach(session('userContext.modulos') as $modulo)
            <li>{{ $modulo->nome }}</li>
        @endforeach

        4. API também pode usar (podemos retornar junto no login)
        {
            'token': '...',
            'user': {},
            'context': {}
        }
        Assim o app mobile também recebe tudo.
*/

namespace App\Domain\UserContext;

use App\Domain\Grupo\GrupoService;
use App\Domain\User\UserService;
use App\Domain\Modulo\ModuloService;
use App\Domain\Submodulo\SubmoduloService;
use App\Domain\Permissao\PermissaoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserContextService
{
    public function __construct(
        private UserService $userService,
        private ModuloService $moduloService,
        private SubmoduloService $submoduloService,
        private PermissaoService $permissaoService,
        private GrupoService $grupoService
    ) {}

    public function load(int $user_id, int $grupo_id)
    {
        $user = $this->userService->getUser($user_id);
        $modulos = $this->moduloService->getModulosMenu();
        $submodulos = $this->submoduloService->getSubmodulosMenu();
        $permissoes = $this->permissaoService->getPermissoesGrupo($grupo_id);
        $permissoes_situacoes = $this->grupoService->getPermissoesSituacoes($grupo_id);

        return [
            'user' => $user,
            'modulos' => $modulos,
            'submodulos' => $submodulos,
            'permissoes' => $permissoes,
            'permissoes_situacoes' => $permissoes_situacoes
        ];
    }

    public function refresh()
    {
        $user = Auth::user();

        $context = $this->load($user->id, $user->grupo_id);

        Session::put('userContext', $context);

        return $context;
    }
}
