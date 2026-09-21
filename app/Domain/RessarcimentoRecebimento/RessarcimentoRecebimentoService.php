<?php

namespace App\Domain\RessarcimentoRecebimento;

class RessarcimentoRecebimentoService
{
    public function __construct(
        private RessarcimentoRecebimentoRepository $repository
    ) {}

    public function getRessarcimentoRecebimentos($limit=null)
    {
        return $this->repository->index($limit);
    }

    public function getRessarcimentoRecebimentosFilter($array_dados, $limit=null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function updateRecebimento($request)
    {
        $this->repository->update_recebimento($request);

        return true;
    }

    public function getDadosModal($referencia)
    {
        return $this->repository->dados_modal($referencia);
    }

    public function getRegistrosAlterar($referencia, $orgao_id)
    {
        return $this->repository->registros_alterar($referencia, $orgao_id);
    }
}
