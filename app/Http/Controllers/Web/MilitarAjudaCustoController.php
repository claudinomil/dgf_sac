<?php

namespace App\Http\Controllers\Web;

use App\Domain\AjudaCustoTipo\AjudaCustoTipoService;
use App\Domain\MilitarAjudaCusto\MilitarAjudaCustoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MilitarAjudaCustoStoreRequest;
use App\Http\Requests\MilitarAjudaCustoUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class MilitarAjudaCustoController extends Controller
{
    public function __construct(
        private MilitarAjudaCustoService $militarAjudaCustoService,
        private AjudaCustoTipoService $ajudaCustoTipoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $militares_ajudas_custos = $this->militarAjudaCustoService->getMilitaresAjudasCustos(1000);

            // Dados recebidos com sucesso
            if ($militares_ajudas_custos) {
                return $this->datatable($militares_ajudas_custos);
            } else {
                abort(500, 'Erro Interno Militar Ajuda Custo');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('militares_ajudas_custos');

            $ajuda_custo_tipos = $this->ajudaCustoTipoService->getAjudaCustoTipos();

            return view('militares_ajudas_custos.index', compact(['ajuda_custo_tipos']));
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $militares_ajudas_custos = $this->militarAjudaCustoService->getMilitaresAjudasCustosFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($militares_ajudas_custos) {
                return $this->datatable($militares_ajudas_custos);
            } else {
                abort(500, 'Erro Interno Militares Ajuda Custo');
            }
        } else {
            return view('militares_ajudas_custos.index');
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
            ->editColumn('ajuda_custo', function ($row) {
                $retorno = '<div class="col-12">' . $row["ajudaCustoTipoName"] . '</div>';

                if ($row["ajuda_custo_tipo_id"] == 2) {
                    $retorno .= '<div class="col-12"><b>Curso</b> : ' . $row["curso"] . '</div>';
                }

                $retorno .= '<div class="col-12"><b>Pagamento</b> : ' . $row["pagamento"] . '</div>';
                $retorno .= '<div class="col-12"><b>Boletim</b> : ' . $row["boletim"] . '</div>';

                return $retorno;
            })
            ->addColumn('action', function ($row) {
                $permissaoShow = temPermissaoSituacao('militares_ajudas_custos', 'show', $row['militarSituacaoId']);
                $permissaoEdit = temPermissaoSituacao('militares_ajudas_custos', 'edit', $row['militarSituacaoId']);
                $permissaoDestroy = temPermissaoSituacao('militares_ajudas_custos', 'destroy', $row['militarSituacaoId']);

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
                $militar_ajuda_custo = $this->militarAjudaCustoService->getMilitarAjudaCusto($id);

                if (!$militar_ajuda_custo) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $militar_ajuda_custo->toArray();

                $dados['data_inicio'] = $militar_ajuda_custo->data_inicio ? $militar_ajuda_custo->data_inicio->format('d/m/Y') : '';
                $dados['data_termino'] = $militar_ajuda_custo->data_termino ? $militar_ajuda_custo->data_termino->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(MilitarAjudaCustoStoreRequest $request)
    {
        try {
            // Create
            $this->militarAjudaCustoService->createMilitarAjudaCusto($request->all());

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
                $ajuda_custo = $this->militarAjudaCustoService->editMilitarAjudaCusto($id);

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $ajuda_custo->toArray();

                $dados['data_inicio'] = $ajuda_custo->data_inicio ? $ajuda_custo->data_inicio->format('d/m/Y') : '';
                $dados['data_termino'] = $ajuda_custo->data_termino ? $ajuda_custo->data_termino->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(MilitarAjudaCustoUpdateRequest $request, int $id)
    {
        try {
            $this->militarAjudaCustoService->updateMilitarAjudaCusto($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->militarAjudaCustoService->deleteMilitarAjudaCusto($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
