<?php

namespace App\Observers;

use App\Models\Unidade;
use App\Domain\Transacao\TransacaoService;

class UnidadeObserver
{
    public function __construct(private TransacaoService $transacaoService)
    {}

    public function created(Unidade $unidade)
    {
        $this->transacaoService->transacao(1, 1, 'unidades', $unidade->toArray(), []);
    }

    public function updated(Unidade $unidade)
    {
        $this->transacaoService->transacao(1, 2, 'unidades', $unidade->toArray(), $unidade->getOriginal());
    }

    public function deleted(Unidade $unidade)
    {
        $this->transacaoService->transacao(1, 3, 'unidades', $unidade->toArray(), []);
    }
}
