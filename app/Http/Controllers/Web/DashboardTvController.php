<?php

namespace App\Http\Controllers\Web;

use App\Domain\DashboardTv\DashboardTvService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DashboardTvController extends Controller
{
    public function __construct(
        private DashboardTvService $dashboardTvService
    ) {}
    
    /**
     * Exibe a página do dashboard.
     */
    public function index(): View
    {
        return view('dashboards_tvs.index');
    }

    /**
     * Retorna os indicadores atualizados em JSON.
     */
    public function dados(): JsonResponse
    {
        return response()->json([
            'message' => 'Dados do dashboard carregados com sucesso.',
            'code' => 200,
            'validation' => null,
            'content' => $this->dashboardTvService->obterDados(),
        ]);
    }
}