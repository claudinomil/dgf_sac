<?php

namespace App\Observers;

use App\Domain\Transacao\TransacaoService;
use App\Models\RessarcimentoConfiguracao;

class RessarcimentoConfiguracaoObserver
{
    private $transacaoService;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->transacaoService = $transacaoService;
    }

    // public function created(RessarcimentoConfiguracao $ressarcimento_configuracao)
    // {
    //     $this->transacaoService->transacao(1, 1, 'ressarcimento_configuracoes', $ressarcimento_configuracao->toArray(), []);
    // }

    public function updated(RessarcimentoConfiguracao $ressarcimento_configuracao)
    {
        $this->transacaoService->transacao(1, 2, 'ressarcimento_configuracoes', $ressarcimento_configuracao->getChanges(), $ressarcimento_configuracao->getOriginal());
    }
}
