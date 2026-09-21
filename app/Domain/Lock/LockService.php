<?php

namespace App\Domain\Lock;

use Illuminate\Support\Facades\DB;

class LockService
{
    public function __construct(
        private LockRepository $repository
    ) {}

    public function bloquear(string $tabela, int $registro_id, int $user_id)
    {
        return DB::transaction(function () use ($tabela, $registro_id, $user_id) {

            $lock = $this->repository->findForUpdate($tabela, $registro_id);

            $tempoLimite = now()->subMinutes(1);

            if ($lock) {
                if ($lock->user_id != $user_id && $lock->updated_at > $tempoLimite) {
                    throw new \Exception('Registro em edição por outro usuário');
                }

                $this->repository->update($lock->id, [
                    'user_id' => $user_id,
                    'updated_at' => now()
                ]);
            } else {
                $this->repository->create([
                    'tabela' => $tabela,
                    'registro_id' => $registro_id,
                    'user_id' => $user_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            return true;
        });
    }

    public function desbloquear(string $tabela, int $registro_id, int $user_id)
    {
        $this->repository->delete($tabela, $registro_id, $user_id);
    }

    public function validar(string $tabela, int $registro_id, int $user_id)
    {
        $lock = $this->repository->find($tabela, $registro_id);

        if (!$lock || $lock->user_id != $user_id) {
            throw new \Exception('Registro não está bloqueado por você, feche o formulário e tente novamente');
        }
    }
}
