<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Domain\RessarcimentoMilitar\RessarcimentoMilitarService;
use App\Domain\RessarcimentoReferencia\RessarcimentoReferenciaService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class RessarcimentoMilitarController extends Controller
{
    public function __construct(
        private RessarcimentoMilitarService $ressarcimentoMilitarService,
        private RessarcimentoReferenciaService $ressarcimentoReferenciaService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $ressarcimento_militares = $this->ressarcimentoMilitarService->getRessarcimentoMilitares(1000);

            // Dados recebidos com sucesso
            if ($ressarcimento_militares) {
                return $this->datatable($ressarcimento_militares);
            } else {
                abort(500, 'Erro Interno RessarcimentoMilitares');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('ressarcimento_militares');

            $referencias = $this->ressarcimentoReferenciaService->getReferenciasAtivas();

            return view('ressarcimento_militares.index', compact(['referencias']));
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $ressarcimento_militares = $this->ressarcimentoMilitarService->getRessarcimentoMilitaresFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($ressarcimento_militares) {
                return $this->datatable($ressarcimento_militares);
            } else {
                abort(500, 'Erro Interno RessarcimentoMilitares');
            }
        } else {
            return view('ressarcimento_militares.index');
        }
    }

    public function datatable($registros)
    {
        $allData = DataTables::of($registros)
            ->addIndexColumn()
            ->editColumn('referencia', function ($row) {
                $retorno = '<div class="text-nowrap">' . getReferencia(1, $row['referencia']) . '</div>';

                return $retorno;
            })
            ->editColumn('militar', function ($row) {
                $retorno = '<div class="col-12 text-nowrap">' . $row['nome'] . '</div>';
                $retorno .= '<div class="col-12">' . $row['posto_graduacao'] . ' ## ' . $row['quadro_qbmp'] . '</div>';
                $retorno .= '<div class="col-12">' . $row['identidade_funcional'] . ' ## ' . $row['rg'] . '</div>';

                return $retorno;
            })
            ->editColumn('lotacao', function ($row) {
                $retorno = $row['lotacao'] . '<br>' . $row['boletim'];
                return $retorno;
            })
            ->addColumn('action', function ($row) {
                return $this->columnAction($row['id']);
            })
            ->rawColumns(['action'])
            ->escapeColumns([])
            ->make(true);

        return $allData;
    }

    public function create()
    {
        // Verificando Origem enviada pelo Fetch
        if ($_SERVER['HTTP_REQUEST_ORIGIN'] == 'fetch') {
            return response()->json(['success' => true]);
        }
    }

    public function show(Request $request, $id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $ressarcimento_militar = $this->ressarcimentoMilitarService->getRessarcimentoMilitar($id);

            if (!$ressarcimento_militar) {
                return response()->json(['error' => 'Registro não encontrado']);
            }

            return response()->json(['success' => $ressarcimento_militar]);
        }
    }

    public function store(Request $request)
    {
        $this->ressarcimentoMilitarService->createRessarcimentoMilitar($request->all());

        return response()->json(['success' => 'Registro criado com sucesso']);
    }

    public function edit(Request $request, $id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            try {
                $ressarcimento_militar = $this->ressarcimentoMilitarService->editRessarcimentoMilitar($id);

                if (!$ressarcimento_militar) {
                    return response()->json(['error' => 'Registro não encontrado'], 404);
                }

                return response()->json(['success' => $ressarcimento_militar]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $this->ressarcimentoMilitarService->updateRessarcimentoMilitar($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->ressarcimentoMilitarService->deleteRessarcimentoMilitar($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // Importar Militares - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    // Importar Militares - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    public function importar(Request $request)
    {
        try {
            $resultado = $this->ressarcimentoMilitarService->importar($request);

            return response()->json(['success' => $resultado]);
        } catch (\Exception $e) {
            return response()->json(['error' => config('app.debug') ? $e->getMessage() : 'Erro interno.'], 400);
        }
    }
    // Importar Militares - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    // Importar Militares - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}
