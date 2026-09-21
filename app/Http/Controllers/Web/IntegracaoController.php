<?php

namespace App\Http\Controllers\Web;

use App\Domain\Integracao\IntegracaoService;
use App\Domain\Webservice\WebserviceService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IntegracaoController extends Controller
{
    public function __construct(
        private IntegracaoService $integracaoService,
        private WebserviceService $webserviceService
    ) {}

    public function index()
    {
        return view('integracoes.index');
    }

    // Importações SAC antigo (impsac) - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    public function impsac_quantidades_bancos(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            try {
                $retorno = array();

                $retorno['totais_banco_1'] = $this->webserviceService->getTotais();
                $retorno['totais_banco_2'] = $this->integracaoService->impsacTotais();

                if (!$retorno) {return response()->json(['error' => 'Dados não encontrado']);}

                return response()->json(['success' => $retorno]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        }
    }

    public function impsac_atualizar_dados(Request $request, string $tabela)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            try {
                $this->integracaoService->impsacAtualizarDados($tabela);

                return response()->json(['success' => true]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        }
    }
    // Importações SAC antigo (impsac) - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}
