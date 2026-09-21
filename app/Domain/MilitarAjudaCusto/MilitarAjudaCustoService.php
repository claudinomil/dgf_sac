<?php

namespace App\Domain\MilitarAjudaCusto;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class MilitarAjudaCustoService
{
    public function __construct(
        private MilitarAjudaCustoRepository $repository,
        private LockService $lockService
    ) {}

    public function getMilitaresAjudasCustos($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getMilitaresAjudasCustosFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getMilitarAjudaCusto(int $id)
    {
        // Buscar Registro
        $ajuda_custo = $this->repository->find($id);

        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares_ajudas_custos', 'show', $ajuda_custo->militarSituacaoId)) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $ajuda_custo;
    }

    public function createMilitarAjudaCusto(array $data)
    {
        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares_ajudas_custos', 'create', $data['militarSituacaoId'])) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $this->repository->create($data);
    }

    public function editMilitarAjudaCusto(int $id)
    {
        $this->lockService->bloquear('militares_ajudas_custos', $id, Auth::user()->id);

        $ajuda_custo = $this->repository->find($id);

        if (!$ajuda_custo) {
            throw new \Exception('Registro não encontrado.');
        }

        if (!temPermissaoSituacao('militares_ajudas_custos', 'edit', $ajuda_custo->militarSituacaoId)) {
            throw new \Exception('Sem Permissão para Situação do Militar.');
        }

        return $ajuda_custo;
    }

    public function updateMilitarAjudaCusto(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $ajuda_custo = $this->repository->find($id);

            if (!$ajuda_custo) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares_ajudas_custos', 'edit', $data['militarSituacaoId'])) {
                throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
            }

            // Valida Lock
            $this->lockService->validar('militares_ajudas_custos', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares_ajudas_custos', $id, $user_id);
        }
    }

    public function deleteMilitarAjudaCusto(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('militares_ajudas_custos', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('militares_ajudas_custos', $id, $user_id);

            // Busca o registro
            $ajuda_custo = $this->repository->find($id);

            if (!$ajuda_custo) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares_ajudas_custos', 'destroy', $ajuda_custo->militarSituacaoId)) {
                throw new \Exception('Sem Permissão para Situação do Militar.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares_ajudas_custos', $id, $user_id);
        }
    }
}
