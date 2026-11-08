<?php

namespace App\Domain\DashboardTvIndicadorGrafico;

use App\Models\DashboardTvIndicadorGrafico;

class DashboardTvIndicadorGraficoRepository
{
    public function indicadores()
    {
        return DashboardTvIndicadorGrafico::where('tipo', 1)
            ->select(
                'dashboards_tvs_indicadores_graficos.*'
            )
            ->orderby('ordem')
            ->get();
    }
    
    public function graficos()
    {
        return DashboardTvIndicadorGrafico::where('tipo', 2)
            ->select(
                'dashboards_tvs_indicadores_graficos.*'
            )
            ->orderby('ordem')
            ->get();
    }
    
    public function find(int $id)
    {
        return DashboardTvIndicadorGrafico::find($id);
    }
}