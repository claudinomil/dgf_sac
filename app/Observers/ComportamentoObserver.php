<?php

namespace App\Observers;

use App\Models\Comportamento;
use App\Domain\Transacao\TransacaoService;

class ComportamentoObserver
{
    public function __construct(private TransacaoService $transacaoService)
    {}

    public function created(Comportamento $comportamento)
    {
        $this->transacaoService->transacao(1, 1, 'comportamentos', $comportamento->toArray(), []);
    }

    public function updated(Comportamento $comportamento)
    {
        //$this->transacaoService->transacao(1, 2, 'comportamentos', $comportamento->getChanges(), $comportamento->getOriginal());
        $this->transacaoService->transacao(1, 2, 'comportamentos', $comportamento->toArray(), $comportamento->getOriginal());
    }

    public function deleted(Comportamento $comportamento)
    {
        $this->transacaoService->transacao(1, 3, 'comportamentos', $comportamento->toArray(), []);
    }
}
