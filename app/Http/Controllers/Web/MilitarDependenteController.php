<?php

namespace App\Http\Controllers\Web;

use App\Domain\MilitarDependente\MilitarDependenteService;
use App\Domain\Parentesco\ParentescoService;
use App\Domain\SexoBiologico\SexoBiologicoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MilitarDependenteStoreRequest;
use App\Http\Requests\MilitarDependenteUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class MilitarDependenteController extends Controller
{
    public function __construct(
        private MilitarDependenteService $militarDependenteService,
        private ParentescoService $parentescoService,
        private SexoBiologicoService $sexoBiologicoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $militares_dependentes = $this->militarDependenteService->getMilitaresDependentes(1000);

            // Dados recebidos com sucesso
            if ($militares_dependentes) {
                return $this->datatable($militares_dependentes);
            } else {
                abort(500, 'Erro Interno Militar Dependente');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('militares_dependentes');

            $parentescos = $this->parentescoService->getAll();
            $sexos_biologicos = $this->sexoBiologicoService->getAll();

            return view('militares_dependentes.index', compact(['parentescos', 'sexos_biologicos']));
        }
    }

    public function filter(Request $request, string $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $militares_dependentes = $this->militarDependenteService->getMilitaresDependentesFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($militares_dependentes) {
                return $this->datatable($militares_dependentes);
            } else {
                abort(500, 'Erro Interno Militares Dependente');
            }
        } else {
            return view('militares_dependentes.index');
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
            ->addColumn('action', function ($row) {
                $permissaoShow = temPermissaoSituacao('militares_dependentes', 'show', $row['militarSituacaoId']);
                $permissaoEdit = temPermissaoSituacao('militares_dependentes', 'edit', $row['militarSituacaoId']);
                $permissaoDestroy = temPermissaoSituacao('militares_dependentes', 'destroy', $row['militarSituacaoId']);

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
                $militar_dependente = $this->militarDependenteService->getMilitarDependente($id);

                if (!$militar_dependente) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $militar_dependente->toArray();

                $dados['data_nascimento'] = $militar_dependente->data_nascimento ? $militar_dependente->data_nascimento->format('d/m/Y') : '';
                $dados['data_casamento'] = $militar_dependente->data_casamento ? $militar_dependente->data_casamento->format('d/m/Y') : '';
                $dados['data_inicio_dependencia'] = $militar_dependente->data_inicio_dependencia ? $militar_dependente->data_inicio_dependencia->format('d/m/Y') : '';
                $dados['data_termino_dependencia'] = $militar_dependente->data_termino_dependencia ? $militar_dependente->data_termino_dependencia->format('d/m/Y') : '';
                $dados['data_inicio_contagem'] = $militar_dependente->data_inicio_contagem ? $militar_dependente->data_inicio_contagem->format('d/m/Y') : '';
                $dados['data_fim_contagem'] = $militar_dependente->data_fim_contagem ? $militar_dependente->data_fim_contagem->format('d/m/Y') : '';
                $dados['data_requerimento'] = $militar_dependente->data_requerimento ? $militar_dependente->data_requerimento->format('d/m/Y') : '';
                $dados['data_processo'] = $militar_dependente->data_processo ? $militar_dependente->data_processo->format('d/m/Y') : '';
                $dados['decisao_judicial_a_contar_de'] = $militar_dependente->decisao_judicial_a_contar_de ? $militar_dependente->decisao_judicial_a_contar_de->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(MilitarDependenteStoreRequest $request)
    {
        try {
            // Create
            $this->militarDependenteService->createMilitarDependente($request->all());

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
                $militar_dependente = $this->militarDependenteService->editMilitarDependente($id);

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $militar_dependente->toArray();

                $dados['data_nascimento'] = $militar_dependente->data_nascimento ? $militar_dependente->data_nascimento->format('d/m/Y') : '';
                $dados['data_casamento'] = $militar_dependente->data_casamento ? $militar_dependente->data_casamento->format('d/m/Y') : '';
                $dados['data_inicio_dependencia'] = $militar_dependente->data_inicio_dependencia ? $militar_dependente->data_inicio_dependencia->format('d/m/Y') : '';
                $dados['data_termino_dependencia'] = $militar_dependente->data_termino_dependencia ? $militar_dependente->data_termino_dependencia->format('d/m/Y') : '';
                $dados['data_inicio_contagem'] = $militar_dependente->data_inicio_contagem ? $militar_dependente->data_inicio_contagem->format('d/m/Y') : '';
                $dados['data_fim_contagem'] = $militar_dependente->data_fim_contagem ? $militar_dependente->data_fim_contagem->format('d/m/Y') : '';
                $dados['data_requerimento'] = $militar_dependente->data_requerimento ? $militar_dependente->data_requerimento->format('d/m/Y') : '';
                $dados['data_processo'] = $militar_dependente->data_processo ? $militar_dependente->data_processo->format('d/m/Y') : '';
                $dados['decisao_judicial_a_contar_de'] = $militar_dependente->decisao_judicial_a_contar_de ? $militar_dependente->decisao_judicial_a_contar_de->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(MilitarDependenteUpdateRequest $request, int $id)
    {
        try {
            $this->militarDependenteService->updateMilitarDependente($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->militarDependenteService->deleteMilitarDependente($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
