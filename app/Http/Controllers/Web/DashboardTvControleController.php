<?php

namespace App\Http\Controllers\Web;

use App\Domain\DashboardTvControle\DashboardTvControleService;
use App\Domain\Unidade\UnidadeService;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class DashboardTvControleController extends Controller
{
    public function __construct(
        private DashboardTvControleService $dashboardTvControleService,
        private UnidadeService $unidadeService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $dashboards_tvs_controles = $this->dashboardTvControleService->getDashboardsTvsControles(1000);

            // Dados recebidos com sucesso
            if ($dashboards_tvs_controles) {
                return $this->datatable($dashboards_tvs_controles);
            } else {
                abort(500, 'Erro Interno Dashboard Tv Controle');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('dashboards_tvs_controles');

            $unidades = $this->unidadeService->getAll();

            return view('dashboards_tvs_controles.index', compact(['unidades']));
        }
    }
    
    public function datatable($registros)
    {
        $allData = DataTables::of($registros)
            ->addIndexColumn()
            ->editColumn('unidade', function ($row) {
                $retorno = $row["unidadeName"];
                
                return $retorno;
            })
            ->editColumn('ano', function ($row) {
                $retorno = $row["ano"];
                
                return $retorno;
            })
            ->editColumn('indicadores', function ($row) {
                $retorno = '';

                for ($i = 1; $i <= 12; $i++) {
                    if (($row['indicador_'.$i] ?? 0) == 1) {
                        $retorno .= '<div class="col-12 text-primary">Indicador '.$i.'</div>';
                    }
                }
                
                return $retorno;
            })
            ->editColumn('graficos', function ($row) {
                $retorno = '';

                for ($i = 1; $i <= 12; $i++) {
                    if (($row['grafico_'.$i] ?? 0) == 1) {
                        $retorno .= '<div class="col-12 text-success">Gráfico '.$i.'</div>';
                    }
                }
                
                return $retorno;
            })
            ->addColumn('action', function ($row) {
                $botoes = 2;
                
                return $this->columnAction($row['id'], $botoes);
            })
            ->rawColumns(['action'])
            ->escapeColumns([])
            ->make(true);

        return $allData;
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

            // Atualizar registro
            $this->dashboardTvControleService->updateDashboardTvControle($id, $dados);

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}