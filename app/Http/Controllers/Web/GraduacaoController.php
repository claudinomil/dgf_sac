<?php

namespace App\Http\Controllers\Web;

use App\Domain\Graduacao\GraduacaoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\GraduacaoStoreRequest;
use App\Http\Requests\GraduacaoUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class GraduacaoController extends Controller
{
    public function __construct(
        private GraduacaoService $graduacaoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $graduacoes = $this->graduacaoService->getGraduacoes(1000);

            // Dados recebidos com sucesso
            if ($graduacoes) {
                return $this->datatable($graduacoes);
            } else {
                abort(500, 'Erro Interno Graduação');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('graduacoes');

            return view('graduacoes.index');
        }
    }

    public function filter(Request $request, string $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $graduacoes = $this->graduacaoService->getGraduacoesFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($graduacoes) {
                return $this->datatable($graduacoes);
            } else {
                abort(500, 'Erro Interno Graduação');
            }
        } else {
            return view('graduacoes.index');
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
                $graduacao = $this->graduacaoService->getGraduacao($id);

                if (!$graduacao) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                return response()->json(['success' => $graduacao]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(GraduacaoStoreRequest $request)
    {
        try {
            // Create
            $this->graduacaoService->createGraduacao($request->all());

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
                $graduacao = $this->graduacaoService->editGraduacao($id);

                return response()->json(['success' => $graduacao]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(GraduacaoUpdateRequest $request, int $id)
    {
        try {
            $this->graduacaoService->updateGraduacao($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->graduacaoService->deleteGraduacao($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
