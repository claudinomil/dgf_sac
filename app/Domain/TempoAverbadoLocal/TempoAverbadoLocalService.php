<?php

namespace App\Domain\TempoAverbadoLocal;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class TempoAverbadoLocalService
{
    public function __construct(
        private TempoAverbadoLocalRepository $repository,
        private LockService $lockService
    ) {}

    public function getTemposAverbadosLocais($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getTemposAverbadosLocaisFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getTempoAverbadoLocal(int $id)
    {
        // Buscar Registro
        $tempo_averbado = $this->repository->find($id);
        
        return $tempo_averbado;
    }

    public function createTempoAverbadoLocal(array $data)
    {
        return $this->repository->create($data);
    }

    public function editTempoAverbadoLocal(int $id)
    {
        $this->lockService->bloquear('tempos_averbados_locais', $id, Auth::user()->id);

        $tempo_averbado = $this->repository->find($id);

        if (!$tempo_averbado) {
            throw new \Exception('Registro não encontrado.');
        }
        
        return $tempo_averbado;
    }

    public function updateTempoAverbadoLocal(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $tempo_averbado = $this->repository->find($id);

            if (!$tempo_averbado) {
                throw new \Exception('Registro não encontrado.');
            }
            
            // Valida Lock
            $this->lockService->validar('tempos_averbados_locais', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('tempos_averbados_locais', $id, $user_id);
        }
    }

    public function deleteTempoAverbadoLocal(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('tempos_averbados_locais', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('tempos_averbados_locais', $id, $user_id);

            // Busca o registro
            $tempo_averbado = $this->repository->find($id);

            if (!$tempo_averbado) {
                throw new \Exception('Registro não encontrado.');
            }
            
            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('tempos_averbados_locais', $id, $user_id);
        }
    }
}