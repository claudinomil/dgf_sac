<?php

namespace App\Domain\MilitarAuxilioFardamento;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class MilitarAuxilioFardamentoService
{
    public function __construct(
        private MilitarAuxilioFardamentoRepository $repository,
        private LockService $lockService
    ) {}

    public function getMilitaresAuxiliosFardamentos($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getMilitaresAuxiliosFardamentosFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getMilitarAuxilioFardamento(int $id)
    {
        // Buscar Registro
        $auxilio_fardamento = $this->repository->find($id);

        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares_auxilios_fardamentos', 'show', $auxilio_fardamento->militarSituacaoId)) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $auxilio_fardamento;
    }

    public function createMilitarAuxilioFardamento(array $data)
    {
        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares_auxilios_fardamentos', 'create', $data['militarSituacaoId'])) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $this->repository->create($data);
    }

    public function editMilitarAuxilioFardamento(int $id)
    {
        $this->lockService->bloquear('militares_auxilios_fardamentos', $id, Auth::user()->id);

        $auxilio_fardamento = $this->repository->find($id);

        if (!$auxilio_fardamento) {
            throw new \Exception('Registro não encontrado.');
        }

        if (!temPermissaoSituacao('militares_auxilios_fardamentos', 'edit', $auxilio_fardamento->militarSituacaoId)) {
            throw new \Exception('Sem Permissão para Situação do Militar.');
        }

        return $auxilio_fardamento;
    }

    public function updateMilitarAuxilioFardamento(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $auxilio_fardamento = $this->repository->find($id);

            if (!$auxilio_fardamento) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares_auxilios_fardamentos', 'edit', $data['militarSituacaoId'])) {
                throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
            }

            // Valida Lock
            $this->lockService->validar('militares_auxilios_fardamentos', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares_auxilios_fardamentos', $id, $user_id);
        }
    }

    public function deleteMilitarAuxilioFardamento(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('militares_auxilios_fardamentos', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('militares_auxilios_fardamentos', $id, $user_id);

            // Busca o registro
            $auxilio_fardamento = $this->repository->find($id);

            if (!$auxilio_fardamento) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares_auxilios_fardamentos', 'destroy', $auxilio_fardamento->militarSituacaoId)) {
                throw new \Exception('Sem Permissão para Situação do Militar.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares_auxilios_fardamentos', $id, $user_id);
        }
    }
}
