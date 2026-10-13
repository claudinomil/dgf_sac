<?php

namespace App\Http\Controllers\Web;

use App\Domain\HomologacaoSolicitacao\HomologacaoSolicitacaoService;
use App\Domain\User\UserService;
use App\Http\Controllers\Controller;

class DesenvolvimentoController extends Controller
{
    public function __construct(
        private HomologacaoSolicitacaoService $homologacaoSolicitacoesService,
        private UserService $userService
    ) {}

    public function index()
    {
        $solicitacoes = $this->homologacaoSolicitacoesService->getHomologacaoSolicitacoes(1000);
        $users = $this->userService->getUsers(1000);

        return view('desenvolvimento.index', compact(['solicitacoes', 'users']));
    }
}