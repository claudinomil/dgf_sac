<?php

namespace App\Observers;

use App\Models\Graduacao;
use App\Domain\Transacao\TransacaoService;

class GraduacaoObserver
{
    public function __construct(private TransacaoService $transacaoService)
    {}

    public function created(Graduacao $graduacao)
    {
        $this->transacaoService->transacao(1, 1, 'graduacoes', $graduacao->toArray(), []);
    }

    public function updated(Graduacao $graduacao)
    {
        //$this->transacaoService->transacao(1, 2, 'graduacoes', $graduacao->getChanges(), $graduacao->getOriginal());
        $this->transacaoService->transacao(1, 2, 'graduacoes', $graduacao->toArray(), $graduacao->getOriginal());
    }

    public function deleted(Graduacao $graduacao)
    {
        $this->transacaoService->transacao(1, 3, 'graduacoes', $graduacao->toArray(), []);
    }
}
