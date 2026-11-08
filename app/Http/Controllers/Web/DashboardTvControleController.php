<?php

namespace App\Http\Controllers\Web;

use App\Domain\DashboardTvControle\DashboardTvControleService;
use App\Domain\DashboardTvIndicadorGrafico\DashboardTvIndicadorGraficoService;
use App\Domain\Unidade\UnidadeService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardTvControleController extends Controller
{
    public function __construct(
        private DashboardTvControleService $dashboardTvControleService,
        private DashboardTvIndicadorGraficoService $dashboardTvIndicadorGraficoService,
        private UnidadeService $unidadeService
    ) {}

    public function index(Request $request)
    {
        setCrudSessions('dashboards_tvs_controles');

        $indicadores = $this->dashboardTvIndicadorGraficoService->getDashboardsTvsIndicadores();
        $graficos = $this->dashboardTvIndicadorGraficoService->getDashboardsTvsGraficos();
        $unidades = $this->unidadeService->getAll();

        return view('dashboards_tvs_controles.index', compact(['indicadores', 'graficos', 'unidades']));
    }

    public function edit(Request $request, int $id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            try {
                $dashboard_tv_controle = $this->dashboardTvControleService->editDashboardTvControle($id);

                return response()->json(['success' => $dashboard_tv_controle]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            // Array
            $dados = [];

            // Unidade
            $dados['unidade_id'] = $request['unidade_id'];

            // Ano
            $dados['ano'] = $request['ano'];

            // Indicadores
            for ($i = 1; $i <= 12; $i++) {
                $campo = 'indicador_'.$i;
                $dados[$campo] = $request->exists($campo) ? 1 : 0;
            }

            // Gráficos
            for ($i = 1; $i <= 12; $i++) {
                $campo = 'grafico_'.$i;
                $dados[$campo] = $request->exists($campo) ? 1 : 0;
            }

            // Ordens dos indicadores
            for ($i = 1; $i <= 12; $i++) {
                $campo = 'indicador_'.$i.'_ordem';

                if ($request->exists($campo)) {
                    $dados[$campo] = $request->input($campo);
                }
            }

            // Ordens dos gráficos
            for ($i = 1; $i <= 12; $i++) {
                $campo = 'grafico_'.$i.'_ordem';

                if ($request->exists($campo)) {
                    $dados[$campo] = $request->input($campo);
                }
            }

            // Colunas dos indicadores
            for ($i = 1; $i <= 12; $i++) {
                $campo = 'indicador_'.$i.'_colunas';

                if ($request->exists($campo)) {
                    $dados[$campo] = $request->input($campo);
                }
            }

            // Colunas dos gráficos
            for ($i = 1; $i <= 12; $i++) {
                $campo = 'grafico_'.$i.'_colunas';

                if ($request->exists($campo)) {
                    $dados[$campo] = $request->input($campo);
                }
            }

            // Atualizar registro
            $this->dashboardTvControleService->updateDashboardTvControle($id, $dados);

            return response()->json(['success' => 'Registro atualizado com sucesso']);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
