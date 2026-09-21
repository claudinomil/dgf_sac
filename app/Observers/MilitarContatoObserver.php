<?php

namespace App\Observers;

use App\Models\MilitarContato;
use App\Domain\Transacao\TransacaoService;

class MilitarContatoObserver
{
    private $transacaoService;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->transacaoService = $transacaoService;
    }

    public function created(MilitarContato $militar_contato)
    {
        $this->transacaoService->transacao(1, 1, 'militares_contatos', $militar_contato->toArray(), []);
    }

    public function updated(MilitarContato $militar_contato)
    {
        //$this->transacaoService->transacao(1, 2, 'militares_contatos', $militar_contato->getChanges(), $militar_contato->getOriginal());
        $this->transacaoService->transacao(1, 2, 'militares_contatos', $militar_contato->toArray(), $militar_contato->getOriginal());
    }

    public function deleted(MilitarContato $militar_contato)
    {
        $this->transacaoService->transacao(1, 3, 'militares_contatos', $militar_contato->toArray(), []);
    }
}
