<?php

namespace App\Domain\MilitarDependente;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class MilitarDependenteService
{
    public function __construct(
        private MilitarDependenteRepository $repository,
        private LockService $lockService
    ) {}

    public function getMilitaresDependentes($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getMilitaresDependentesFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getMilitarDependente(int $id)
    {
        // Buscar Registro
        $militar_dependente = $this->repository->find($id);

        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares_dependentes', 'show', $militar_dependente->militarSituacaoId)) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $militar_dependente;
    }

    public function createMilitarDependente(array $data)
    {
        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares_dependentes', 'create', $data['militarSituacaoId'])) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $this->repository->create($data);
    }

    public function editMilitarDependente(int $id)
    {
        $this->lockService->bloquear('militares_dependentes', $id, Auth::user()->id);

        $militar_dependente = $this->repository->find($id);

        if (!$militar_dependente) {
            throw new \Exception('Registro não encontrado.');
        }

        if (!temPermissaoSituacao('militares_dependentes', 'edit', $militar_dependente->militarSituacaoId)) {
            throw new \Exception('Sem Permissão para Situação do Militar.');
        }

        return $militar_dependente;
    }

    public function updateMilitarDependente(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $militar_dependente = $this->repository->find($id);

            if (!$militar_dependente) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares_dependentes', 'edit', $data['militarSituacaoId'])) {
                throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
            }

            // Valida Lock
            $this->lockService->validar('militares_dependentes', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares_dependentes', $id, $user_id);
        }
    }

    public function deleteMilitarDependente(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('militares_dependentes', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('militares_dependentes', $id, $user_id);

            // Busca o registro
            $militar_dependente = $this->repository->find($id);

            if (!$militar_dependente) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares_dependentes', 'destroy', $militar_dependente->militarSituacaoId)) {
                throw new \Exception('Sem Permissão para Situação do Militar.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares_dependentes', $id, $user_id);
        }
    }
}
