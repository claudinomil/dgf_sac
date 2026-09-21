<?php

namespace App\Domain\MilitarFundoSaude;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class MilitarFundoSaudeService
{
    public function __construct(
        private MilitarFundoSaudeRepository $repository,
        private LockService $lockService
    ) {}

    public function getMilitaresFundosSaude($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getMilitaresFundosSaudeFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getMilitarFundoSaude(int $id)
    {
        // Buscar Registro
        $militar_fundo_saude = $this->repository->find($id);

        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares_fundos_saude', 'show', $militar_fundo_saude->militarSituacaoId)) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $militar_fundo_saude;
    }

    public function createMilitarFundoSaude(array $data)
    {
        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares_fundos_saude', 'create', $data['militarSituacaoId'])) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $this->repository->create($data);
    }

    public function editMilitarFundoSaude(int $id)
    {
        $this->lockService->bloquear('militares_fundos_saude', $id, Auth::user()->id);

        $militar_fundo_saude = $this->repository->find($id);

        if (!$militar_fundo_saude) {
            throw new \Exception('Registro não encontrado.');
        }

        if (!temPermissaoSituacao('militares_fundos_saude', 'edit', $militar_fundo_saude->militarSituacaoId)) {
            throw new \Exception('Sem Permissão para Situação do Militar.');
        }

        return $militar_fundo_saude;
    }

    public function updateMilitarFundoSaude(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $militar_fundo_saude = $this->repository->find($id);

            if (!$militar_fundo_saude) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares_fundos_saude', 'edit', $data['militarSituacaoId'])) {
                throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
            }

            // Valida Lock
            $this->lockService->validar('militares_fundos_saude', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares_fundos_saude', $id, $user_id);
        }
    }
}
