<?php

namespace App\Observers;

use App\Models\Quadro;
use App\Domain\Transacao\TransacaoService;

class QuadroObserver
{
    public function __construct(private TransacaoService $transacaoService)
    {}

    public function created(Quadro $quadro)
    {
        $this->transacaoService->transacao(1, 1, 'quadros', $quadro->toArray(), []);
    }

    public function updated(Quadro $quadro)
    {
        //$this->transacaoService->transacao(1, 2, 'quadros', $quadro->getChanges(), $quadro->getOriginal());
        $this->transacaoService->transacao(1, 2, 'quadros', $quadro->toArray(), $quadro->getOriginal());
    }

    public function deleted(Quadro $quadro)
    {
        $this->transacaoService->transacao(1, 3, 'quadros', $quadro->toArray(), []);
    }
}
