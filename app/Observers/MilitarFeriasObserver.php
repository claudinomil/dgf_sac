<?php

namespace App\Observers;

use App\Models\MilitarFerias;
use App\Domain\Transacao\TransacaoService;

class MilitarFeriasObserver
{
    private $transacaoService;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->transacaoService = $transacaoService;
    }

    public function created(MilitarFerias $militar_ferias)
    {
        $this->transacaoService->transacao(1, 1, 'militares_ferias', $militar_ferias->toArray(), []);
    }

    public function updated(MilitarFerias $militar_ferias)
    {
        //$this->transacaoService->transacao(1, 2, 'militares_ferias', $militar_ferias->getChanges(), $militar_ferias->getOriginal());
        $this->transacaoService->transacao(1, 2, 'militares_ferias', $militar_ferias->toArray(), $militar_ferias->getOriginal());
    }

    public function deleted(MilitarFerias $militar_ferias)
    {
        $this->transacaoService->transacao(1, 3, 'militares_ferias', $militar_ferias->toArray(), []);
    }
}
