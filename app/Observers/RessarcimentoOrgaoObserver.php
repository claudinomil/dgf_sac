<?php

namespace App\Observers;

use App\Domain\Transacao\TransacaoService;
use App\Models\RessarcimentoOrgao;

class RessarcimentoOrgaoObserver
{
    private $transacaoService;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->transacaoService = $transacaoService;
    }

    // public function created(RessarcimentoOrgao $ressarcimento_orgao)
    // {
    //     $this->transacaoService->transacao(1, 1, 'ressarcimento_orgaos', $ressarcimento_orgao->toArray(), []);
    // }

    public function updated(RessarcimentoOrgao $ressarcimento_orgao)
    {
        $this->transacaoService->transacao(1, 2, 'ressarcimento_orgaos', $ressarcimento_orgao->getChanges(), $ressarcimento_orgao->getOriginal());
    }
}
