<?php

namespace App\Domain\Situacao;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class SituacaoService
{
    public function __construct(
        private SituacaoRepository $repository,
        private LockService $lockService
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getSituacoes($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getSituacoesFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getSituacao(int $id)
    {
        // Buscar Registro
        $situacao = $this->repository->find($id);

        return $situacao;
    }

    public function createSituacao(array $data)
    {
        return $this->repository->create($data);
    }

    public function editSituacao(int $id)
    {
        $this->lockService->bloquear('situacoes', $id, Auth::user()->id);

        $situacao = $this->repository->find($id);

        if (!$situacao) {
            throw new \Exception('Registro não encontrado.');
        }

        return $situacao;
    }

    public function updateSituacao(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $situacao = $this->repository->find($id);

            if (!$situacao) {
                throw new \Exception('Registro não encontrado.');
            }

            // Valida Lock
            $this->lockService->validar('situacoes', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('situacoes', $id, $user_id);
        }
    }

    public function deleteSituacao(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('situacoes', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('situacoes', $id, $user_id);

            // Busca o registro
            $situacao = $this->repository->find($id);

            if (!$situacao) {
                throw new \Exception('Registro não encontrado.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('situacoes', $id, $user_id);
        }
    }
}
