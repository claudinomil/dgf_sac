<?php

namespace App\Domain\DashboardTv;

class DashboardTvService
{
    public function __construct(
        private DashboardTvRepository $repository
    ) {}

    public function getIndicadoresGraficos()
    {
        return $this->repository->indicadores_graficos();
    }
}
