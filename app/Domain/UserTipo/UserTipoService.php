<?php

namespace App\Domain\UserTipo;

class UserTipoService
{
    public function __construct(
        private UserTipoRepository $repository
    ) {}

    public function getUserTipos()
    {
        return $this->repository->all();
    }
}
