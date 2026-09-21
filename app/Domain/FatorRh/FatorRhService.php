<?php

namespace App\Domain\FatorRh;

class FatorRhService
{
    public function __construct(
        private FatorRhRepository $repository
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }
}
