<?php

namespace App\Observers;

use App\Models\MilitarFundoSaude;
use App\Domain\Transacao\TransacaoService;

class MilitarFundoSaudeObserver
{
    public function __construct(private TransacaoService $transacaoService)
    {}

    public function created(MilitarFundoSaude $militar_fundo_saude)
    {
        $this->transacaoService->transacao(1, 1, 'militares_fundos_saude', $militar_fundo_saude->toArray(), []);
    }

    public function updated(MilitarFundoSaude $militar_fundo_saude)
    {
        //$this->transacaoService->transacao(1, 2, 'militares_fundos_saude', $militar_fundo_saude->getChanges(), $militar_fundo_saude->getOriginal());
        $this->transacaoService->transacao(1, 2, 'militares_fundos_saude', $militar_fundo_saude->toArray(), $militar_fundo_saude->getOriginal());
    }
}
