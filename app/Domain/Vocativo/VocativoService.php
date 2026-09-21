<?php

namespace App\Domain\Vocativo;

class VocativoService
{
    public function __construct(
        private VocativoRepository $repository
    ) {}

    public function getVocativos($limit=null)
    {
        return $this->repository->index($limit);
    }

    public function getVocativo($id)
    {
        return $this->repository->find($id);
    }
}
