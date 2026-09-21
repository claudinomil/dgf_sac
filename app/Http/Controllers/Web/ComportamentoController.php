<?php

namespace App\Http\Controllers\Web;

use App\Domain\Comportamento\ComportamentoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ComportamentoStoreRequest;
use App\Http\Requests\ComportamentoUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class ComportamentoController extends Controller
{
    public function __construct(
        private ComportamentoService $comportamentoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $comportamentos = $this->comportamentoService->getComportamentos(1000);

            // Dados recebidos com sucesso
            if ($comportamentos) {
                return $this->datatable($comportamentos);
            } else {
                abort(500, 'Erro Interno Comportamento');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('comportamentos');

            return view('comportamentos.index');
        }
    }

    public function filter(Request $request, string $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $comportamentos = $this->comportamentoService->getComportamentosFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($comportamentos) {
                return $this->datatable($comportamentos);
            } else {
                abort(500, 'Erro Interno Comportamento');
            }
        } else {
            return view('comportamentos.index');
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
                $comportamento = $this->comportamentoService->getComportamento($id);

                if (!$comportamento) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                return response()->json(['success' => $comportamento]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(ComportamentoStoreRequest $request)
    {
        try {
            // Create
            $this->comportamentoService->createComportamento($request->all());

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
                $comportamento = $this->comportamentoService->editComportamento($id);

                return response()->json(['success' => $comportamento]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(ComportamentoUpdateRequest $request, int $id)
    {
        try {
            $this->comportamentoService->updateComportamento($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->comportamentoService->deleteComportamento($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
