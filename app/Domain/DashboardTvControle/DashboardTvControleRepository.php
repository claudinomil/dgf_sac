<?php

namespace App\Domain\DashboardTvControle;

use App\Models\DashboardTvControle;

class DashboardTvControleRepository
{
    public function index(int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Return
        $query = DashboardTvControle::join('unidades', 'unidades.id', 'dashboards_tvs_controles.unidade_id')
            ->select(
                'dashboards_tvs_controles.*',
                'unidades.name as unidadeName'
            );
            
        return $query->limit($limit)->get();
    }
    
    public function find(int $id)
    {
        return DashboardTvControle::find($id);
    }
    
    public function update(int $id, array $data)
    {
        $dashboard_tv_controle = $this->find($id);

        if (!$dashboard_tv_controle) {
            throw new \Exception('Registro não encontrado.');
        }

        $dashboard_tv_controle->update($data);

        return $dashboard_tv_controle->refresh();
    }
}