<?php

namespace App\Observers;

use App\Models\MilitarAuxilioFardamento;
use App\Domain\Transacao\TransacaoService;

class MilitarAuxilioFardamentoObserver
{
    private $transacaoService;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->transacaoService = $transacaoService;
    }

    public function created(MilitarAuxilioFardamento $militar_auxilio_fardamento)
    {
        $this->transacaoService->transacao(1, 1, 'militares_auxilios_fardamentos', $militar_auxilio_fardamento->toArray(), []);
    }

    public function updated(MilitarAuxilioFardamento $militar_auxilio_fardamento)
    {
        $this->transacaoService->transacao(1, 2, 'militares_auxilios_fardamentos', $militar_auxilio_fardamento->toArray(), $militar_auxilio_fardamento->getOriginal());
    }

    public function deleted(MilitarAuxilioFardamento $militar_auxilio_fardamento)
    {
        $this->transacaoService->transacao(1, 3, 'militares_auxilios_fardamentos', $militar_auxilio_fardamento->toArray(), []);
    }
}
