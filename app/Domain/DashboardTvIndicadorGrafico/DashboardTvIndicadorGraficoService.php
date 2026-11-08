<?php

namespace App\Domain\DashboardTvIndicadorGrafico;

class DashboardTvIndicadorGraficoService
{
    public function __construct(
        private DashboardTvIndicadorGraficoRepository $repository
    ) {}
    
    public function getDashboardsTvsIndicadores()
    {
        return $this->repository->indicadores();
    }

    public function getDashboardsTvsGraficos()
    {
        return $this->repository->graficos();
    }
    
    public function getDashboardTvIndicadorGrafico(int $id)
    {
        // Buscar Registro
        $dashboard_tv_indicador_grafico = $this->repository->find($id);

        return $dashboard_tv_indicador_grafico;
    }
}