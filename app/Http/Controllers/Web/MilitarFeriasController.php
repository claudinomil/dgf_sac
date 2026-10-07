<?php

namespace App\Http\Controllers\Web;

use App\Domain\MilitarFerias\MilitarFeriasService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MilitarFeriasStoreRequest;
use App\Http\Requests\MilitarFeriasUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class MilitarFeriasController extends Controller
{
    public function __construct(
        private MilitarFeriasService $militarFeriasService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $militares_ferias = $this->militarFeriasService->getMilitaresFerias(1000);

            // Dados recebidos com sucesso
            if ($militares_ferias) {
                return $this->datatable($militares_ferias);
            } else {
                abort(500, 'Erro Interno Militar Ferias');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('militares_ferias');

            return view('militares_ferias.index');
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $militares_ferias = $this->militarFeriasService->getMilitaresFeriasFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($militares_ferias) {
                return $this->datatable($militares_ferias);
            } else {
                abort(500, 'Erro Interno Militares Ferias');
            }
        } else {
            return view('militares_ferias.index');
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
            ->editColumn('ferias', function ($row) {
                $retorno = '<div class="col-12">' . $row["feriasName"] . '</div>
                            <div class="col-12 mt-2"><b>Datas</b> : ' . getDataFormatada(1, $row["data_inicio"]) . ' - ' . getDataFormatada(1, $row["data_termino"]) . '</div>
                            <div class="col-12"><b>Conceito</b> : ' . $row["conceito"] . '</div>
                            <div class="col-12"><b>Classificação</b> : ' . $row["classificacao"] . '</div>';

                return $retorno;
            })
            ->addColumn('action', function ($row) {
                $permissaoShow = temPermissaoSituacao('militares_ferias', 'show', $row['militarSituacaoId']);
                $permissaoEdit = temPermissaoSituacao('militares_ferias', 'edit', $row['militarSituacaoId']);
                $permissaoDestroy = temPermissaoSituacao('militares_ferias', 'destroy', $row['militarSituacaoId']);

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
                $militar_ferias = $this->militarFeriasService->getMilitarFerias($id);

                if (!$militar_ferias) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $militar_ferias->toArray();

                $dados['data_inicio'] = $militar_ferias->data_inicio ? $militar_ferias->data_inicio->format('d/m/Y') : '';
                $dados['data_termino'] = $militar_ferias->data_termino ? $militar_ferias->data_termino->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(MilitarFeriasStoreRequest $request)
    {
        try {
            // Create
            $this->militarFeriasService->createMilitarFerias($request->all());

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
                $ferias = $this->militarFeriasService->editMilitarFerias($id);

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $ferias->toArray();

                $dados['data_inicio'] = $ferias->data_inicio ? $ferias->data_inicio->format('d/m/Y') : '';
                $dados['data_termino'] = $ferias->data_termino ? $ferias->data_termino->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(MilitarFeriasUpdateRequest $request, int $id)
    {
        try {
            $this->militarFeriasService->updateMilitarFerias($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->militarFeriasService->deleteMilitarFerias($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
