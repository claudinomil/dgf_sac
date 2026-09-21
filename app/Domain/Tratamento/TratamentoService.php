<?php

namespace App\Domain\Tratamento;

class TratamentoService
{
    public function __construct(
        private TratamentoRepository $repository
    ) {}

    public function getTratamentos($limit=null)
    {
        return $this->repository->index($limit);
    }

    public function getTratamento($id)
    {
        return $this->repository->find($id);
    }
}
