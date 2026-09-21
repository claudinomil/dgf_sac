<?php

namespace App\Domain\MilitarCurso;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class MilitarCursoService
{
    public function __construct(
        private MilitarCursoRepository $repository,
        private LockService $lockService
    ) {}

    public function getMilitaresCursos($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getMilitaresCursosFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getMilitarCurso(int $id)
    {
        // Buscar Registro
        $curso = $this->repository->find($id);

        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares_cursos', 'show', $curso->militarSituacaoId)) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $curso;
    }

    public function createMilitarCurso(array $data)
    {
        // Verificar Permissão para Situação do Militar
        if (!temPermissaoSituacao('militares_cursos', 'create', $data['militarSituacaoId'])) {
            throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
        }

        return $this->repository->create($data);
    }

    public function editMilitarCurso(int $id)
    {
        $this->lockService->bloquear('militares_cursos', $id, Auth::user()->id);

        $curso = $this->repository->find($id);

        if (!$curso) {
            throw new \Exception('Registro não encontrado.');
        }

        if (!temPermissaoSituacao('militares_cursos', 'edit', $curso->militarSituacaoId)) {
            throw new \Exception('Sem Permissão para Situação do Militar.');
        }

        return $curso;
    }

    public function updateMilitarCurso(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $curso = $this->repository->find($id);

            if (!$curso) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares_cursos', 'edit', $data['militarSituacaoId'])) {
                throw new \Exception('Sem permissão. Sem Permissão para Situação do Militar.');
            }

            // Valida Lock
            $this->lockService->validar('militares_cursos', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares_cursos', $id, $user_id);
        }
    }

    public function deleteMilitarCurso(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('militares_cursos', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('militares_cursos', $id, $user_id);

            // Busca o registro
            $curso = $this->repository->find($id);

            if (!$curso) {
                throw new \Exception('Registro não encontrado.');
            }

            // Verificar Permissão para Situação do Militar
            if (!temPermissaoSituacao('militares_cursos', 'destroy', $curso->militarSituacaoId)) {
                throw new \Exception('Sem Permissão para Situação do Militar.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('militares_cursos', $id, $user_id);
        }
    }
}
