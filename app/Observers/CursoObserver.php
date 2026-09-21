<?php

namespace App\Observers;

use App\Models\Curso;
use App\Domain\Transacao\TransacaoService;

class CursoObserver
{
    public function __construct(private TransacaoService $transacaoService)
    {}

    public function created(Curso $curso)
    {
        $this->transacaoService->transacao(1, 1, 'cursos', $curso->toArray(), []);
    }

    public function updated(Curso $curso)
    {
        $this->transacaoService->transacao(1, 2, 'cursos', $curso->toArray(), $curso->getOriginal());
    }

    public function deleted(Curso $curso)
    {
        $this->transacaoService->transacao(1, 3, 'cursos', $curso->toArray(), []);
    }
}
