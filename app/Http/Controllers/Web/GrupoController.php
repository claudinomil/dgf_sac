<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Domain\Grupo\GrupoService;
use App\Domain\Permissao\PermissaoService;
use App\Domain\Situacao\SituacaoService;
use App\Domain\Submodulo\SubmoduloService;
use App\Domain\UserContext\UserContextService;
use App\Http\Requests\GrupoStoreRequest;
use App\Http\Requests\GrupoUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function __construct(
        private GrupoService $grupoService,
        private SubmoduloService $submoduloService,
        private PermissaoService $permissaoService,
        private UserContextService $userContextService,
        private SituacaoService $situacaoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $grupos = $this->grupoService->getGrupos(1000);

            // Dados recebidos com sucesso
            if ($grupos) {
                return $this->datatable($grupos);
            } else {
                abort(500, 'Erro Interno Grupo');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('grupos');

            $submodulos = $this->submoduloService->getSubmodulosGradeGrupos();
            $permissoes = $this->permissaoService->getPermissoes();
            $relatorios = $this->grupoService->getRelatorios();
            $graficos = $this->grupoService->getGraficos();
            $situacoes = $this->situacaoService->getSituacoes(1000);

            return view('grupos.index', compact(['submodulos', 'permissoes', 'relatorios', 'graficos', 'situacoes']));
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $grupos = $this->grupoService->getGruposFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($grupos) {
                return $this->datatable($grupos);
            } else {
                abort(500, 'Erro Interno Grupo');
            }
        } else {
            return view('grupos.index');
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
            $grupo = $this->grupoService->getGrupo($id);

            if (!$grupo) {
                return response()->json(['error' => 'Registro não encontrado']);
            }

            return response()->json(['success' => $grupo]);
        }
    }

    public function store(GrupoStoreRequest $request)
    {
        try {
            // Create
            $this->grupoService->createGrupo($request->all());

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
                $grupo = $this->grupoService->editGrupo($id);

                if (!$grupo) {
                    return response()->json(['error' => 'Registro não encontrado'], 404);
                }

                return response()->json(['success' => $grupo]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(GrupoUpdateRequest $request, int $id)
    {
        try {
            $this->grupoService->updateGrupo($id, $request->all());

            // Se alteração é no Usuário Logado chama Refresh do UserContext
            if (session('userContext.user.grupo_id') == $id) {
                $this->userContextService->refresh();
            }

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->grupoService->deleteGrupo($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function grupo_permissoes(Request $request, int $grupo_id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $grupo_permissoes = $this->grupoService->getGrupoPermissoes($grupo_id);

            return response()->json(['success' => $grupo_permissoes]);
        }
    }

    public function grupo_relatorios(Request $request, int $grupo_id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $grupo_relatorios = $this->grupoService->getGrupoRelatorios($grupo_id);

            return response()->json(['success' => $grupo_relatorios]);
        }
    }

    public function grupo_graficos(Request $request, int $grupo_id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $grupo_graficos = $this->grupoService->getGrupoGraficos($grupo_id);

            return response()->json(['success' => $grupo_graficos]);
        }
    }
}
