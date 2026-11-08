<?php

namespace Database\Seeders;

use App\Models\DashboardTvIndicadorGrafico;
use Illuminate\Database\Seeder;

class DashboardTvIndicadorGraficoSeeder extends Seeder
{
    public function run()
    {
        DashboardTvIndicadorGrafico::create(['id' => 1, 'tipo' => 1, 'identificador' => 'indicador_1', 'titulo' => 'TOTAL DE MILITARES', 'colunas' => 2, 'ordem' => 10]);
        DashboardTvIndicadorGrafico::create(['id' => 2, 'tipo' => 1, 'identificador' => 'indicador_2', 'titulo' => 'TOTAL DE MILITARES ATIVOS', 'colunas' => 2, 'ordem' => 20]);
        DashboardTvIndicadorGrafico::create(['id' => 3, 'tipo' => 1, 'identificador' => 'indicador_3', 'titulo' => 'TOTAL DE MILITARES INATIVOS', 'colunas' => 2, 'ordem' => 30]);
        DashboardTvIndicadorGrafico::create(['id' => 4, 'tipo' => 1, 'identificador' => 'indicador_4', 'titulo' => 'TOTAL DE MILITARES OFICIAIS', 'colunas' => 2, 'ordem' => 40]);
        DashboardTvIndicadorGrafico::create(['id' => 5, 'tipo' => 1, 'identificador' => 'indicador_5', 'titulo' => 'TOTAL DE MILITARES PRAÇAS', 'colunas' => 2, 'ordem' => 50]);
        DashboardTvIndicadorGrafico::create(['id' => 6, 'tipo' => 1, 'identificador' => 'indicador_6', 'titulo' => 'TOTAL DE AJUDAS DE CUSTOS', 'colunas' => 2, 'ordem' => 60]);
        DashboardTvIndicadorGrafico::create(['id' => 7, 'tipo' => 1, 'identificador' => 'indicador_7', 'titulo' => 'TOTAL DE AUXÍLIOS FARDAMENTOS', 'colunas' => 2, 'ordem' => 70]);
        DashboardTvIndicadorGrafico::create(['id' => 8, 'tipo' => 1, 'identificador' => 'indicador_8', 'titulo' => 'TOTAL DE CURSOS', 'colunas' => 2, 'ordem' => 80]);
        DashboardTvIndicadorGrafico::create(['id' => 9, 'tipo' => 1, 'identificador' => 'indicador_9', 'titulo' => 'TOTAL DE DEPENDENTES', 'colunas' => 2, 'ordem' => 90]);
        DashboardTvIndicadorGrafico::create(['id' => 10, 'tipo' => 1, 'identificador' => 'indicador_10', 'titulo' => 'TOTAL DE FÉRIAS', 'colunas' => 2, 'ordem' => 100]);
        DashboardTvIndicadorGrafico::create(['id' => 11, 'tipo' => 1, 'identificador' => 'indicador_11', 'titulo' => 'TOTAL DE PENSÕES', 'colunas' => 2, 'ordem' => 110]);
        DashboardTvIndicadorGrafico::create(['id' => 12, 'tipo' => 1, 'identificador' => 'indicador_12', 'titulo' => 'TOTAL DE TEMPOS AVERBADOS', 'colunas' => 2, 'ordem' => 120]);

        DashboardTvIndicadorGrafico::create(['id' => 13, 'tipo' => 2, 'identificador' => 'grafico_1', 'titulo' => 'MILITARES POR SITUAÇÕES', 'colunas' => 4, 'ordem' => 10]);
        DashboardTvIndicadorGrafico::create(['id' => 14, 'tipo' => 2, 'identificador' => 'grafico_2', 'titulo' => 'MILITARES POR GRADUAÇÕES', 'colunas' => 4, 'ordem' => 20]);
        DashboardTvIndicadorGrafico::create(['id' => 15, 'tipo' => 2, 'identificador' => 'grafico_3', 'titulo' => 'MILITARES POR COMPORTAMENTOS', 'colunas' => 4, 'ordem' => 30]);
        DashboardTvIndicadorGrafico::create(['id' => 16, 'tipo' => 2, 'identificador' => 'grafico_4', 'titulo' => 'GRÁFICO', 'colunas' => 4, 'ordem' => 40]);
        DashboardTvIndicadorGrafico::create(['id' => 17, 'tipo' => 2, 'identificador' => 'grafico_5', 'titulo' => 'GRÁFICO', 'colunas' => 4, 'ordem' => 50]);
        DashboardTvIndicadorGrafico::create(['id' => 18, 'tipo' => 2, 'identificador' => 'grafico_6', 'titulo' => 'GRÁFICO', 'colunas' => 4, 'ordem' => 60]);
        DashboardTvIndicadorGrafico::create(['id' => 19, 'tipo' => 2, 'identificador' => 'grafico_7', 'titulo' => 'GRÁFICO', 'colunas' => 4, 'ordem' => 70]);
        DashboardTvIndicadorGrafico::create(['id' => 20, 'tipo' => 2, 'identificador' => 'grafico_8', 'titulo' => 'GRÁFICO', 'colunas' => 4, 'ordem' => 80]);
        DashboardTvIndicadorGrafico::create(['id' => 21, 'tipo' => 2, 'identificador' => 'grafico_9', 'titulo' => 'GRÁFICO', 'colunas' => 4, 'ordem' => 90]);
        DashboardTvIndicadorGrafico::create(['id' => 22, 'tipo' => 2, 'identificador' => 'grafico_10', 'titulo' => 'GRÁFICO', 'colunas' => 4, 'ordem' => 100]);
        DashboardTvIndicadorGrafico::create(['id' => 23, 'tipo' => 2, 'identificador' => 'grafico_11', 'titulo' => 'GRÁFICO', 'colunas' => 4, 'ordem' => 110]);
        DashboardTvIndicadorGrafico::create(['id' => 24, 'tipo' => 2, 'identificador' => 'grafico_12', 'titulo' => 'GRÁFICO', 'colunas' => 4, 'ordem' => 120]);
    }
}
