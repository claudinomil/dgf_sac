<?php

namespace App\Domain\MilitarFerias;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class MilitarFeriasService
{
    public function __construct(
        private MilitarFeriasRepository $repository,
        private LockService $lockService
    ) {}

    public function getMilitaresFerias($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getMilitaresFeriasFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getMilitarFerias(int $id)
    {
        // Buscar Registro
        $ferias = $this->repository->find($id);

        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares_ferias', 'show', $ferias->militarSituacaoId)) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $ferias;
    }

    public function createMilitarFerias(array $data)
    {
        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares_ferias', 'create', $data['militarSituacaoId'])) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $this->repository->create($data);
    }

    public function editMilitarFerias(int $id)
    {
        $this->lockService->bloquear('militares_ferias', $id, Auth::user()->id);

        $ferias = $this->repository->find($id);

        if (!$ferias) {
            throw new \Exception('Registro não encontrado.');
        }

        if (!temPermissaoSituacao('militares_ferias', 'edit', $ferias->militarSituacaoId)) {
            throw new \Exception('Sem Permissão para Situação do Militar.');
        }

        return $ferias;
    }

    public function updateMilitarFerias(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $ferias = $this->repository->find($id);

            if (!$ferias) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares_ferias', 'edit', $data['militarSituacaoId'])) {
                throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
            }

            // Valida Lock
            $this->lockService->validar('militares_ferias', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares_ferias', $id, $user_id);
        }
    }

    public function deleteMilitarFerias(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('militares_ferias', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('militares_ferias', $id, $user_id);

            // Busca o registro
            $ferias = $this->repository->find($id);

            if (!$ferias) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares_ferias', 'destroy', $ferias->militarSituacaoId)) {
                throw new \Exception('Sem Permissão para Situação do Militar.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares_ferias', $id, $user_id);
        }
    }
}
