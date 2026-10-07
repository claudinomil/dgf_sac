<?php

namespace App\Domain\MilitarPensao;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class MilitarPensaoService
{
    public function __construct(
        private MilitarPensaoRepository $repository,
        private LockService $lockService
    ) {}

    public function getMilitaresPensoes($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getMilitaresPensoesFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getMilitarPensao(int $id)
    {
        // Buscar Registro
        $pensao = $this->repository->find($id);

        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares_pensoes', 'show', $pensao->militarSituacaoId)) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $pensao;
    }

    public function createMilitarPensao(array $data)
    {
        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares_pensoes', 'create', $data['militarSituacaoId'])) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $this->repository->create($data);
    }

    public function editMilitarPensao(int $id)
    {
        $this->lockService->bloquear('militares_pensoes', $id, Auth::user()->id);

        $pensao = $this->repository->find($id);

        if (!$pensao) {
            throw new \Exception('Registro não encontrado.');
        }

        if (!temPermissaoSituacao('militares_pensoes', 'edit', $pensao->militarSituacaoId)) {
            throw new \Exception('Sem Permissão para Situação do Militar.');
        }

        return $pensao;
    }

    public function updateMilitarPensao(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $pensao = $this->repository->find($id);

            if (!$pensao) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares_pensoes', 'edit', $data['militarSituacaoId'])) {
                throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
            }

            // Valida Lock
            $this->lockService->validar('militares_pensoes', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares_pensoes', $id, $user_id);
        }
    }

    public function deleteMilitarPensao(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('militares_pensoes', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('militares_pensoes', $id, $user_id);

            // Busca o registro
            $pensao = $this->repository->find($id);

            if (!$pensao) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares_pensoes', 'destroy', $pensao->militarSituacaoId)) {
                throw new \Exception('Sem Permissão para Situação do Militar.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares_pensoes', $id, $user_id);
        }
    }
}
