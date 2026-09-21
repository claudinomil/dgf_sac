<?php

namespace App\Observers;

use App\Models\MilitarAjudaCusto;
use App\Domain\Transacao\TransacaoService;

class MilitarAjudaCustoObserver
{
    private $transacaoService;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->transacaoService = $transacaoService;
    }

    public function created(MilitarAjudaCusto $militar_ajuda_custo)
    {
        $this->transacaoService->transacao(1, 1, 'militares_ajudas_custos', $militar_ajuda_custo->toArray(), []);
    }

    public function updated(MilitarAjudaCusto $militar_ajuda_custo)
    {
        $this->transacaoService->transacao(1, 2, 'militares_ajudas_custos', $militar_ajuda_custo->toArray(), $militar_ajuda_custo->getOriginal());
    }

    public function deleted(MilitarAjudaCusto $militar_ajuda_custo)
    {
        $this->transacaoService->transacao(1, 3, 'militares_ajudas_custos', $militar_ajuda_custo->toArray(), []);
    }
}
