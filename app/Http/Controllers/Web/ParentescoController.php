<?php

namespace App\Http\Controllers\Web;

use App\Domain\Parentesco\ParentescoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ParentescoStoreRequest;
use App\Http\Requests\ParentescoUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class ParentescoController extends Controller
{
    public function __construct(
        private ParentescoService $parentescoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $parentescos = $this->parentescoService->getParentescos(1000);

            // Dados recebidos com sucesso
            if ($parentescos) {
                return $this->datatable($parentescos);
            } else {
                abort(500, 'Erro Interno Parentesco');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('parentescos');

            return view('parentescos.index');
        }
    }

    public function filter(Request $request, string $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $parentescos = $this->parentescoService->getParentescosFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($parentescos) {
                return $this->datatable($parentescos);
            } else {
                abort(500, 'Erro Interno Parentesco');
            }
        } else {
            return view('parentescos.index');
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
                $parentesco = $this->parentescoService->getParentesco($id);

                if (!$parentesco) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                return response()->json(['success' => $parentesco]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(ParentescoStoreRequest $request)
    {
        try {
            // Create
            $this->parentescoService->createParentesco($request->all());

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
                $parentesco = $this->parentescoService->editParentesco($id);

                return response()->json(['success' => $parentesco]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(ParentescoUpdateRequest $request, int $id)
    {
        try {
            $this->parentescoService->updateParentesco($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->parentescoService->deleteParentesco($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
