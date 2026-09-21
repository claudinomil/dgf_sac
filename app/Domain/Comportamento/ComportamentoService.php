<?php

namespace App\Domain\Comportamento;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class ComportamentoService
{
    public function __construct(
        private ComportamentoRepository $repository,
        private LockService $lockService
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getComportamentos($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getComportamentosFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getComportamento(int $id)
    {
        // Buscar Registro
        $comportamento = $this->repository->find($id);

        return $comportamento;
    }

    public function createComportamento(array $data)
    {
        return $this->repository->create($data);
    }

    public function editComportamento(int $id)
    {
        $this->lockService->bloquear('comportamentos', $id, Auth::user()->id);

        $comportamento = $this->repository->find($id);

        if (!$comportamento) {
            throw new \Exception('Registro não encontrado.');
        }

        return $comportamento;
    }

    public function updateComportamento(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $comportamento = $this->repository->find($id);

            if (!$comportamento) {
                throw new \Exception('Registro não encontrado.');
            }

            // Valida Lock
            $this->lockService->validar('comportamentos', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('comportamentos', $id, $user_id);
        }
    }

    public function deleteComportamento(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('comportamentos', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('comportamentos', $id, $user_id);

            // Busca o registro
            $comportamento = $this->repository->find($id);

            if (!$comportamento) {
                throw new \Exception('Registro não encontrado.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('comportamentos', $id, $user_id);
        }
    }
}
