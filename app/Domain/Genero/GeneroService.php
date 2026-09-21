<?php

namespace App\Domain\Genero;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class GeneroService
{
    public function __construct(
        private GeneroRepository $repository,
        private LockService $lockService
    ) {}

    public function getAll()
    {
        return $this->repository->all();
    }

    public function getGeneros($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getGenerosFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getGenero(int $id)
    {
        // Buscar Registro
        $genero = $this->repository->find($id);

        return $genero;
    }

    public function createGenero(array $data)
    {
        return $this->repository->create($data);
    }

    public function editGenero(int $id)
    {
        $this->lockService->bloquear('generos', $id, Auth::user()->id);

        $genero = $this->repository->find($id);

        if (!$genero) {
            throw new \Exception('Registro não encontrado.');
        }

        return $genero;
    }

    public function updateGenero(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $genero = $this->repository->find($id);

            if (!$genero) {
                throw new \Exception('Registro não encontrado.');
            }

            // Valida Lock
            $this->lockService->validar('generos', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('generos', $id, $user_id);
        }
    }

    public function deleteGenero(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('generos', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('generos', $id, $user_id);

            // Busca o registro
            $genero = $this->repository->find($id);

            if (!$genero) {
                throw new \Exception('Registro não encontrado.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('generos', $id, $user_id);
        }
    }
}
