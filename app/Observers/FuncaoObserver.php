<?php

namespace App\Observers;

use App\Models\Funcao;
use App\Domain\Transacao\TransacaoService;

class FuncaoObserver
{
    public function __construct(private TransacaoService $transacaoService)
    {}

    public function created(Funcao $funcao)
    {
        $this->transacaoService->transacao(1, 1, 'funcoes', $funcao->toArray(), []);
    }

    public function updated(Funcao $funcao)
    {
        //$this->transacaoService->transacao(1, 2, 'funcoes', $funcao->getChanges(), $funcao->getOriginal());
        $this->transacaoService->transacao(1, 2, 'funcoes', $funcao->toArray(), $funcao->getOriginal());
    }

    public function deleted(Funcao $funcao)
    {
        $this->transacaoService->transacao(1, 3, 'funcoes', $funcao->toArray(), []);
    }
}
