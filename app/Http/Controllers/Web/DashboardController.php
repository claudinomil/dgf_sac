<?php

namespace App\Http\Controllers\Web;

use App\Domain\Dashboard\DashboardService;
use App\Domain\Grupo\GrupoService;
use App\Domain\Militar\MilitarService;
use App\Domain\RessarcimentoOrgao\RessarcimentoOrgaoService;
use App\Domain\RessarcimentoReferencia\RessarcimentoReferenciaService;
use App\Domain\Transacao\TransacaoService;
use App\Domain\User\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService,
        private UserService $userService,
        private GrupoService $grupoService,
        private TransacaoService $transacaoService,
        private MilitarService $militarService,
        private RessarcimentoReferenciaService $ressarcimentoReferenciaService,
        private RessarcimentoOrgaoService $ressarcimentoOrgaoService
    ) {}

    public function index()
    {
        // Definir CRUD Sessions
        setCrudSessions('dashboards');

        $ressarcimento_referencias = $this->ressarcimentoReferenciaService->getRessarcimentoReferencias(500);
        $ressarcimento_orgaos = $this->ressarcimentoOrgaoService->getRessarcimentoOrgaos();

        return view('dashboards.index', compact(['ressarcimento_referencias', 'ressarcimento_orgaos']));
    }

    public function permissoes_graficos(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            return response()->json(['success' => $this->dashboardService->getPermissoesGraficos(Auth::user()->grupo_id)]);
        }
    }

    public function sistema_totais(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['usuarios_total_geral'] = $this->userService->getTotais(1);
            $retorno['usuarios_total_liberados'] = $this->userService->getTotais(2);
            $retorno['usuarios_total_bloqueados'] = $this->userService->getTotais(3);
            $retorno['usuarios_total_militares'] = $this->userService->getTotais(4);
            $retorno['usuarios_total_civis'] = $this->userService->getTotais(5);
            $retorno['grupos_total_geral'] = $this->grupoService->getTotais(1);
            $retorno['transacoes_total_geral'] = $this->transacaoService->getTotais(1);

            return response()->json(['success' => $retorno]);
        }
    }

    public function grafico_1(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['usuarios_quantidade'] = $this->userService->getTotais(1);
            $retorno['usuarios_grupos'] = $this->dashboardService->getGrafico1();

            return response()->json($retorno);
        }
    }

    public function grafico_2(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['transacoes_quantidade'] = $this->transacaoService->getTotais(1);
            $retorno['transacoes_operacoes'] = $this->dashboardService->getGrafico2();

            return response()->json($retorno);
        }
    }

    public function grafico_3(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['transacoes_quantidade'] = $this->transacaoService->getTotais(1);
            $retorno['transacoes_submodulos'] = $this->dashboardService->getGrafico3();

            return response()->json($retorno);
        }
    }

    public function efetivo_totais(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['militares_total_ativos'] = $this->militarService->getTotais(2);
            $retorno['militares_total_oficiais_ativos'] = $this->militarService->getTotais(3);
            $retorno['militares_total_aspirantes'] = $this->militarService->getTotais(4);
            $retorno['militares_total_alunos_cfo'] = $this->militarService->getTotais(5);
            $retorno['militares_total_pracas_ativos'] = $this->militarService->getTotais(6);

            return response()->json(['success' => $retorno]);
        }
    }

    public function grafico_4(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['militares_quantidade'] = $this->militarService->getTotais(2);
            $retorno['militares_situacoes'] = $this->dashboardService->getGrafico4();

            return response()->json($retorno);
        }
    }

    public function grafico_5(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $militares_selecionados = $request->militares_selecionados;
            $quadros_selecionados = explode(',', $request->quadros_selecionados);

            $retorno['militares_quantidade'] = $this->militarService->getTotais($militares_selecionados);
            $retorno['militares_quadros'] = $this->dashboardService->getGrafico5($militares_selecionados, $quadros_selecionados);

            return response()->json($retorno);
        }
    }

    public function grafico_6(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $militares_selecionados = $request->militares_selecionados;
            $graduacoes_selecionadas = explode(',', $request->graduacoes_selecionadas);

            $retorno['militares_quantidade'] = $this->militarService->getTotais($militares_selecionados);
            $retorno['militares_graduacoes'] = $this->dashboardService->getGrafico6($militares_selecionados, $graduacoes_selecionadas);

            return response()->json($retorno);
        }
    }

    public function grafico_7(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['militares_quantidade'] = $this->militarService->getTotais(2);
            $retorno['militares_comportamentos'] = $this->dashboardService->getGrafico7();

            return response()->json($retorno);
        }
    }

    public function ressarcimento_totais(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['ressarcimento_total'] = $this->militarService->getTotais(2);
            $retorno['orgaos_total'] = $this->militarService->getTotais(3);
            $retorno['militares_total'] = $this->militarService->getTotais(4);

            return response()->json(['success' => $retorno]);
        }
    }

    public function grafico_8(Request $request, string $periodo_1, string $periodo_2, int $orgao_id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['xxx'] = $this->dashboardService->getGrafico8($periodo_1, $periodo_2, $orgao_id);

            return response()->json($retorno);
        }
    }

    public function grafico_9(Request $request, string $periodo_1, string $periodo_2, int $orgao_id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['militares_quantidade'] = $this->militarService->getTotais(2);
            $retorno['militares_situacoes'] = $this->dashboardService->getGrafico4();

            return response()->json($retorno);
        }
    }

    public function grafico_10(Request $request, string $periodo_1, string $periodo_2, int $orgao_id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['militares_quantidade'] = $this->militarService->getTotais(2);
            $retorno['militares_situacoes'] = $this->dashboardService->getGrafico4();

            return response()->json($retorno);
        }
    }

    public function grafico_11(Request $request, string $periodo_1, string $periodo_2, int $orgao_id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['militares_quantidade'] = $this->militarService->getTotais(2);
            $retorno['militares_situacoes'] = $this->dashboardService->getGrafico4();

            return response()->json($retorno);
        }
    }

    public function grafico_12(Request $request, string $periodo_1, string $periodo_2, int $orgao_id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['militares_quantidade'] = $this->militarService->getTotais(2);
            $retorno['militares_situacoes'] = $this->dashboardService->getGrafico4();

            return response()->json($retorno);
        }
    }

    public function balancetes_totais(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['militares_quantidade'] = $this->militarService->getTotais(2);
            $retorno['militares_situacoes'] = $this->dashboardService->getGrafico4();

            return response()->json(['success' => $retorno]);
        }
    }

    public function grafico_13(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['militares_quantidade'] = $this->militarService->getTotais(2);
            $retorno['militares_situacoes'] = $this->dashboardService->getGrafico4();

            return response()->json($retorno);
        }
    }

    public function grafico_14(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['militares_quantidade'] = $this->militarService->getTotais(2);
            $retorno['militares_situacoes'] = $this->dashboardService->getGrafico4();

            return response()->json($retorno);
        }
    }

    public function grafico_15(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['militares_quantidade'] = $this->militarService->getTotais(2);
            $retorno['militares_situacoes'] = $this->dashboardService->getGrafico4();

            return response()->json($retorno);
        }
    }

    public function grafico_16(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['militares_quantidade'] = $this->militarService->getTotais(2);
            $retorno['militares_situacoes'] = $this->dashboardService->getGrafico4();

            return response()->json($retorno);
        }
    }

    public function grafico_17(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = array();

            $retorno['militares_quantidade'] = $this->militarService->getTotais(2);
            $retorno['militares_situacoes'] = $this->dashboardService->getGrafico4();

            return response()->json($retorno);
        }
    }
}
