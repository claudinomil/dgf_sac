<?php

namespace App\Domain\RessarcimentoConfiguracao;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class RessarcimentoConfiguracaoService
{
    public function __construct(
        private RessarcimentoConfiguracaoRepository $repository,
        private LockService $lockService
    ) {}

    public function getRessarcimentoConfiguracoes($limit=null)
    {
        return $this->repository->index($limit);
    }

    public function getRessarcimentoConfiguracoesFilter($array_dados, $limit=null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getRessarcimentoConfiguracao($id)
    {
        return $this->repository->find($id);
    }

    public function getRessarcimentoConfiguracaoReferencia($referencia)
    {
        return $this->repository->find_referencia($referencia);
    }

    public function createRessarcimentoConfiguracao(array $data)
    {
        return $this->repository->create($data);
    }

    public function editRessarcimentoConfiguracao($id)
    {
        $this->lockService->bloquear('ressarcimento_configuracoes', $id, Auth::user()->id);

        return $this->repository->find($id);
    }

    public function updateRessarcimentoConfiguracao($id, array $data)
    {
        $user_id = Auth::user()->id;

        try {
            // valida lock
            $this->lockService->validar('ressarcimento_configuracoes', $id, $user_id);

            // update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('ressarcimento_configuracoes', $id, $user_id);
        }
    }

    public function getRessarcimentoConfiguracaoQuantidadeRegistros()
    {
        return $this->repository->quantidade_registros();
    }

    public function configuracaoExiste($referencia)
    {
        return $this->repository->configuracaoExiste($referencia);
    }

    public function ultimaConfiguracao()
    {
        return $this->repository->ultimaConfiguracao();
    }
}
