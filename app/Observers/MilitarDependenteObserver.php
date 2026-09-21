<?php

namespace App\Observers;

use App\Models\MilitarDependente;
use App\Domain\Transacao\TransacaoService;

class MilitarDependenteObserver
{
    public function __construct(private TransacaoService $transacaoService)
    {}

    public function created(MilitarDependente $militar_dependente)
    {
        $this->transacaoService->transacao(1, 1, 'militares_dependentes', $militar_dependente->toArray(), []);
    }

    public function updated(MilitarDependente $militar_dependente)
    {
        //$this->transacaoService->transacao(1, 2, 'militares_dependentes', $militar_dependente->getChanges(), $militar_dependente->getOriginal());
        $this->transacaoService->transacao(1, 2, 'militares_dependentes', $militar_dependente->toArray(), $militar_dependente->getOriginal());
    }

    public function deleted(MilitarDependente $militar_dependente)
    {
        $this->transacaoService->transacao(1, 3, 'militares_dependentes', $militar_dependente->toArray(), []);
    }
}
