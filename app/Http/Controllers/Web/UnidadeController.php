<?php

namespace App\Http\Controllers\Web;

use App\Domain\Unidade\UnidadeService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UnidadeStoreRequest;
use App\Http\Requests\UnidadeUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function __construct(
        private UnidadeService $unidadeService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $unidades = $this->unidadeService->getUnidades(1000);

            // Dados recebidos com sucesso
            if ($unidades) {
                return $this->datatable($unidades);
            } else {
                abort(500, 'Erro Interno Unidade');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('unidades');

            return view('unidades.index');
        }
    }

    public function filter(Request $request, string $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $unidades = $this->unidadeService->getUnidadesFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($unidades) {
                return $this->datatable($unidades);
            } else {
                abort(500, 'Erro Interno Unidade');
            }
        } else {
            return view('unidades.index');
        }
    }

    public function datatable($registros)
    {
        $allData = DataTables::of($registros)
            ->addIndexColumn()
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
        //Verificando Origem enviada pelo Fetch
        if ($_SERVER['HTTP_REQUEST_ORIGIN'] == 'fetch') {
            return response()->json(['success' => true]);
        }
    }

    public function show(Request $request, int $id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            try {
                // Buscar
                $unidade = $this->unidadeService->getUnidade($id);

                if (!$unidade) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                return response()->json(['success' => $unidade]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(UnidadeStoreRequest $request)
    {
        try {
            // Create
            $this->unidadeService->createUnidade($request->all());

            return response()->json(['success' => 'Registro criado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function edit(Request $request, int $id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            try {
                $unidade = $this->unidadeService->editUnidade($id);

                return response()->json(['success' => $unidade]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(UnidadeUpdateRequest $request, int $id)
    {
        try {
            $this->unidadeService->updateUnidade($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->unidadeService->deleteUnidade($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
