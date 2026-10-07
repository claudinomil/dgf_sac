<?php

namespace App\Observers;

use App\Models\MilitarPensao;
use App\Domain\Transacao\TransacaoService;

class MilitarPensaoObserver
{
    private $transacaoService;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->transacaoService = $transacaoService;
    }

    public function created(MilitarPensao $militar_pensao)
    {
        $this->transacaoService->transacao(1, 1, 'militares_pensoes', $militar_pensao->toArray(), []);
    }

    public function updated(MilitarPensao $militar_pensao)
    {
        $this->transacaoService->transacao(1, 2, 'militares_pensoes', $militar_pensao->toArray(), $militar_pensao->getOriginal());
    }

    public function deleted(MilitarPensao $militar_pensao)
    {
        $this->transacaoService->transacao(1, 3, 'militares_pensoes', $militar_pensao->toArray(), []);
    }
}
