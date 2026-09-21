<?php

namespace App\Http\Controllers\Web;

use App\Domain\Curso\CursoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CursoStoreRequest;
use App\Http\Requests\CursoUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function __construct(
        private CursoService $cursoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $cursos = $this->cursoService->getCursos(1000);

            // Dados recebidos com sucesso
            if ($cursos) {
                return $this->datatable($cursos);
            } else {
                abort(500, 'Erro Interno Curso');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('cursos');

            return view('cursos.index');
        }
    }

    public function filter(Request $request, string $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $cursos = $this->cursoService->getCursosFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($cursos) {
                return $this->datatable($cursos);
            } else {
                abort(500, 'Erro Interno Curso');
            }
        } else {
            return view('cursos.index');
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
                $curso = $this->cursoService->getCurso($id);

                if (!$curso) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                return response()->json(['success' => $curso]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(CursoStoreRequest $request)
    {
        try {
            // Create
            $this->cursoService->createCurso($request->all());

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
                $curso = $this->cursoService->editCurso($id);

                return response()->json(['success' => $curso]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(CursoUpdateRequest $request, int $id)
    {
        try {
            $this->cursoService->updateCurso($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->cursoService->deleteCurso($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
