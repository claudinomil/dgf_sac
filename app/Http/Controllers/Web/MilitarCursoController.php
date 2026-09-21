<?php

namespace App\Http\Controllers\Web;

use App\Domain\Curso\CursoService;
use App\Domain\MilitarCurso\MilitarCursoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MilitarCursoStoreRequest;
use App\Http\Requests\MilitarCursoUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class MilitarCursoController extends Controller
{
    public function __construct(
        private MilitarCursoService $militarCursoService,
        private CursoService $cursoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $militares_cursos = $this->militarCursoService->getMilitaresCursos(1000);

            // Dados recebidos com sucesso
            if ($militares_cursos) {
                return $this->datatable($militares_cursos);
            } else {
                abort(500, 'Erro Interno Militar Curso');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('militares_cursos');

            $cursos = $this->cursoService->getCursos();

            return view('militares_cursos.index', compact(['cursos']));
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $militares_cursos = $this->militarCursoService->getMilitaresCursosFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($militares_cursos) {
                return $this->datatable($militares_cursos);
            } else {
                abort(500, 'Erro Interno Militares Curso');
            }
        } else {
            return view('militares_cursos.index');
        }
    }

    public function datatable($registros)
    {
        $allData = DataTables::of($registros)
            ->addIndexColumn()
            ->editColumn('militar', function ($row) {
                $retorno = '<div class="text-nowrap">
                                <div class="col-12">' . $row["militarNome"] . '</div>
                                <div class="col-12 mt-2"><b>RG</b> : ' . $row["militarRg"] . '</div>
                                <div class="col-12"><b>Situação</b> : ' . $row["militarSituacaoName"] . '</div>
                                <div class="col-12"><b>Posto/Graduação</b> : ' . $row["militarGraduacaoName"] . '</div>
                                <div class="col-12"><b>Quadro</b> : ' . $row["militarQuadroName"] . ' - ' . $row['militarQuadroEspecialidadeName'] . '</div>
                            </div>';

                return $retorno;
            })
            ->editColumn('curso', function ($row) {
                $retorno = '<div class="col-12">' . $row["cursoName"] . '</div>
                            <div class="col-12 mt-2"><b>Datas</b> : ' . getDataFormatada(1, $row["data_inicio"]) . ' - ' . getDataFormatada(1, $row["data_termino"]) . '</div>
                            <div class="col-12"><b>Conceito</b> : ' . $row["conceito"] . '</div>
                            <div class="col-12"><b>Classificação</b> : ' . $row["classificacao"] . '</div>';

                return $retorno;
            })
            ->addColumn('action', function ($row) {
                $permissaoShow = temPermissaoSituacao('militares_cursos', 'show', $row['militarSituacaoId']);
                $permissaoEdit = temPermissaoSituacao('militares_cursos', 'edit', $row['militarSituacaoId']);
                $permissaoDestroy = temPermissaoSituacao('militares_cursos', 'destroy', $row['militarSituacaoId']);

                $botoes = 7;

                if (!$permissaoShow and !$permissaoEdit and !$permissaoDestroy) {$botoes = 0;}
                if ($permissaoShow and !$permissaoEdit and !$permissaoDestroy) {$botoes = 1;}
                if (!$permissaoShow and $permissaoEdit and !$permissaoDestroy) {$botoes = 2;}
                if (!$permissaoShow and !$permissaoEdit and $permissaoDestroy) {$botoes = 3;}
                if ($permissaoShow and $permissaoEdit and !$permissaoDestroy) {$botoes = 4;}
                if ($permissaoShow and !$permissaoEdit and $permissaoDestroy) {$botoes = 5;}
                if (!$permissaoShow and $permissaoEdit and $permissaoDestroy) {$botoes = 6;}
                if ($permissaoShow and $permissaoEdit and $permissaoDestroy) {$botoes = 7;}

                return $this->columnAction($row['id'], $botoes);
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
                $militar_curso = $this->militarCursoService->getMilitarCurso($id);

                if (!$militar_curso) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $militar_curso->toArray();

                $dados['data_inicio'] = $militar_curso->data_inicio ? $militar_curso->data_inicio->format('d/m/Y') : '';
                $dados['data_termino'] = $militar_curso->data_termino ? $militar_curso->data_termino->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(MilitarCursoStoreRequest $request)
    {
        try {
            // Create
            $this->militarCursoService->createMilitarCurso($request->all());

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
                $curso = $this->militarCursoService->editMilitarCurso($id);

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $curso->toArray();

                $dados['data_inicio'] = $curso->data_inicio ? $curso->data_inicio->format('d/m/Y') : '';
                $dados['data_termino'] = $curso->data_termino ? $curso->data_termino->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(MilitarCursoUpdateRequest $request, int $id)
    {
        try {
            $this->militarCursoService->updateMilitarCurso($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->militarCursoService->deleteMilitarCurso($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
