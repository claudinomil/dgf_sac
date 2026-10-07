<?php

namespace App\Http\Controllers\Web;

use App\Domain\TempoAverbadoLocal\TempoAverbadoLocalService;
use App\Domain\MilitarTempoAverbado\MilitarTempoAverbadoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MilitarTempoAverbadoStoreRequest;
use App\Http\Requests\MilitarTempoAverbadoUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MilitarTempoAverbadoController extends Controller
{
    public function __construct(
        private MilitarTempoAverbadoService $militarTempoAverbadoService,
        private TempoAverbadoLocalService $tempoAverbadoLocalService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $militares_tempos_averbados = $this->militarTempoAverbadoService->getMilitaresTemposAverbados(1000);

            // Dados recebidos com sucesso
            if ($militares_tempos_averbados) {
                return $this->datatable($militares_tempos_averbados);
            } else {
                abort(500, 'Erro Interno Militar TempoAverbado');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('militares_tempos_averbados');

            $tempos_averbados_locais = $this->tempoAverbadoLocalService->getTemposAverbadosLocais(99999);

            return view('militares_tempos_averbados.index', compact(['tempos_averbados_locais']));
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $militares_tempos_averbados = $this->militarTempoAverbadoService->getMilitaresTemposAverbadosFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($militares_tempos_averbados) {
                return $this->datatable($militares_tempos_averbados);
            } else {
                abort(500, 'Erro Interno Militares TempoAverbado');
            }
        } else {
            return view('militares_tempos_averbados.index');
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
            ->editColumn('dados', function ($row) {
                $retorno = '<div class="col-12"><b>Datas</b> : ' . getDataFormatada(1, $row["data_ingresso_local"]) . ' - ' . getDataFormatada(1, $row["data_termino_local"]) . '</div>
                            <div class="col-12"><b>Tempo Apurado</b> : ' . $row["tempo_apurado_local"] . '</div>
                            <div class="col-12"><b>Boletim</b> : ' . $row["boletim"] . '</div>';

                return $retorno;
            })
            ->addColumn('action', function ($row) {
                $permissaoShow = temPermissaoSituacao('militares_tempos_averbados', 'show', $row['militarSituacaoId']);
                $permissaoEdit = temPermissaoSituacao('militares_tempos_averbados', 'edit', $row['militarSituacaoId']);
                $permissaoDestroy = temPermissaoSituacao('militares_tempos_averbados', 'destroy', $row['militarSituacaoId']);

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
                $militar_tempo_averbado = $this->militarTempoAverbadoService->getMilitarTempoAverbado($id);

                if (!$militar_tempo_averbado) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $militar_tempo_averbado->toArray();

                $dados['data_ingresso_local'] = $militar_tempo_averbado->data_ingresso_local ? Carbon::parse($militar_tempo_averbado->data_ingresso_local)->format('d/m/Y') : '';
                $dados['data_termino_local'] = $militar_tempo_averbado->data_termino_local ? Carbon::parse($militar_tempo_averbado->data_termino_local)->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(MilitarTempoAverbadoStoreRequest $request)
    {
        try {
            // Create
            $this->militarTempoAverbadoService->createMilitarTempoAverbado($request->all());

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
                $militar_tempo_averbado = $this->militarTempoAverbadoService->editMilitarTempoAverbado($id);

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $militar_tempo_averbado->toArray();

                $dados['data_ingresso_local'] = $militar_tempo_averbado->data_ingresso_local ? Carbon::parse($militar_tempo_averbado->data_ingresso_local)->format('d/m/Y') : '';
                $dados['data_termino_local'] = $militar_tempo_averbado->data_termino_local ? Carbon::parse($militar_tempo_averbado->data_termino_local)->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(MilitarTempoAverbadoUpdateRequest $request, int $id)
    {
        try {
            $this->militarTempoAverbadoService->updateMilitarTempoAverbado($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->militarTempoAverbadoService->deleteMilitarTempoAverbado($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
