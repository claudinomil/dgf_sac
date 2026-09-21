<?php

namespace App\Observers;

use App\Models\Militar;
use App\Domain\Transacao\TransacaoService;

class MilitarObserver
{
    private $transacaoService;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->transacaoService = $transacaoService;
    }

    public function created(Militar $militar)
    {
        $this->transacaoService->transacao(1, 1, 'militares', $militar->toArray(), []);
    }

    public function updated(Militar $militar)
    {
        //$this->transacaoService->transacao(1, 2, 'militares', $militar->getChanges(), $militar->getOriginal());
        $this->transacaoService->transacao(1, 2, 'militares', $militar->toArray(), $militar->getOriginal());
    }

    public function deleted(Militar $militar)
    {
        $this->transacaoService->transacao(1, 3, 'militares', $militar->toArray(), []);
    }
}
