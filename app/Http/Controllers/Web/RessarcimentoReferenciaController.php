<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Domain\RessarcimentoReferencia\RessarcimentoReferenciaService;
use App\Http\Requests\RessarcimentoReferenciaDeleteRequest;
use App\Http\Requests\RessarcimentoReferenciaStoreRequest;
use App\Http\Requests\RessarcimentoReferenciaUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class RessarcimentoReferenciaController extends Controller
{
    public function __construct(
        private RessarcimentoReferenciaService $ressarcimentoReferenciaService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $ressarcimento_referencias = $this->ressarcimentoReferenciaService->getRessarcimentoReferencias(1000);

            // Dados recebidos com sucesso
            if ($ressarcimento_referencias) {
                return $this->datatable($ressarcimento_referencias);
            } else {
                abort(500, 'Erro Interno RessarcimentoReferencias');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('ressarcimento_referencias');

            return view('ressarcimento_referencias.index');
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $ressarcimento_referencias = $this->ressarcimentoReferenciaService->getRessarcimentoReferenciasFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($ressarcimento_referencias) {
                return $this->datatable($ressarcimento_referencias);
            } else {
                abort(500, 'Erro Interno RessarcimentoReferencias');
            }
        } else {
            return view('ressarcimento_referencias.index');
        }
    }

    public function datatable($registros)
    {
        $allData = DataTables::of($registros)
            ->addIndexColumn()
            ->editColumn('referencia', function ($row) {
                $retorno = '<div class="text-nowrap">'.getReferencia(1, $row['referencia']).'</div>';

                return $retorno;
            })
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

    public function show(Request $request, $id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $ressarcimento_referencia = $this->ressarcimentoReferenciaService->getRessarcimentoReferencia($id);

            if (!$ressarcimento_referencia) {
                return response()->json(['error' => 'Registro não encontrado']);
            }

            return response()->json(['success' => $ressarcimento_referencia]);
        }
    }

    public function store(RessarcimentoReferenciaStoreRequest $request)
    {
        $this->ressarcimentoReferenciaService->createRessarcimentoReferencia($request->all());

        return response()->json(['success' => 'Registro criado com sucesso']);
    }

    public function edit(Request $request, $id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            try {
                $ressarcimento_referencia = $this->ressarcimentoReferenciaService->editRessarcimentoReferencia($id);

                if (!$ressarcimento_referencia) {
                    return response()->json(['error' => 'Registro não encontrado'], 404);
                }

                return response()->json(['success' => $ressarcimento_referencia]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(RessarcimentoReferenciaUpdateRequest $request, $id)
    {
        try {
            $this->ressarcimentoReferenciaService->updateRessarcimentoReferencia($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(RessarcimentoReferenciaDeleteRequest $request, $id)
    {
        try {
            $this->ressarcimentoReferenciaService->deleteRessarcimentoReferencia($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
