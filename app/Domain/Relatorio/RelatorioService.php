<?php

namespace App\Domain\Relatorio;

use App\Domain\Relatorio\RelatorioRepository;

class RelatorioService
{
    public function __construct(
        private RelatorioRepository $repository
    ) {}

    public function getRelatoriosGrupo(int $grupo_id)
    {
        return $this->repository->relatorios_grupo($grupo_id);
    }

    public function getRelatorio1(int $grupo_id)
    {
        return $this->repository->relatorio_1($grupo_id);
    }

    public function getRelatorio2(int $grupo_id, int $user_situacao_id, int $user_tipo_id)
    {
        return $this->repository->relatorio_2($grupo_id, $user_situacao_id, $user_tipo_id);
    }

    public function getRelatorio3(string $data, int $user_id, int $submodulo_id, int $operacao_id, string $dado)
    {
        return $this->repository->relatorio_3($data, $user_id, $submodulo_id, $operacao_id, $dado);
    }

    public function getRelatorio4(string $referencia, int $orgao_id)
    {
        return $this->repository->relatorio_4($referencia, $orgao_id);
    }

    public function getRelatorio5(string $referencia, int $orgao_id)
    {
        return $this->repository->relatorio_5($referencia, $orgao_id);
    }

    public function getRelatorio6(string $referencia, int $orgao_id, float $saldo)
    {
        return $this->repository->relatorio_6($referencia, $orgao_id, $saldo);
    }

    public function getRelatorio7()
    {
        return $this->repository->relatorio_7();
    }

    public function getRelatorio8()
    {
        return $this->repository->relatorio_8();
    }

    public function getRelatorio9()
    {
        return $this->repository->relatorio_9();
    }

    public function getRelatorio10()
    {
        return $this->repository->relatorio_10();
    }

    public function getRelatorio11()
    {
        return $this->repository->relatorio_11();
    }

    public function getRelatorio12(object $request, string $situacoes, string $graduacoes, string $unidades, string $quadros, string $comportamentos)
    {
        return $this->repository->relatorio_12($request, $situacoes, $graduacoes, $unidades, $quadros, $comportamentos);
    }
}
