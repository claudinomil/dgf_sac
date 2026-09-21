<?php

namespace App\Http\Controllers\Web;

use App\Domain\Situacao\SituacaoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\SituacaoStoreRequest;
use App\Http\Requests\SituacaoUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class SituacaoController extends Controller
{
    public function __construct(
        private SituacaoService $situacaoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $situacoes = $this->situacaoService->getSituacoes(1000);

            // Dados recebidos com sucesso
            if ($situacoes) {
                return $this->datatable($situacoes);
            } else {
                abort(500, 'Erro Interno Situação');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('situacoes');

            return view('situacoes.index');
        }
    }

    public function filter(Request $request, string $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $situacoes = $this->situacaoService->getSituacoesFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($situacoes) {
                return $this->datatable($situacoes);
            } else {
                abort(500, 'Erro Interno Situação');
            }
        } else {
            return view('situacoes.index');
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
                $situacao = $this->situacaoService->getSituacao($id);

                if (!$situacao) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                return response()->json(['success' => $situacao]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(SituacaoStoreRequest $request)
    {
        try {
            // Create
            $this->situacaoService->createSituacao($request->all());

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
                $situacao = $this->situacaoService->editSituacao($id);

                return response()->json(['success' => $situacao]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(SituacaoUpdateRequest $request, int $id)
    {
        try {
            $this->situacaoService->updateSituacao($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->situacaoService->deleteSituacao($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
