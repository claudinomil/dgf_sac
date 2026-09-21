<?php

namespace App\Domain\Quadro;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class QuadroService
{
    public function __construct(
        private QuadroRepository $repository,
        private LockService $lockService
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getQuadros($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getQuadrosFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getQuadro(int $id)
    {
        // Buscar Registro
        $quadro = $this->repository->find($id);

        return $quadro;
    }

    public function createQuadro(array $data)
    {
        return $this->repository->create($data);
    }

    public function editQuadro(int $id)
    {
        $this->lockService->bloquear('quadros', $id, Auth::user()->id);

        $quadro = $this->repository->find($id);

        if (!$quadro) {
            throw new \Exception('Registro não encontrado.');
        }

        return $quadro;
    }

    public function updateQuadro(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $quadro = $this->repository->find($id);

            if (!$quadro) {
                throw new \Exception('Registro não encontrado.');
            }

            // Valida Lock
            $this->lockService->validar('quadros', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('quadros', $id, $user_id);
        }
    }

    public function deleteQuadro(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('quadros', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('quadros', $id, $user_id);

            // Busca o registro
            $quadro = $this->repository->find($id);

            if (!$quadro) {
                throw new \Exception('Registro não encontrado.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('quadros', $id, $user_id);
        }
    }
}
