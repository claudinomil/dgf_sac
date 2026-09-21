<?php

namespace App\Http\Controllers\Web;

use App\Domain\AuxilioFardamentoTipo\AuxilioFardamentoTipoService;
use App\Domain\MilitarAuxilioFardamento\MilitarAuxilioFardamentoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MilitarAuxilioFardamentoStoreRequest;
use App\Http\Requests\MilitarAuxilioFardamentoUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class MilitarAuxilioFardamentoController extends Controller
{
    public function __construct(
        private MilitarAuxilioFardamentoService $militarAuxilioFardamentoService,
        private AuxilioFardamentoTipoService $auxilioFardamentoTipoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $militares_auxilios_fardamentos = $this->militarAuxilioFardamentoService->getMilitaresAuxiliosFardamentos(1000);

            // Dados recebidos com sucesso
            if ($militares_auxilios_fardamentos) {
                return $this->datatable($militares_auxilios_fardamentos);
            } else {
                abort(500, 'Erro Interno Militar Auxílio Fardamento');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('militares_auxilios_fardamentos');

            $auxilio_fardamento_tipos = $this->auxilioFardamentoTipoService->getAuxilioFardamentoTipos();

            return view('militares_auxilios_fardamentos.index', compact(['auxilio_fardamento_tipos']));
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $militares_auxilios_fardamentos = $this->militarAuxilioFardamentoService->getMilitaresAuxiliosFardamentosFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($militares_auxilios_fardamentos) {
                return $this->datatable($militares_auxilios_fardamentos);
            } else {
                abort(500, 'Erro Interno Militares Auxílio Fardamento');
            }
        } else {
            return view('militares_auxilios_fardamentos.index');
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
            ->editColumn('auxilio_fardamento', function ($row) {
                $retorno = '<div class="col-12">' . $row["auxilioFardamentoTipoName"] . '</div>
                            <div class="col-12"><b>Pagamento</b> : ' . $row["pagamento"] . '</div>
                            <div class="col-12"><b>Boletim</b> : ' . $row["boletim"] . '</div>';

                return $retorno;
            })
            ->addColumn('action', function ($row) {
                $permissaoShow = temPermissaoSituacao('militares_auxilios_fardamentos', 'show', $row['militarSituacaoId']);
                $permissaoEdit = temPermissaoSituacao('militares_auxilios_fardamentos', 'edit', $row['militarSituacaoId']);
                $permissaoDestroy = temPermissaoSituacao('militares_auxilios_fardamentos', 'destroy', $row['militarSituacaoId']);

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
                $militar_auxilio_fardamento = $this->militarAuxilioFardamentoService->getMilitarAuxilioFardamento($id);

                if (!$militar_auxilio_fardamento) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $militar_auxilio_fardamento->toArray();

                $dados['data_inicio'] = $militar_auxilio_fardamento->data_inicio ? $militar_auxilio_fardamento->data_inicio->format('d/m/Y') : '';
                $dados['data_termino'] = $militar_auxilio_fardamento->data_termino ? $militar_auxilio_fardamento->data_termino->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(MilitarAuxilioFardamentoStoreRequest $request)
    {
        try {
            // Create
            $this->militarAuxilioFardamentoService->createMilitarAuxilioFardamento($request->all());

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
                $auxilio_fardamento = $this->militarAuxilioFardamentoService->editMilitarAuxilioFardamento($id);

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $auxilio_fardamento->toArray();

                $dados['data_inicio'] = $auxilio_fardamento->data_inicio ? $auxilio_fardamento->data_inicio->format('d/m/Y') : '';
                $dados['data_termino'] = $auxilio_fardamento->data_termino ? $auxilio_fardamento->data_termino->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(MilitarAuxilioFardamentoUpdateRequest $request, int $id)
    {
        try {
            $this->militarAuxilioFardamentoService->updateMilitarAuxilioFardamento($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->militarAuxilioFardamentoService->deleteMilitarAuxilioFardamento($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
