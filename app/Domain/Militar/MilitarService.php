<?php

namespace App\Domain\Militar;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class MilitarService
{
    public function __construct(
        private MilitarRepository $repository,
        private LockService $lockService
    ) {}

    public function getMilitares($limit=null)
    {
        return $this->repository->index($limit);
    }

    public function getMilitaresFilter($array_dados, $limit=null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getMilitar(int $id)
    {
        // Buscar Registro
        $militar = $this->repository->find($id);

        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares', 'show', $militar->militarSituacaoId)) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $militar;
    }

    public function createMilitar(array $data)
    {
        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares', 'create', $data['situacao_id'])) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        $data['fotografia'] = 'assets/images/militares/fotografia-0.png';

        return $this->repository->create($data);
    }

    public function editMilitar(int $id)
    {
        $this->lockService->bloquear('militares', $id, Auth::user()->id);

        $militar = $this->repository->find($id);

        if (!$militar) {
            throw new \Exception('Registro não encontrado.');
        }

        if (!temPermissaoSituacao('militares', 'edit', $militar->militarSituacaoId)) {
            throw new \Exception('Sem Permissão para Situação do Militar.');
        }

        return $militar;
    }

    public function updateMilitar(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Valida Lock
            $this->lockService->validar('militares', $id, $user_id);

            // Busca o registro
            $militar = $this->repository->find($id);

            if (!$militar) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares', 'edit', $data['militarSituacaoId'])) {
                throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
            }

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares', $id, $user_id);
        }
    }

    public function deleteMilitar(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('militares', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('militares', $id, $user_id);

            // Busca o registro
            $militar = $this->repository->find($id);

            if (!$militar) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares', 'destroy', $militar->militarSituacaoId)) {
                throw new \Exception('Sem Permissão para Situação do Militar.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares', $id, $user_id);
        }
    }

    public function getInformacoesGeral(int $militar_id)
    {
        return $this->repository->informacoes_geral($militar_id);
    }

    public function updateFotografia(int $militar_id, $request)
    {
        if ($request->hasFile('informacoes_militar_fotografia')) {
            $file = $request->file('informacoes_militar_fotografia');
            $ext = $file->getClientOriginalExtension();
            $fileName = 'fotografia-' . $militar_id . '.' . $ext;
            $destination = public_path('/assets/images/militares');
            $file->move($destination, $fileName);
            $data['fotografia'] = 'assets/images/militares/' . $fileName;

            $this->repository->update_fotografia($militar_id, $data);

            return $data['fotografia'];
        }
    }

    public function getTotais(int $op)
    {
        // Total Ativos
        if ($op == 2) {
            return $this->repository->totais($op);
        }

        // Total Oficiais Ativos
        if ($op == 3) {
            return $this->repository->totais($op);
        }

        // Total Aspirantes
        if ($op == 4) {
            return $this->repository->totais($op);
        }

        // Total Alunos CFO
        if ($op == 5) {
            return $this->repository->totais($op);
        }

        // Total Praças Ativos
        if ($op == 6) {
            return $this->repository->totais($op);
        }
    }

    public function getAutocompleteMilitar(string $pesquisa, string $submodulo, string $acao)
    {
        return $this->repository->autocompleteMilitar(50, $pesquisa, $submodulo, $acao);
    }
}
