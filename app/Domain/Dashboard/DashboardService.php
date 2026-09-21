<?php

namespace App\Domain\Dashboard;

use App\Domain\Dashboard\DashboardRepository;

class DashboardService
{
    public function __construct(
        private DashboardRepository $repository
    ) {}

    public function getPermissoesGraficos(int $grupo_id)
    {
        return $this->repository->permissoes_graficos($grupo_id);
    }

    public function getGrafico1()
    {
        return $this->repository->grafico_1();
    }

    public function getGrafico2()
    {
        return $this->repository->grafico_2();
    }

    public function getGrafico3()
    {
        return $this->repository->grafico_3();
    }

    public function getGrafico4()
    {
        return $this->repository->grafico_4();
    }

    public function getGrafico5($militares_selecionados, $quadros_selecionados)
    {
        return $this->repository->grafico_5($militares_selecionados, $quadros_selecionados);
    }

    public function getGrafico6($militares_selecionados, $graduacoes_selecionadas)
    {
        return $this->repository->grafico_6($militares_selecionados, $graduacoes_selecionadas);
    }

    public function getGrafico7()
    {
        return $this->repository->grafico_7();
    }

    public function getGrafico8(string $periodo_1, string $periodo_2, int $orgao_id)
    {
        return $this->repository->grafico_8($periodo_1, $periodo_2, $orgao_id);
    }

    public function getGrafico9(string $periodo_1, string $periodo_2, int $orgao_id)
    {
        return $this->repository->grafico_9($periodo_1, $periodo_2, $orgao_id);
    }

    public function getGrafico10(string $periodo_1, string $periodo_2, int $orgao_id)
    {
        return $this->repository->grafico_10($periodo_1, $periodo_2, $orgao_id);
    }

    public function getGrafico11(string $periodo_1, string $periodo_2, int $orgao_id)
    {
        return $this->repository->grafico_11($periodo_1, $periodo_2, $orgao_id);
    }

    public function getGrafico12(string $periodo_1, string $periodo_2, int $orgao_id)
    {
        return $this->repository->grafico_12($periodo_1, $periodo_2, $orgao_id);
    }

    public function getGrafico13()
    {
        return $this->repository->grafico_13();
    }

    public function getGrafico14()
    {
        return $this->repository->grafico_14();
    }

    public function getGrafico15()
    {
        return $this->repository->grafico_15();
    }

    public function getGrafico16()
    {
        return $this->repository->grafico_16();
    }

    public function getGrafico17()
    {
        return $this->repository->grafico_17();
    }
}
