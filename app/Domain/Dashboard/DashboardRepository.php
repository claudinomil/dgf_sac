<?php

namespace App\Domain\Dashboard;

use App\Models\GrupoGrafico;
use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    public function permissoes_graficos(int $grupo_id)
    {
        return GrupoGrafico::where('grupo_id', $grupo_id)->pluck('grafico_id')->toarray();
    }

    public function grafico_1()
    {
        return DB::select("SELECT grupos.name, count(users.id) as quantidade FROM users INNER JOIN grupos ON users.grupo_id=grupos.id GROUP BY grupos.name ORDER BY grupos.name");
    }

    public function grafico_2()
    {
        return DB::select("SELECT transacoes.operacao_id, operacoes.name, COUNT(*) as quantidade FROM transacoes INNER JOIN operacoes ON operacoes.id = transacoes.operacao_id GROUP BY transacoes.operacao_id, operacoes.name ORDER BY operacoes.name");
    }

    public function grafico_3()
    {
        return DB::select("SELECT transacoes.submodulo_id, submodulos.name, COUNT(*) as quantidade FROM transacoes INNER JOIN submodulos ON submodulos.id = transacoes.submodulo_id GROUP BY transacoes.submodulo_id, submodulos.name ORDER BY submodulos.name");
    }

    public function grafico_4()
    {
        return DB::select("SELECT situacoes.name, count(militares.id) as quantidade FROM militares
            INNER JOIN situacoes ON militares.situacao_id=situacoes.id
            WHERE militares.situacao_id IN(1, 10)
            AND militares.graduacao_id IN(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18)
            GROUP BY situacoes.name
            ORDER BY situacoes.name");
    }

    public function grafico_5($militares_selecionados, $quadros_selecionados)
    {
        $graduacoes = [
            2 => [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
            3 => [2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
            6 => [12, 13, 14, 15, 16, 17, 18]
        ];

        $query = DB::table('militares')
                    ->join('quadros', 'militares.quadro_id', '=', 'quadros.id')
                    ->select('quadros.id', 'quadros.name', DB::raw('COUNT(militares.id) as quantidade'))
                    ->whereIn('militares.situacao_id', [1, 10])
                    ->whereIn('militares.quadro_id', $quadros_selecionados);

        if (isset($graduacoes[$militares_selecionados])) {
            $query->whereIn('militares.graduacao_id', $graduacoes[$militares_selecionados]);
        }

        return $query->groupBy('quadros.id', 'quadros.name')->orderBy('quadros.id')->get();
    }

    public function grafico_6(Int $militares_selecionados, Array $graduacoes_selecionadas)
    {
        $graduacoes = [
            2 => [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18],
            3 => [2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
            6 => [12, 13, 14, 15, 16, 17, 18]
        ];

        $query = DB::table('militares')
                    ->join('graduacoes', 'militares.graduacao_id', '=', 'graduacoes.id')
                    ->select('graduacoes.id', 'graduacoes.name', DB::raw('COUNT(militares.id) as quantidade'))
                    ->whereIn('militares.situacao_id', [1, 10])
                    ->whereIn('militares.graduacao_id', $graduacoes_selecionadas);

        if (isset($graduacoes[$militares_selecionados])) {
            $query->whereIn('militares.graduacao_id', $graduacoes[$militares_selecionados]);
        }

        return $query->groupBy('graduacoes.id', 'graduacoes.name')->orderBy('graduacoes.id')->get();
    }

    public function grafico_7()
    {
        return DB::select("SELECT comportamentos.name, count(militares.id) as quantidade FROM militares
            INNER JOIN comportamentos ON militares.comportamento_id=comportamentos.id
            WHERE militares.situacao_id IN(1, 10)
            AND militares.graduacao_id IN(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18)
            GROUP BY comportamentos.name
            ORDER BY comportamentos.name");
    }

    public function grafico_8(string $periodo_1, string $periodo_2, int $orgao_id)
    {
        return DB::select("SELECT situacoes.name, count(militares.id) as quantidade FROM militares
            INNER JOIN situacoes ON militares.situacao_id=situacoes.id
            WHERE militares.situacao_id IN(1, 10)
            AND militares.graduacao_id IN(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18)
            GROUP BY situacoes.name
            ORDER BY situacoes.name");
    }

    public function grafico_9(string $periodo_1, string $periodo_2, int $orgao_id)
    {
        return DB::select("SELECT situacoes.name, count(militares.id) as quantidade FROM militares
            INNER JOIN situacoes ON militares.situacao_id=situacoes.id
            WHERE militares.situacao_id IN(1, 10)
            AND militares.graduacao_id IN(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18)
            GROUP BY situacoes.name
            ORDER BY situacoes.name");
    }

    public function grafico_10(string $periodo_1, string $periodo_2, int $orgao_id)
    {
        return DB::select("SELECT situacoes.name, count(militares.id) as quantidade FROM militares
            INNER JOIN situacoes ON militares.situacao_id=situacoes.id
            WHERE militares.situacao_id IN(1, 10)
            AND militares.graduacao_id IN(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18)
            GROUP BY situacoes.name
            ORDER BY situacoes.name");
    }

    public function grafico_11(string $periodo_1, string $periodo_2, int $orgao_id)
    {
        return DB::select("SELECT situacoes.name, count(militares.id) as quantidade FROM militares
            INNER JOIN situacoes ON militares.situacao_id=situacoes.id
            WHERE militares.situacao_id IN(1, 10)
            AND militares.graduacao_id IN(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18)
            GROUP BY situacoes.name
            ORDER BY situacoes.name");
    }

    public function grafico_12(string $periodo_1, string $periodo_2, int $orgao_id)
    {
        return DB::select("SELECT situacoes.name, count(militares.id) as quantidade FROM militares
            INNER JOIN situacoes ON militares.situacao_id=situacoes.id
            WHERE militares.situacao_id IN(1, 10)
            AND militares.graduacao_id IN(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18)
            GROUP BY situacoes.name
            ORDER BY situacoes.name");
    }

    public function grafico_13()
    {
        return DB::select("SELECT situacoes.name, count(militares.id) as quantidade FROM militares
            INNER JOIN situacoes ON militares.situacao_id=situacoes.id
            WHERE militares.situacao_id IN(1, 10)
            AND militares.graduacao_id IN(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18)
            GROUP BY situacoes.name
            ORDER BY situacoes.name");
    }

    public function grafico_14()
    {
        return DB::select("SELECT situacoes.name, count(militares.id) as quantidade FROM militares
            INNER JOIN situacoes ON militares.situacao_id=situacoes.id
            WHERE militares.situacao_id IN(1, 10)
            AND militares.graduacao_id IN(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18)
            GROUP BY situacoes.name
            ORDER BY situacoes.name");
    }

    public function grafico_15()
    {
        return DB::select("SELECT situacoes.name, count(militares.id) as quantidade FROM militares
            INNER JOIN situacoes ON militares.situacao_id=situacoes.id
            WHERE militares.situacao_id IN(1, 10)
            AND militares.graduacao_id IN(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18)
            GROUP BY situacoes.name
            ORDER BY situacoes.name");
    }

    public function grafico_16()
    {
        return DB::select("SELECT situacoes.name, count(militares.id) as quantidade FROM militares
            INNER JOIN situacoes ON militares.situacao_id=situacoes.id
            WHERE militares.situacao_id IN(1, 10)
            AND militares.graduacao_id IN(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18)
            GROUP BY situacoes.name
            ORDER BY situacoes.name");
    }

    public function grafico_17()
    {
        return DB::select("SELECT situacoes.name, count(militares.id) as quantidade FROM militares
            INNER JOIN situacoes ON militares.situacao_id=situacoes.id
            WHERE militares.situacao_id IN(1, 10)
            AND militares.graduacao_id IN(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18)
            GROUP BY situacoes.name
            ORDER BY situacoes.name");
    }
}
