<?php

namespace App\Domain\DashboardTvControle;

use App\Models\DashboardTvControle;
use Illuminate\Support\Facades\DB;

class DashboardTvControleRepository
{
    public function find(int $id)
    {
        return DashboardTvControle::find($id);
    }

    public function update(int $id, array $data)
    {
        // Separar os campos de ordenação
        $ordens = [];

        foreach ($data as $campo => $valor) {
            if (str_ends_with($campo, '_ordem')) {
                $identificador = str_replace('_ordem', '', $campo);
                $ordens[$identificador] = $valor;
                unset($data[$campo]);
            }
        }

        // Separar os campos de colunas
        $colunas = [];

        foreach ($data as $campo => $valor) {
            if (str_ends_with($campo, '_colunas')) {
                $identificador = str_replace('_colunas', '', $campo);
                $colunas[$identificador] = $valor;
                unset($data[$campo]);
            }
        }

        DB::transaction(function () use ($id, $data, $ordens, $colunas) {
            // Localizar registro
            $dashboard_tv_controle = $this->find($id);

            if (!$dashboard_tv_controle) {
                throw new \Exception('Registro não encontrado.');
            }

            // Atualizar dashboards_tvs_controles
            $dashboard_tv_controle->update($data);

            // Atualizar ordem dos indicadores e gráficos
            foreach ($ordens as $identificador => $ordem) {
                DB::table('dashboards_tvs_indicadores_graficos')
                    ->where('identificador', $identificador)
                    ->update(['ordem' => $ordem]);
            }

            // Atualizar colunas dos indicadores e gráficos
            foreach ($colunas as $identificador => $coluna) {
                DB::table('dashboards_tvs_indicadores_graficos')
                    ->where('identificador', $identificador)
                    ->update(['colunas' => $coluna]);
            }
        });

        return;
    }
}
