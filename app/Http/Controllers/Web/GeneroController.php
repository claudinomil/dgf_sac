<?php

namespace App\Http\Controllers\Web;

use App\Domain\Genero\GeneroService;
use App\Http\Controllers\Controller;
use App\Http\Requests\GeneroStoreRequest;
use App\Http\Requests\GeneroUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    public function __construct(
        private GeneroService $generoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $generos = $this->generoService->getGeneros(1000);

            // Dados recebidos com sucesso
            if ($generos) {
                return $this->datatable($generos);
            } else {
                abort(500, 'Erro Interno Genero');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('generos');

            return view('generos.index');
        }
    }

    public function filter(Request $request, string $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $generos = $this->generoService->getGenerosFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($generos) {
                return $this->datatable($generos);
            } else {
                abort(500, 'Erro Interno Genero');
            }
        } else {
            return view('generos.index');
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
                $genero = $this->generoService->getGenero($id);

                if (!$genero) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                return response()->json(['success' => $genero]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(GeneroStoreRequest $request)
    {
        try {
            // Create
            $this->generoService->createGenero($request->all());

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
                $genero = $this->generoService->editGenero($id);

                return response()->json(['success' => $genero]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(GeneroUpdateRequest $request, int $id)
    {
        try {
            $this->generoService->updateGenero($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->generoService->deleteGenero($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
