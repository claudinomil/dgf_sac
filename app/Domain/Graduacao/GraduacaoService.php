<?php

namespace App\Domain\Graduacao;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class GraduacaoService
{
    public function __construct(
        private GraduacaoRepository $repository,
        private LockService $lockService
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getGraduacoes($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getGraduacoesFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getGraduacao(int $id)
    {
        // Buscar Registro
        $graduacao = $this->repository->find($id);

        return $graduacao;
    }

    public function createGraduacao(array $data)
    {
        return $this->repository->create($data);
    }

    public function editGraduacao(int $id)
    {
        $this->lockService->bloquear('graduacoes', $id, Auth::user()->id);

        $graduacao = $this->repository->find($id);

        if (!$graduacao) {
            throw new \Exception('Registro não encontrado.');
        }

        return $graduacao;
    }

    public function updateGraduacao(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $graduacao = $this->repository->find($id);

            if (!$graduacao) {
                throw new \Exception('Registro não encontrado.');
            }

            // Valida Lock
            $this->lockService->validar('graduacoes', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('graduacoes', $id, $user_id);
        }
    }

    public function deleteGraduacao(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('graduacoes', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('graduacoes', $id, $user_id);

            // Busca o registro
            $graduacao = $this->repository->find($id);

            if (!$graduacao) {
                throw new \Exception('Registro não encontrado.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('graduacoes', $id, $user_id);
        }
    }
}
