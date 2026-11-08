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
    
    public function updated(RessarcimentoConfiguracao $ressarcimento_configuracao)
    {
        $this->transacaoService->transacao(1, 2, 'ressarcimento_configuracoes', $ressarcimento_configuracao->toArray(), $ressarcimento_configuracao->getOriginal());
    }
}
