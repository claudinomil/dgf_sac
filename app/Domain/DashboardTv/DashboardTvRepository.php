<?php

namespace App\Domain\DashboardTv;

use Illuminate\Support\Facades\DB;

class DashboardTvRepository
{
    /**
     * Retorna o total de militares cadastrados.
     */
    public function totalMilitares(): int
    {
        return DB::table('militares')->count();
    }

    /**
     * Retorna o total de dependentes cadastrados.
     */
    public function totalDependentes(): int
    {
        return DB::table('militares_dependentes')->count();
    }

    /**
     * Retorna a quantidade de militares por comportamento.
     *
     * A identificação é apresentada pelo ID porque
     * ainda não definimos os campos descritivos da tabela
     * comportamentos.
     */
    public function militaresPorComportamento(): array
    {
        return DB::table('militares')
            ->select('comportamento_id')
            ->selectRaw('COUNT(*) AS total')
            ->groupBy('comportamento_id')
            ->orderByDesc('total')
            ->get()
            ->map(function ($item) {
                return [
                    'comportamento_id' => $item->comportamento_id,
                    'total' => (int) $item->total,
                ];
            })
            ->toArray();
    }
}