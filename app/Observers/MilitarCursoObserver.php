<?php

namespace App\Observers;

use App\Models\MilitarCurso;
use App\Domain\Transacao\TransacaoService;

class MilitarCursoObserver
{
    private $transacaoService;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->transacaoService = $transacaoService;
    }

    public function created(MilitarCurso $militar_curso)
    {
        $this->transacaoService->transacao(1, 1, 'militares_cursos', $militar_curso->toArray(), []);
    }

    public function updated(MilitarCurso $militar_curso)
    {
        //$this->transacaoService->transacao(1, 2, 'militares_cursos', $militar_curso->getChanges(), $militar_curso->getOriginal());
        $this->transacaoService->transacao(1, 2, 'militares_cursos', $militar_curso->toArray(), $militar_curso->getOriginal());
    }

    public function deleted(MilitarCurso $militar_curso)
    {
        $this->transacaoService->transacao(1, 3, 'militares_cursos', $militar_curso->toArray(), []);
    }
}
