<?php

namespace App\Domain\Lock;

use App\Models\Lock;

class LockRepository
{
    public function find(string $tabela, int $registro_id)
    {
        return Lock::where('tabela', $tabela)
            ->where('registro_id', $registro_id)
            ->first();
    }

    public function findForUpdate(string $tabela, int $registro_id)
    {
        // Bloqueia o Registro (lockForUpdate)
        return Lock::where('tabela', $tabela)
            ->where('registro_id', $registro_id)
            ->lockForUpdate()
            ->first();
    }

    public function create(array $data)
    {
        return Lock::insert($data);
    }

    public function update(int $id, array $data)
    {
        return Lock::where('id', $id)
            ->update($data);
    }

    public function delete(string $tabela, int $registro_id, int $user_id)
    {
        return Lock::where('tabela', $tabela)
            ->where('registro_id', $registro_id)
            ->where('user_id', $user_id)
            ->delete();
    }
}
