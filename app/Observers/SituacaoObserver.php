<?php

namespace App\Observers;

use App\Models\Situacao;
use App\Domain\Transacao\TransacaoService;

class SituacaoObserver
{
    public function __construct(private TransacaoService $transacaoService)
    {}

    public function created(Situacao $situacao)
    {
        $this->transacaoService->transacao(1, 1, 'situacoes', $situacao->toArray(), []);
    }

    public function updated(Situacao $situacao)
    {
        //$this->transacaoService->transacao(1, 2, 'situacoes', $situacao->getChanges(), $situacao->getOriginal());
        $this->transacaoService->transacao(1, 2, 'situacoes', $situacao->toArray(), $situacao->getOriginal());
    }

    public function deleted(Situacao $situacao)
    {
        $this->transacaoService->transacao(1, 3, 'situacoes', $situacao->toArray(), []);
    }
}
