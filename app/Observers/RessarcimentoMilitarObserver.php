<?php

namespace App\Observers;

use App\Models\RessarcimentoMilitar;
use App\Domain\Transacao\TransacaoService;

class RessarcimentoMilitarObserver
{
    private $transacaoService;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->transacaoService = $transacaoService;
    }
    
    public function updated(RessarcimentoMilitar $ressarcimento_militar)
    {
        $this->transacaoService->transacao(1, 2, 'ressarcimento_militares', $ressarcimento_militar->toArray(), $ressarcimento_militar->getOriginal());
    }

    public function deleted(RessarcimentoMilitar $ressarcimento_militar)
    {
        $this->transacaoService->transacao(1, 3, 'ressarcimento_militares', $ressarcimento_militar->toArray(), []);
    }
}
