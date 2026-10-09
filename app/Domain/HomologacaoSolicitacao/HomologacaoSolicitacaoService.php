<?php

namespace App\Domain\HomologacaoSolicitacao;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Auth;

class HomologacaoSolicitacaoService
{
    public function __construct(
        private HomologacaoSolicitacaoRepository $repository,
        private LockService $lockService
    ) {}

    public function getHomologacaoSolicitacoes($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getHomologacaoSolicitacoesFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getHomologacaoSolicitacao(int $id)
    {
        // Buscar Registro
        $homologacao_solicitacao = $this->repository->find($id);
        
        return $homologacao_solicitacao;
    }

    public function createHomologacaoSolicitacao(array $data)
    {
        return $this->repository->create($data);
    }

    public function editHomologacaoSolicitacao(int $id)
    {
        $this->lockService->bloquear('homologacao_solicitacoes', $id, Auth::user()->id);

        $homologacao_solicitacao = $this->repository->find($id);

        if (!$homologacao_solicitacao) {
            throw new \Exception('Registro não encontrado.');
        }
        
        return $homologacao_solicitacao;
    }

    public function updateHomologacaoSolicitacao(int $id, array $data)
    {
        $user_id = Auth::id();

        try {
            // Busca o registro
            $homologacao_solicitacao = $this->repository->find($id);

            if (!$homologacao_solicitacao) {
                throw new \Exception('Registro não encontrado.');
            }
            
            // Valida Lock
            $this->lockService->validar('homologacao_solicitacoes', $id, $user_id);

            // Update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('homologacao_solicitacoes', $id, $user_id);
        }
    }

    public function deleteHomologacaoSolicitacao(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('homologacao_solicitacoes', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('homologacao_solicitacoes', $id, $user_id);

            // Busca o registro
            $homologacao_solicitacao = $this->repository->find($id);

            if (!$homologacao_solicitacao) {
                throw new \Exception('Registro não encontrado.');
            }
            
            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('homologacao_solicitacoes', $id, $user_id);
        }
    }
}
