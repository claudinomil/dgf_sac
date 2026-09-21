<?php

namespace App\Observers;

use App\Models\Parentesco;
use App\Domain\Transacao\TransacaoService;

class ParentescoObserver
{
    public function __construct(private TransacaoService $transacaoService)
    {}

    public function created(Parentesco $parentesco)
    {
        $this->transacaoService->transacao(1, 1, 'parentescos', $parentesco->toArray(), []);
    }

    public function updated(Parentesco $parentesco)
    {
        //$this->transacaoService->transacao(1, 2, 'parentescos', $parentesco->getChanges(), $parentesco->getOriginal());
        $this->transacaoService->transacao(1, 2, 'parentescos', $parentesco->toArray(), $parentesco->getOriginal());
    }

    public function deleted(Parentesco $parentesco)
    {
        $this->transacaoService->transacao(1, 3, 'parentescos', $parentesco->toArray(), []);
    }
}
