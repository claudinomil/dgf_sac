<?php

namespace App\Domain\Integracao;

use App\Domain\Webservice\WebserviceRepository;

class IntegracaoService
{
    public function __construct(
        private IntegracaoRepository $repository,
        private WebserviceRepository $webServiceRepository
    ) {}

    // Importações SAC antigo (impsac) - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    public function impsacTotais()
    {
        return $this->repository->impsac_totais();
    }

    public function impsacAtualizarDados(string $tabela)
    {
        $dadosLegado = $this->webServiceRepository->tabelaRegistros($tabela);

        return $this->repository->impsac_atualizar_dados($tabela, $dadosLegado);
    }
    // Importações SAC antigo (impsac) - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}
