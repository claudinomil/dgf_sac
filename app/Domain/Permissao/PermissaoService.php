<?php

namespace App\Domain\Permissao;

class PermissaoService
{
    public function __construct(
        private PermissaoRepository $repository
    ) {}

    public function getPermissoes()
    {
        return $this->repository->all();
    }

    public function getPermissoesGrupo(int $grupo_id)
    {
        return $this->repository->getPermissoesGrupo($grupo_id);
    }
}
