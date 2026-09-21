<?php

namespace App\Domain\RessarcimentoReferencia;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class RessarcimentoReferenciaService
{
    public function __construct(
        private RessarcimentoReferenciaRepository $repository,
        private LockService $lockService
    ) {}

    public function getRessarcimentoReferencias($limit=null)
    {
        return $this->repository->index($limit);
    }

    public function getRessarcimentoReferenciasFilter($array_dados, $limit=null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getRessarcimentoReferencia($id)
    {
        return $this->repository->find($id);
    }

    public function getRessarcimentoReferenciaReferencia($referencia)
    {
        return $this->repository->find_referencia($referencia);
    }

    public function createRessarcimentoReferencia(array $data)
    {
        return $this->repository->create($data);
    }

    public function editRessarcimentoReferencia($id)
    {
        $this->lockService->bloquear('ressarcimento_referencias', $id, Auth::user()->id);

        return $this->repository->find($id);
    }

    public function updateRessarcimentoReferencia($id, array $data)
    {
        $user_id = Auth::user()->id;

        try {
            // valida lock
            $this->lockService->validar('ressarcimento_referencias', $id, $user_id);

            // update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('ressarcimento_referencias', $id, $user_id);
        }
    }

    public function deleteRessarcimentoReferencia(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('ressarcimento_referencias', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('ressarcimento_referencias', $id, $user_id);

            // Busca o registro
            $ressarcimento_referencia = $this->repository->find($id);

            if (!$ressarcimento_referencia) {
                throw new \Exception('Registro não encontrado.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('ressarcimento_referencias', $id, $user_id);
        }
    }

    public function getReferenciasAtivas()
    {
        return $this->repository->referenciasAtivas();
    }

    public function getReferenciasComMilitares()
    {
        return $this->repository->referenciasComMilitares();
    }

    public function referenciaExiste($referencia)
    {
        return $this->repository->referenciaExiste($referencia);
    }
}
