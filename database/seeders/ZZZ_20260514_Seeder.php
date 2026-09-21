<?php

namespace Database\Seeders;

use App\Models\Grafico;
use App\Models\GraficoGrupo;
use App\Models\GrupoGrafico;
use App\Models\GrupoRelatorio;
use App\Models\Relatorio;
use App\Models\RelatorioGrupo;
use Illuminate\Database\Seeder;

class ZZZ_20260514_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder fazer um arquivo ZZZ_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Gráfico'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Gráfico Grupos
        GraficoGrupo::create(['id' => 1, 'name' => 'SISTEMA', 'ordem' => 10]);
        GraficoGrupo::create(['id' => 2, 'name' => 'EFETIVO', 'ordem' => 20]);
        GraficoGrupo::create(['id' => 3, 'name' => 'RESSARCIMENTO', 'ordem' => 30]);
        GraficoGrupo::create(['id' => 4, 'name' => 'BALANCETES', 'ordem' => 40]);

        // Gráficos
        Grafico::create(['id' => 1, 'grafico_grupo_id' => 1, 'name' => 'USUÁRIOS GRUPOS', 'tipo' => 1, 'ordem' => 10]);
        Grafico::create(['id' => 2, 'grafico_grupo_id' => 1, 'name' => 'TRANSAÇÕES OPERAÇÕES', 'tipo' => 2, 'ordem' => 20]);
        Grafico::create(['id' => 3, 'grafico_grupo_id' => 1, 'name' => 'TRANSAÇÕES SUBMÓDULOS', 'tipo' => 1, 'ordem' => 30]);
        Grafico::create(['id' => 4, 'grafico_grupo_id' => 2, 'name' => 'SITUAÇÕES', 'tipo' => 1, 'ordem' => 40]);
        Grafico::create(['id' => 5, 'grafico_grupo_id' => 2, 'name' => 'QUADROS', 'tipo' => 1, 'ordem' => 50]);
        Grafico::create(['id' => 6, 'grafico_grupo_id' => 2, 'name' => 'GRADUAÇÕES', 'tipo' => 1, 'ordem' => 50]);
        Grafico::create(['id' => 7, 'grafico_grupo_id' => 2, 'name' => 'COMPORTAMENTOS', 'tipo' => 1, 'ordem' => 70]);
        Grafico::create(['id' => 8, 'grafico_grupo_id' => 3, 'name' => 'QUANTIDADE DE MILITARES: OFICIAIS/PRAÇAS', 'tipo' => 1, 'ordem' => 80]);
        Grafico::create(['id' => 9, 'grafico_grupo_id' => 3, 'name' => 'VALORES DEVIDOS E PAGOS PELOS ÓRGÃOS', 'tipo' => 1, 'ordem' => 90]);
        Grafico::create(['id' => 10, 'grafico_grupo_id' => 3, 'name' => 'NÚMERO DE ÓRGÃOS POR ESFERA', 'tipo' => 1, 'ordem' => 100]);
        Grafico::create(['id' => 11, 'grafico_grupo_id' => 3, 'name' => 'NÚMERO DE ÓRGÃOS POR PODER', 'tipo' => 1, 'ordem' => 110]);
        Grafico::create(['id' => 12, 'grafico_grupo_id' => 3, 'name' => 'VALORES DEVIDOS E PAGOS POR ÓRGÃOS MENSALMENTE', 'tipo' => 1, 'ordem' => 120]);
        Grafico::create(['id' => 13, 'grafico_grupo_id' => 4, 'name' => 'REPASSES', 'tipo' => 1, 'ordem' => 130]);
        Grafico::create(['id' => 14, 'grafico_grupo_id' => 4, 'name' => 'DESPESAS', 'tipo' => 1, 'ordem' => 140]);
        Grafico::create(['id' => 15, 'grafico_grupo_id' => 4, 'name' => 'TRANSFERÊNCIAS REALIZADAS', 'tipo' => 1, 'ordem' => 150]);
        Grafico::create(['id' => 16, 'grafico_grupo_id' => 4, 'name' => 'TRANSFERÊNCIAS RECEBIDAS', 'tipo' => 1, 'ordem' => 160]);
        Grafico::create(['id' => 17, 'grafico_grupo_id' => 4, 'name' => 'RESULTADO DO PERÍODO', 'tipo' => 1, 'ordem' => 170]);

        // Grupos Gráficos
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 1]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 2]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 3]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 4]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 5]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 6]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 7]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 8]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 9]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 10]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 11]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 12]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 13]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 14]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 15]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 16]);
        GrupoGrafico::create(['grupo_id' => 1, 'grafico_id' => 17]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Relatório'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Relatório Grupos
        RelatorioGrupo::create(['id' => 1, 'name' => 'SISTEMA', 'ordem' => 10]);
        RelatorioGrupo::create(['id' => 2, 'name' => 'EFETIVO', 'ordem' => 20]);
        RelatorioGrupo::create(['id' => 3, 'name' => 'RESSARCIMENTO', 'ordem' => 30]);
        RelatorioGrupo::create(['id' => 4, 'name' => 'BALANCETES', 'ordem' => 40]);

        // Relatórios
        Relatorio::create(['id' => 1, 'relatorio_grupo_id' => 1, 'name' => 'GRUPOS', 'ordem' => 10]);
        Relatorio::create(['id' => 2, 'relatorio_grupo_id' => 1, 'name' => 'USUÁRIOS', 'ordem' => 20]);
        Relatorio::create(['id' => 3, 'relatorio_grupo_id' => 1, 'name' => 'TRANSAÇÕES', 'ordem' => 30]);

        Relatorio::create(['id' => 4, 'relatorio_grupo_id' => 3, 'name' => 'MILITARES POR REFERÊNCIA E ÓRGÃO', 'ordem' => 40]);
        Relatorio::create(['id' => 5, 'relatorio_grupo_id' => 3, 'name' => 'RESSARCIMENTO POR REFERÊNCIA E ÓRGÃO', 'ordem' => 50]);
        Relatorio::create(['id' => 6, 'relatorio_grupo_id' => 3, 'name' => 'DÍVIDA DO(S) ÓRGÃO(S)', 'ordem' => 60]);

        Relatorio::create(['id' => 7, 'relatorio_grupo_id' => 2, 'name' => 'MILITARES POR SITUAÇÃO', 'ordem' => 70]);
        Relatorio::create(['id' => 8, 'relatorio_grupo_id' => 2, 'name' => 'MILITARES POR GRADUAÇÃO', 'ordem' => 80]);
        Relatorio::create(['id' => 9, 'relatorio_grupo_id' => 2, 'name' => 'MILITARES POR UNIDADE', 'ordem' => 90]);
        Relatorio::create(['id' => 10, 'relatorio_grupo_id' => 2, 'name' => 'MILITARES POR QUADRO', 'ordem' => 100]);
        Relatorio::create(['id' => 11, 'relatorio_grupo_id' => 2, 'name' => 'MILITARES POR COMPORTAMENTO', 'ordem' => 110]);
        Relatorio::create(['id' => 12, 'relatorio_grupo_id' => 2, 'name' => 'MILITARES', 'ordem' => 120]);

        // Grupos Relatórios
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 1]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 2]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 3]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 4]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 5]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 6]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 7]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 8]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 9]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 10]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 11]);
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 12]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
