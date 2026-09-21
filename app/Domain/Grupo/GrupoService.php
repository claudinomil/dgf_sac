<?php

namespace App\Domain\Grupo;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class GrupoService
{
    public function __construct(
        private GrupoRepository $repository,
        private LockService $lockService
    ) {}

    public function getGrupos($limit=null)
    {
        return $this->repository->index($limit);
    }

    public function getGruposFilter($array_dados, $limit=null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getGrupo(int $id)
    {
        return $this->repository->find($id);
    }

    public function createGrupo(array $data)
    {
        return $this->repository->create($data);
    }

    public function editGrupo(int $id)
    {
        $this->lockService->bloquear('grupos', $id, Auth::user()->id);

        return $this->repository->find($id);
    }

    public function updateGrupo(int $id, array $data)
    {
        $user_id = Auth::user()->id;
        
        try {
            // valida lock
            $this->lockService->validar('grupos', $id, $user_id);

            // update
            $this->repository->update($id, $data);
        } finally {
            // libera o lock
            $this->lockService->desbloquear('grupos', $id, $user_id);
        }
    }

    public function deleteGrupo(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('grupos', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('grupos', $id, $user_id);

            // Busca o registro
            $grupo = $this->repository->find($id);

            if (!$grupo) {
                throw new \Exception('Registro não encontrado.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('grupos', $id, $user_id);
        }
    }

    public function getGrupoPermissoes(int $grupo_id)
    {
        return $this->repository->grupo_permissoes($grupo_id);
    }

    public function getGrupoRelatorios(int $grupo_id)
    {
        return $this->repository->grupo_relatorios($grupo_id);
    }

    public function getGrupoGraficos(int $grupo_id)
    {
        return $this->repository->grupo_graficos($grupo_id);
    }

    public function getTotais(int $op)
    {
        // Total Geral
        if ($op == 1) {
            return $this->repository->totais($op);
        }
    }

    public function getRelatorios()
    {
        return $this->repository->relatorios();
    }

    public function getGraficos()
    {
        return $this->repository->graficos();
    }

    public function getPermissoesSituacoes(int $id)
    {
        return $this->repository->find($id);
    }
}
