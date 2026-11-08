<?php

namespace App\Http\Controllers\Web;

use App\Domain\DashboardTv\DashboardTvService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardTvController extends Controller
{
    public function __construct(
        private DashboardTvService $service
    ) {}

    public function index(): View
    {
        return view('dashboards_tvs.index');
    }

    /**
     * Retorna os indicadores e gráficos escolhidos
     */
    public function indicadores_graficos(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            try {
                // Buscar
                $dados = $this->service->getIndicadoresGraficos();

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }
}
