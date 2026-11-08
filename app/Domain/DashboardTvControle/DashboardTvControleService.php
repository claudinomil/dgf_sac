<?php

namespace App\Domain\DashboardTvControle;

class DashboardTvControleService
{
    public function __construct(
        private DashboardTvControleRepository $repository
    ) {}

    public function editDashboardTvControle(int $id)
    {
        $dashboard_tv_controle = $this->repository->find($id);

        if (!$dashboard_tv_controle) {
            throw new \Exception('Registro não encontrado.');
        }

        return $dashboard_tv_controle;
    }

    public function updateDashboardTvControle(int $id, array $data)
    {
        $dashboard_tv_controle = $this->repository->find($id);

        if (!$dashboard_tv_controle) {
            throw new \Exception('Registro não encontrado.');
        }

        return $this->repository->update($id, $data);
    }
}
