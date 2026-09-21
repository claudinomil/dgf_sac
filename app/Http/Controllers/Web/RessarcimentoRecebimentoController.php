<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Domain\RessarcimentoRecebimento\RessarcimentoRecebimentoService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class RessarcimentoRecebimentoController extends Controller
{
    public function __construct(
        private RessarcimentoRecebimentoService $ressarcimentoRecebimentoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $ressarcimento_recebimentos = $this->ressarcimentoRecebimentoService->getRessarcimentoRecebimentos(1000);

            // Dados recebidos com sucesso
            if ($ressarcimento_recebimentos) {
                return $this->datatable($ressarcimento_recebimentos);
            } else {
                abort(500, 'Erro Interno RessarcimentoRecebimentos');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('ressarcimento_recebimentos');

            return view('ressarcimento_recebimentos.index');
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $ressarcimento_recebimentos = $this->ressarcimentoRecebimentoService->getRessarcimentoRecebimentosFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($ressarcimento_recebimentos) {
                return $this->datatable($ressarcimento_recebimentos);
            } else {
                abort(500, 'Erro Interno RessarcimentoRecebimentos');
            }
        } else {
            return view('ressarcimento_recebimentos.index');
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
            ->editColumn('valor', function ($row) {
                $retorno = number_format($row['valor'], 2, ",", ".");
                $retorno = '<div class="text-end">'.$retorno.'</div>';

                return $retorno;
            })
            ->editColumn('valor_recebido', function ($row) {
                if ($row['valor_recebido'] === null) {$valor_recebido = 0;} else {$valor_recebido = $row['valor_recebido'];}

                $retorno = number_format($valor_recebido, 2, ",", ".");
                $retorno = '<div class="text-end">'.$retorno.'</div>';

                return $retorno;
            })
            ->editColumn('saldo_restante', function ($row) {
                if ($row['saldo_restante'] === null) {$saldo_restante = 0;} else {$saldo_restante = $row['saldo_restante'];}

                $retorno = number_format($saldo_restante, 2, ",", ".");
                $retorno = '<div class="text-end">'.$retorno.'</div>';

                return $retorno;
            })
            ->escapeColumns([])
            ->make(true);

        return $allData;
    }

    public function update_recebimento(Request $request)
    {
        try {
            $this->ressarcimentoRecebimentoService->updateRecebimento($request->all());

            return response()->json(['success' => 'Registros atualizados com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function dados_modal($referencia)
    {
        $dados_modal = $this->ressarcimentoRecebimentoService->getDadosModal($referencia);

        if (!$dados_modal) {
            return response()->json(['error' => 'Registros não encontrados']);
        }

        return response()->json(['success' => $dados_modal]);
    }

    public function registros_alterar($referencia, $orgao_id)
    {
        $registros_alterar = $this->ressarcimentoRecebimentoService->getRegistrosAlterar($referencia, $orgao_id);

        if (!$registros_alterar) {
            return response()->json(['error' => 'Registros não encontrados']);
        }

        return response()->json(['success' => $registros_alterar]);
    }
}
