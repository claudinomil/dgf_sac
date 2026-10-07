<?php

namespace App\Observers;

use App\Models\MilitarTempoAverbado;
use App\Domain\Transacao\TransacaoService;

class MilitarTempoAverbadoObserver
{
    private $transacaoService;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->transacaoService = $transacaoService;
    }

    public function created(MilitarTempoAverbado $militar_tempo_averbado)
    {
        $this->transacaoService->transacao(1, 1, 'militares_tempos_averbados', $militar_tempo_averbado->toArray(), []);
    }

    public function updated(MilitarTempoAverbado $militar_tempo_averbado)
    {
        //$this->transacaoService->transacao(1, 2, 'militares_tempos_averbados', $militar_tempo_averbado->getChanges(), $militar_tempo_averbado->getOriginal());
        $this->transacaoService->transacao(1, 2, 'militares_tempos_averbados', $militar_tempo_averbado->toArray(), $militar_tempo_averbado->getOriginal());
    }

    public function deleted(MilitarTempoAverbado $militar_tempo_averbado)
    {
        $this->transacaoService->transacao(1, 3, 'militares_tempos_averbados', $militar_tempo_averbado->toArray(), []);
    }
}
