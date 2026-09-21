<?php

namespace App\Domain\Unidade;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class UnidadeService
{
    public function __construct(
        private UnidadeRepository $repository,
        private LockService $lockService
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getUnidades($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getUnidadesFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getUnidade(int $id)
    {
        // Buscar Registro
        $unidade = $this->repository->find($id);

        return $unidade;
    }

    public function createUnidade(array $data)
    {
        return $this->repository->create($data);
    }

    public function editUnidade(int $id)
    {
        $this->lockService->bloquear('unidades', $id, Auth::user()->id);

        $unidade = $this->repository->find($id);

        if (!$unidade) {
            throw new \Exception('Registro não encontrado.');
        }

        return $unidade;
    }

    public function updateUnidade(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $unidade = $this->repository->find($id);

            if (!$unidade) {
                throw new \Exception('Registro não encontrado.');
            }

            // Valida Lock
            $this->lockService->validar('unidades', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('unidades', $id, $user_id);
        }
    }

    public function deleteUnidade(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('unidades', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('unidades', $id, $user_id);

            // Busca o registro
            $unidade = $this->repository->find($id);

            if (!$unidade) {
                throw new \Exception('Registro não encontrado.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('unidades', $id, $user_id);
        }
    }
}
