<?php

namespace App\Domain\Funcao;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class FuncaoService
{
    public function __construct(
        private FuncaoRepository $repository,
        private LockService $lockService
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getFuncoes($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getFuncoesFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getFuncao(int $id)
    {
        // Buscar Registro
        $funcao = $this->repository->find($id);

        return $funcao;
    }

    public function createFuncao(array $data)
    {
        return $this->repository->create($data);
    }

    public function editFuncao(int $id)
    {
        $this->lockService->bloquear('funcoes', $id, Auth::user()->id);

        $funcao = $this->repository->find($id);

        if (!$funcao) {
            throw new \Exception('Registro não encontrado.');
        }

        return $funcao;
    }

    public function updateFuncao(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $funcao = $this->repository->find($id);

            if (!$funcao) {
                throw new \Exception('Registro não encontrado.');
            }

            // Valida Lock
            $this->lockService->validar('funcoes', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('funcoes', $id, $user_id);
        }
    }

    public function deleteFuncao(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('funcoes', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('funcoes', $id, $user_id);

            // Busca o registro
            $funcao = $this->repository->find($id);

            if (!$funcao) {
                throw new \Exception('Registro não encontrado.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('funcoes', $id, $user_id);
        }
    }
}
