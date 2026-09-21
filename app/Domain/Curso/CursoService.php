<?php

namespace App\Domain\Curso;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class CursoService
{
    public function __construct(
        private CursoRepository $repository,
        private LockService $lockService
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getCursos($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getCursosFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getCurso(int $id)
    {
        // Buscar Registro
        $curso = $this->repository->find($id);

        return $curso;
    }

    public function createCurso(array $data)
    {
        return $this->repository->create($data);
    }

    public function editCurso(int $id)
    {
        $this->lockService->bloquear('cursos', $id, Auth::user()->id);

        $curso = $this->repository->find($id);

        if (!$curso) {
            throw new \Exception('Registro não encontrado.');
        }

        return $curso;
    }

    public function updateCurso(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $curso = $this->repository->find($id);

            if (!$curso) {
                throw new \Exception('Registro não encontrado.');
            }

            // Valida Lock
            $this->lockService->validar('cursos', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('cursos', $id, $user_id);
        }
    }

    public function deleteCurso(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('cursos', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('cursos', $id, $user_id);

            // Busca o registro
            $curso = $this->repository->find($id);

            if (!$curso) {
                throw new \Exception('Registro não encontrado.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('cursos', $id, $user_id);
        }
    }
}
