<?php

namespace App\Http\Controllers\Web;

use App\Domain\Comportamento\ComportamentoService;
use App\Domain\Graduacao\GraduacaoService;
use App\Domain\Relatorio\RelatorioService;
use App\Domain\Grupo\GrupoService;
use App\Domain\Operacao\OperacaoService;
use App\Domain\Quadro\QuadroService;
use App\Domain\RessarcimentoOrgao\RessarcimentoOrgaoService;
use App\Domain\RessarcimentoReferencia\RessarcimentoReferenciaService;
use App\Domain\Situacao\SituacaoService;
use App\Domain\Submodulo\SubmoduloService;
use App\Domain\Unidade\UnidadeService;
use App\Domain\User\UserService;
use App\Domain\UserSituacao\UserSituacaoService;
use App\Domain\UserTipo\UserTipoService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RelatorioController extends Controller
{
    public function __construct(
        private RelatorioService $relatorioService,
        private UserService $userService,
        private GrupoService $grupoService,
        private UserSituacaoService $userSituacaoService,
        private UserTipoService $userTipoService,
        private SubmoduloService $submoduloService,
        private OperacaoService $operacaoService,
        private RessarcimentoReferenciaService $ressarcimentoReferenciaService,
        private RessarcimentoOrgaoService $ressarcimentoOrgaoService,
        private SituacaoService $situacaoService,
        private GraduacaoService $graduacaoService,
        private UnidadeService $unidadeService,
        private QuadroService $quadroService,
        private ComportamentoService $comportamentoService
    ) {}

    public function index()
    {
        // Definir CRUD Sessions
        setCrudSessions('relatorios');

        $grupos = $this->grupoService->getGrupos(9999);
        $user_situacoes = $this->userSituacaoService->getUserSituacoes();
        $user_tipos = $this->userTipoService->getUserTipos();
        $users = $this->userService->getUsers(999999);
        $submodulos = $this->submoduloService->getSubmodulos();
        $operacoes = $this->operacaoService->getOperacoes(99999);
        $referencias = $this->ressarcimentoReferenciaService->getRessarcimentoReferencias(99999);
        $orgaos = $this->ressarcimentoOrgaoService->getRessarcimentoOrgaos(99999);
        $situacoes = $this->situacaoService->getSituacoes(99999);
        $graduacoes = $this->graduacaoService->getGraduacoes(99999);
        $unidades = $this->unidadeService->getUnidades(99999);
        $quadros = $this->quadroService->getQuadros(99999);
        $comportamentos = $this->comportamentoService->getComportamentos(99999);

        return view('relatorios.index', compact(['grupos', 'user_situacoes', 'user_tipos', 'users', 'submodulos', 'operacoes', 'referencias', 'orgaos', 'situacoes', 'graduacoes', 'unidades', 'quadros', 'comportamentos']));
    }

    public function relatorios_grupo(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            return response()->json(['success' => $this->relatorioService->getRelatoriosGrupo(Auth::user()->grupo_id)]);
        }
    }

    public function relatorio_1(Request $request, int $grupo_id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = $this->relatorioService->getRelatorio1($grupo_id);

            return response()->json(['success' => $retorno]);
        }
    }

    public function relatorio_2(Request $request, int $grupo_id, int $user_situacao_id, int $user_tipo_id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = $this->relatorioService->getRelatorio2($grupo_id, $user_situacao_id, $user_tipo_id);

            return response()->json(['success' => $retorno]);
        }
    }

    public function relatorio_3(Request $request, string $data, int $user_id, int $submodulo_id, int $operacao_id, string $dado)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = $this->relatorioService->getRelatorio3($data, $user_id, $submodulo_id, $operacao_id, $dado);

            return response()->json(['success' => $retorno]);
        }
    }

    public function relatorio_4(Request $request, string $referencia, int $orgao_id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = $this->relatorioService->getRelatorio4($referencia, $orgao_id);

            return response()->json(['success' => $retorno]);
        }
    }

    public function relatorio_5(Request $request, string $referencia, int $orgao_id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = $this->relatorioService->getRelatorio5($referencia, $orgao_id);

            return response()->json(['success' => $retorno]);
        }
    }

    public function relatorio_6(Request $request, string $referencia, int $orgao_id, float $saldo)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = $this->relatorioService->getRelatorio6($referencia, $orgao_id, $saldo);

            return response()->json(['success' => $retorno]);
        }
    }

    public function relatorio_7(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = $this->relatorioService->getRelatorio7();

            return response()->json(['success' => $retorno]);
        }
    }

    public function relatorio_8(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = $this->relatorioService->getRelatorio8();

            return response()->json(['success' => $retorno]);
        }
    }

    public function relatorio_9(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = $this->relatorioService->getRelatorio9();

            return response()->json(['success' => $retorno]);
        }
    }

    public function relatorio_10(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = $this->relatorioService->getRelatorio10();

            return response()->json(['success' => $retorno]);
        }
    }

    public function relatorio_11(Request $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $retorno = $this->relatorioService->getRelatorio11();

            return response()->json(['success' => $retorno]);
        }
    }

    public function relatorio_12(Request $request, string $situacoes, string $graduacoes, string $unidades, string $quadros, string $comportamentos)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            ini_set('memory_limit', '1024M');
            
            $retorno = $this->relatorioService->getRelatorio12($request, $situacoes, $graduacoes, $unidades, $quadros, $comportamentos);

            return response()->json(['success' => $retorno]);
        }
    }
}
