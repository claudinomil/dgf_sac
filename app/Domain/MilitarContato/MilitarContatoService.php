<?php

namespace App\Domain\MilitarContato;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class MilitarContatoService
{
    public function __construct(
        private MilitarContatoRepository $repository,
        private LockService $lockService
    ) {}

    public function getMilitaresContatos($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getMilitaresContatosFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getMilitarContato(int $id)
    {
        // Buscar Registro
        $contato = $this->repository->find($id);

        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares_contatos', 'show', $contato->militarSituacaoId)) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $contato;
    }

    public function createMilitarContato(array $data)
    {
        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares_contatos', 'create', $data['militarSituacaoId'])) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $this->repository->create($data);
    }

    public function editMilitarContato(int $id)
    {
        $this->lockService->bloquear('militares_contatos', $id, Auth::user()->id);

        $contato = $this->repository->find($id);

        if (!$contato) {
            throw new \Exception('Registro não encontrado.');
        }

        if (!temPermissaoSituacao('militares_contatos', 'edit', $contato->militarSituacaoId)) {
            throw new \Exception('Sem Permissão para Situação do Militar.');
        }

        return $contato;
    }

    public function updateMilitarContato(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $contato = $this->repository->find($id);

            if (!$contato) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares_contatos', 'edit', $data['militarSituacaoId'])) {
                throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
            }

            // Valida Lock
            $this->lockService->validar('militares_contatos', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares_contatos', $id, $user_id);
        }
    }

    public function deleteMilitarContato(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('militares_contatos', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('militares_contatos', $id, $user_id);

            // Busca o registro
            $contato = $this->repository->find($id);

            if (!$contato) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares_contatos', 'destroy', $contato->militarSituacaoId)) {
                throw new \Exception('Sem Permissão para Situação do Militar.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares_contatos', $id, $user_id);
        }
    }
}
