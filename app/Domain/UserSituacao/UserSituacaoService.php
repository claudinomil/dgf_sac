<?php

namespace App\Domain\UserSituacao;

class UserSituacaoService
{
    public function __construct(
        private UserSituacaoRepository $repository
    ) {}

    public function getUserSituacoes()
    {
        return $this->repository->all();
    }
}
