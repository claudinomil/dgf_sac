<?php

namespace App\Observers;

use App\Models\User;
use App\Domain\Transacao\TransacaoService;

class UserObserver
{
    private $transacaoService;

    public function __construct(TransacaoService $transacaoService)
    {
        $this->transacaoService = $transacaoService;
    }

    public function created(User $user)
    {
        $this->transacaoService->transacao(1, 1, 'users', $user->toArray(), []);
    }

    public function updated(User $user)
    {
        $this->transacaoService->transacao(1, 2, 'users', $user->getChanges(), $user->getOriginal());
    }

    public function deleted(User $user)
    {
        $this->transacaoService->transacao(1, 3, 'users', $user->toArray(), []);
    }
}
