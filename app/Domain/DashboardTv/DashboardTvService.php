<?php

namespace App\Domain\DashboardTv;

use App\Domain\DashboardTv\DashboardTvRepository;

class DashboardTvService
{
    public function __construct(
        private DashboardTvRepository $repository
    ) {}
    
    /**
     * Retorna os dados necessários para o dashboard.
     */
    public function obterDados(): array
    {
        $militaresPorComportamento = $this->repository->militaresPorComportamento();
        
        return [
            'indicadores' => [
                'total_militares' => $this->repository->totalMilitares(),
                'total_dependentes' => $this->repository->totalDependentes(),
            ],

            'graficos' => [
                'militares_por_comportamento' => [
                    'labels' => array_map(
                        fn ($item) => $item['comportamento_id'] === null ? 'Não informado' : 'Comportamento ' . $item['comportamento_id'],
                        $militaresPorComportamento
                    ),

                    'dados' => array_column(
                        $militaresPorComportamento,
                        'total'
                    ),
                ],
            ],

            'atualizado_em' => now()->format('d/m/Y H:i:s'),
        ];
    }
}