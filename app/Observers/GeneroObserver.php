<?php

namespace App\Observers;

use App\Models\Genero;
use App\Domain\Transacao\TransacaoService;

class GeneroObserver
{
    public function __construct(private TransacaoService $transacaoService)
    {}

    public function created(Genero $genero)
    {
        $this->transacaoService->transacao(1, 1, 'generos', $genero->toArray(), []);
    }

    public function updated(Genero $genero)
    {
        //$this->transacaoService->transacao(1, 2, 'generos', $genero->getChanges(), $genero->getOriginal());
        $this->transacaoService->transacao(1, 2, 'generos', $genero->toArray(), $genero->getOriginal());
    }

    public function deleted(Genero $genero)
    {
        $this->transacaoService->transacao(1, 3, 'generos', $genero->toArray(), []);
    }
}
