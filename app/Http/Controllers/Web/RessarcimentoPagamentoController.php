<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Domain\RessarcimentoPagamento\RessarcimentoPagamentoService;
use App\Domain\RessarcimentoReferencia\RessarcimentoReferenciaService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class RessarcimentoPagamentoController extends Controller
{
    public function __construct(
        private RessarcimentoPagamentoService $ressarcimentoPagamentoService,
        private RessarcimentoReferenciaService $ressarcimentoReferenciaService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $ressarcimento_pagamentos = $this->ressarcimentoPagamentoService->getRessarcimentoPagamentos(1000);

            // Dados recebidos com sucesso
            if ($ressarcimento_pagamentos) {
                return $this->datatable($ressarcimento_pagamentos);
            } else {
                abort(500, 'Erro Interno RessarcimentoPagamentos');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('ressarcimento_pagamentos');

            $referencias = $this->ressarcimentoReferenciaService->getReferenciasAtivas();

            return view('ressarcimento_pagamentos.index', compact(['referencias']));
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $ressarcimento_pagamentos = $this->ressarcimentoPagamentoService->getRessarcimentoPagamentosFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($ressarcimento_pagamentos) {
                return $this->datatable($ressarcimento_pagamentos);
            } else {
                abort(500, 'Erro Interno RessarcimentoPagamentos');
            }
        } else {
            return view('ressarcimento_pagamentos.index');
        }
    }

    public function datatable($registros)
    {
        $allData = DataTables::of($registros)
            ->addIndexColumn()
            ->editColumn('referencia', function ($row) {
                $retorno = '<div class="text-nowrap">' . getReferencia(1, $row['referencia']) . '</div>';

                return $retorno;
            })
            ->editColumn('militar', function ($row) {
                $retorno = '<div class="col-12 text-nowrap">' . $row['nome'] . '</div>';
                $retorno .= '<div class="col-12">' . $row['posto_graduacao'] . '</div>';
                $retorno .= '<div class="col-12">' . $row['identidade_funcional'] . ' ## ' . $row['rg'] . '</div>';

                return $retorno;
            })
            ->editColumn('valores', function ($row) {
                $retorno = '<div class="col-12 text-nowrap pb-1"><span class="text-black">(+) Bruto: </span>R$ ' . $row['bruto'] . '</div>';
                $retorno .= '<div class="col-12 text-nowrap pb-1"><span class="text-danger">(-) Desconto: </span>R$ ' . $row['desconto'] . '</div>';
                $retorno .= '<div class="col-12 text-nowrap"><span class="text-success">(=) Líquido: </span>R$ ' . $row['liquido'] . '</div>';

                return $retorno;
            })
            ->addColumn('action', function ($row, Request $request) {
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
            $ressarcimento_pagamento = $this->ressarcimentoPagamentoService->getRessarcimentoPagamento($id);

            if (!$ressarcimento_pagamento) {
                return response()->json(['error' => 'Registro não encontrado']);
            }

            return response()->json(['success' => $ressarcimento_pagamento]);
        }
    }

    public function store(Request $request)
    {
        $this->ressarcimentoPagamentoService->createRessarcimentoPagamento($request->all());

        return response()->json(['success' => 'Registro criado com sucesso']);
    }

    public function edit(Request $request, $id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            try {
                $ressarcimento_pagamento = $this->ressarcimentoPagamentoService->editRessarcimentoPagamento($id);

                if (!$ressarcimento_pagamento) {
                    return response()->json(['error' => 'Registro não encontrado'], 404);
                }

                return response()->json(['success' => $ressarcimento_pagamento]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->ressarcimentoPagamentoService->updateRessarcimentoPagamento($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(Request $request, int $id)
    {
        try {
            $this->ressarcimentoPagamentoService->deleteRessarcimentoPagamento($id, $request['referencia']);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // Importar Pagamentos - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    // Importar Pagamentos - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    public function importar(Request $request)
    {
        try {
            $resultado = $this->ressarcimentoPagamentoService->importar($request);

            return response()->json(['success' => $resultado]);
} catch (\Throwable $e) {
    return response()->json([
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
    ], 400);
}
        // } catch (\Exception $e) {
        //     return response()->json(['error' => config('app.debug') ? $e->getMessage() : 'Erro interno.'], 400);
        // }
    }
    // Importar Pagamentos - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    // Importar Pagamentos - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}
