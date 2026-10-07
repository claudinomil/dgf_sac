<?php

namespace App\Domain\MilitarTempoAverbado;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class MilitarTempoAverbadoService
{
    public function __construct(
        private MilitarTempoAverbadoRepository $repository,
        private LockService $lockService
    ) {}

    public function getMilitaresTemposAverbados($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getMilitaresTemposAverbadosFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getMilitarTempoAverbado(int $id)
    {
        // Buscar Registro
        $tempo_averbado = $this->repository->find($id);

        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares_tempos_averbados', 'show', $tempo_averbado->militarSituacaoId)) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $tempo_averbado;
    }

    public function createMilitarTempoAverbado(array $data)
    {
        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares_tempos_averbados', 'create', $data['militarSituacaoId'])) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $this->repository->create($data);
    }

    public function editMilitarTempoAverbado(int $id)
    {
        $this->lockService->bloquear('militares_tempos_averbados', $id, Auth::user()->id);

        $tempo_averbado = $this->repository->find($id);

        if (!$tempo_averbado) {
            throw new \Exception('Registro não encontrado.');
        }

        if (!temPermissaoSituacao('militares_tempos_averbados', 'edit', $tempo_averbado->militarSituacaoId)) {
            throw new \Exception('Sem Permissão para Situação do Militar.');
        }

        return $tempo_averbado;
    }

    public function updateMilitarTempoAverbado(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $tempo_averbado = $this->repository->find($id);

            if (!$tempo_averbado) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares_tempos_averbados', 'edit', $data['militarSituacaoId'])) {
                throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
            }

            // Valida Lock
            $this->lockService->validar('militares_tempos_averbados', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares_tempos_averbados', $id, $user_id);
        }
    }

    public function deleteMilitarTempoAverbado(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('militares_tempos_averbados', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('militares_tempos_averbados', $id, $user_id);

            // Busca o registro
            $tempo_averbado = $this->repository->find($id);

            if (!$tempo_averbado) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares_tempos_averbados', 'destroy', $tempo_averbado->militarSituacaoId)) {
                throw new \Exception('Sem Permissão para Situação do Militar.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares_tempos_averbados', $id, $user_id);
        }
    }
}
