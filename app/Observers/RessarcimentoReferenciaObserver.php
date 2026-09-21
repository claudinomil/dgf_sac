<?php

namespace App\Observers;

use App\Models\RessarcimentoReferencia;
use App\Domain\Transacao\TransacaoService;

class RessarcimentoReferenciaObserver
{
    private $transacaoService;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->transacaoService = $transacaoService;
    }

    public function created(RessarcimentoReferencia $ressarcimento_referencia)
    {
        $this->transacaoService->transacao(1, 1, 'ressarcimento_referencias', $ressarcimento_referencia->toArray(), []);
    }

    public function updated(RessarcimentoReferencia $ressarcimento_referencia)
    {
        $this->transacaoService->transacao(1, 2, 'ressarcimento_referencias', $ressarcimento_referencia->getChanges(), $ressarcimento_referencia->getOriginal());
    }

    public function deleted(RessarcimentoReferencia $ressarcimento_referencia)
    {
        $this->transacaoService->transacao(1, 3, 'ressarcimento_referencias', $ressarcimento_referencia->toArray(), []);
    }
}
