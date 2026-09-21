<?php

namespace App\Domain\Parentesco;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class ParentescoService
{
    public function __construct(
        private ParentescoRepository $repository,
        private LockService $lockService
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getParentescos($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getParentescosFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getParentesco(int $id)
    {
        // Buscar Registro
        $parentesco = $this->repository->find($id);

        return $parentesco;
    }

    public function createParentesco(array $data)
    {
        return $this->repository->create($data);
    }

    public function editParentesco(int $id)
    {
        $this->lockService->bloquear('parentescos', $id, Auth::user()->id);

        $parentesco = $this->repository->find($id);

        if (!$parentesco) {
            throw new \Exception('Registro não encontrado.');
        }

        return $parentesco;
    }

    public function updateParentesco(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $parentesco = $this->repository->find($id);

            if (!$parentesco) {
                throw new \Exception('Registro não encontrado.');
            }

            // Valida Lock
            $this->lockService->validar('parentescos', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('parentescos', $id, $user_id);
        }
    }

    public function deleteParentesco(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('parentescos', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('parentescos', $id, $user_id);

            // Busca o registro
            $parentesco = $this->repository->find($id);

            if (!$parentesco) {
                throw new \Exception('Registro não encontrado.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('parentescos', $id, $user_id);
        }
    }
}
