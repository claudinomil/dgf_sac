<?php

namespace App\Observers;

use App\Models\RessarcimentoRecebimento;
use App\Domain\Transacao\TransacaoService;

class RessarcimentoRecebimentoObserver
{
    private $transacaoService;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->transacaoService = $transacaoService;
    }

    public function updated(RessarcimentoRecebimento $ressarcimento_recebimento)
    {
        $this->transacaoService->transacao(1, 2, 'ressarcimento_recebimentos', $ressarcimento_recebimento->getChanges(), $ressarcimento_recebimento->getOriginal());
    }
}
