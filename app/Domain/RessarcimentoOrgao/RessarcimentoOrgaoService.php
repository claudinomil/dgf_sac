<?php

namespace App\Domain\RessarcimentoOrgao;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class RessarcimentoOrgaoService
{
    public function __construct(
        private RessarcimentoOrgaoRepository $repository,
        private LockService $lockService
    ) {}

    public function getRessarcimentoOrgaos($limit=null)
    {
        return $this->repository->index($limit);
    }

    public function getRessarcimentoOrgaosFilter($array_dados, $limit=null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getRessarcimentoOrgao($id)
    {
        return $this->repository->find($id);
    }

    public function getOrgaosReferencia($referencia)
    {
        return $this->repository->orgaos_referencia($referencia);
    }

    public function createRessarcimentoOrgao(array $data)
    {
        return $this->repository->create($data);
    }

    public function editRessarcimentoOrgao($id)
    {
        $this->lockService->bloquear('ressarcimento_orgaos', $id, Auth::user()->id);

        return $this->repository->find($id);
    }

    public function updateRessarcimentoOrgao($id, array $data)
    {
        $user_id = Auth::user()->id;

        try {
            // valida lock
            $this->lockService->validar('ressarcimento_orgaos', $id, $user_id);

            // update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('ressarcimento_orgaos', $id, $user_id);
        }
    }

    public function getRessarcimentoOrgaoQuantidadeRegistros()
    {
        return $this->repository->quantidade_registros();
    }

    public function orgaoExiste($lotacao_id)
    {
        return $this->repository->orgaoExiste($lotacao_id);
    }
}
