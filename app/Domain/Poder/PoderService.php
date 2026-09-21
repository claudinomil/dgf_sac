<?php

namespace App\Domain\Poder;

class PoderService
{
    public function __construct(
        private PoderRepository $repository
    ) {}

    public function getPoderes($limit=null)
    {
        return $this->repository->index($limit);
    }

    public function getPoder($id)
    {
        return $this->repository->find($id);
    }
}
