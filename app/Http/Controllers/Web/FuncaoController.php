<?php

namespace App\Http\Controllers\Web;

use App\Domain\Funcao\FuncaoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\FuncaoStoreRequest;
use App\Http\Requests\FuncaoUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class FuncaoController extends Controller
{
    public function __construct(
        private FuncaoService $funcaoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $funcoes = $this->funcaoService->getFuncoes(1000);

            // Dados recebidos com sucesso
            if ($funcoes) {
                return $this->datatable($funcoes);
            } else {
                abort(500, 'Erro Interno Funcao');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('funcoes');

            return view('funcoes.index');
        }
    }

    public function filter(Request $request, string $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $funcoes = $this->funcaoService->getFuncoesFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($funcoes) {
                return $this->datatable($funcoes);
            } else {
                abort(500, 'Erro Interno Funcao');
            }
        } else {
            return view('funcoes.index');
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
                $funcao = $this->funcaoService->getFuncao($id);

                if (!$funcao) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                return response()->json(['success' => $funcao]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(FuncaoStoreRequest $request)
    {
        try {
            // Create
            $this->funcaoService->createFuncao($request->all());

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
                $funcao = $this->funcaoService->editFuncao($id);

                return response()->json(['success' => $funcao]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(FuncaoUpdateRequest $request, int $id)
    {
        try {
            $this->funcaoService->updateFuncao($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->funcaoService->deleteFuncao($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
