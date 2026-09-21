<?php

namespace App\Http\Controllers\Web;

use App\Domain\Quadro\QuadroService;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuadroStoreRequest;
use App\Http\Requests\QuadroUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class QuadroController extends Controller
{
    public function __construct(
        private QuadroService $quadroService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $quadros = $this->quadroService->getQuadros(1000);

            // Dados recebidos com sucesso
            if ($quadros) {
                return $this->datatable($quadros);
            } else {
                abort(500, 'Erro Interno Quadro');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('quadros');

            return view('quadros.index');
        }
    }

    public function filter(Request $request, string $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $quadros = $this->quadroService->getQuadrosFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($quadros) {
                return $this->datatable($quadros);
            } else {
                abort(500, 'Erro Interno Quadro');
            }
        } else {
            return view('quadros.index');
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
                $quadro = $this->quadroService->getQuadro($id);

                if (!$quadro) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                return response()->json(['success' => $quadro]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(QuadroStoreRequest $request)
    {
        try {
            // Create
            $this->quadroService->createQuadro($request->all());

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
                $quadro = $this->quadroService->editQuadro($id);

                return response()->json(['success' => $quadro]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(QuadroUpdateRequest $request, int $id)
    {
        try {
            $this->quadroService->updateQuadro($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->quadroService->deleteQuadro($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
