<?php

namespace App\Http\Controllers\Web;

use App\Domain\Esfera\EsferaService;
use App\Domain\RessarcimentoFuncao\RessarcimentoFuncaoService;
use App\Domain\Poder\PoderService;
use App\Http\Controllers\Controller;
use App\Domain\RessarcimentoConfiguracao\RessarcimentoConfiguracaoService;
use App\Domain\Tratamento\TratamentoService;
use App\Domain\Vocativo\VocativoService;
use App\Http\Requests\RessarcimentoConfiguracaoUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class RessarcimentoConfiguracaoController extends Controller
{
    public function __construct(
        private RessarcimentoConfiguracaoService $ressarcimentoConfiguracaoService,
        private EsferaService $esferaService,
        private PoderService $poderService,
        private TratamentoService $tratamentoService,
        private VocativoService $vocativoService,
        private RessarcimentoFuncaoService $ressarcimentoFuncaoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $ressarcimento_configuracoes = $this->ressarcimentoConfiguracaoService->getRessarcimentoConfiguracoes(1000);

            // Dados recebidos com sucesso
            if ($ressarcimento_configuracoes) {
                return $this->datatable($ressarcimento_configuracoes);
            } else {
                abort(500, 'Erro Interno RessarcimentoConfiguracoes');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('ressarcimento_configuracoes');

            $esferas = $this->esferaService->getEsferas();
            $poderes = $this->poderService->getPoderes();
            $tratamentos = $this->tratamentoService->getTratamentos();
            $vocativos = $this->vocativoService->getVocativos();
            $ressarcimento_funcoes = $this->ressarcimentoFuncaoService->getRessarcimentoFuncoes();

            return view('ressarcimento_configuracoes.index', compact(['esferas', 'poderes', 'tratamentos', 'vocativos', 'ressarcimento_funcoes']));
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $ressarcimento_configuracoes = $this->ressarcimentoConfiguracaoService->getRessarcimentoConfiguracoesFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($ressarcimento_configuracoes) {
                return $this->datatable($ressarcimento_configuracoes);
            } else {
                abort(500, 'Erro Interno RessarcimentoConfiguracoes');
            }
        } else {
            return view('ressarcimento_configuracoes.index');
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
            ->editColumn('diretor_geral_financas', function ($row) {
                $retorno = '<div class="col-12 text-nowrap">'.$row['diretor_nome'].'</div>';
                $retorno .= '<div class="col-12 font-size-11 text-primary">'.$row['diretor_posto'].'</div>';
                $retorno .= '<div class="col-12 font-size-11 text-success">'.'ID: '.$row['diretor_identidade_funcional'].'</div>';
                $retorno .= '<div class="col-12 font-size-11 text-success">'.'RG: '.$row['diretor_rg'].'</div>';

                return $retorno;
            })
            ->editColumn('chefe_dgf2', function ($row) {
                $retorno = '<div class="col-12 text-nowrap">'.$row['dgf2_nome'].'</div>';
                $retorno .= '<div class="col-12 font-size-11 text-primary">'.$row['dgf2_posto'].'</div>';
                $retorno .= '<div class="col-12 font-size-11 text-success">'.'ID: '.$row['dgf2_identidade_funcional'].'</div>';
                $retorno .= '<div class="col-12 font-size-11 text-success">'.'RG: '.$row['dgf2_rg'].'</div>';

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

    public function show(Request $request, $id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $ressarcimento_configuracao = $this->ressarcimentoConfiguracaoService->getRessarcimentoConfiguracao($id);

            if (!$ressarcimento_configuracao) {
                return response()->json(['error' => 'Registro não encontrado']);
            }

            return response()->json(['success' => $ressarcimento_configuracao]);
        }
    }

    public function store(Request $request)
    {
        $this->ressarcimentoConfiguracaoService->createRessarcimentoConfiguracao($request->all());

        return response()->json(['success' => 'Registro criado com sucesso']);
    }

    public function edit(Request $request, $id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            try {
                $ressarcimento_configuracao = $this->ressarcimentoConfiguracaoService->editRessarcimentoConfiguracao($id);

                if (!$ressarcimento_configuracao) {
                    return response()->json(['error' => 'Registro não encontrado'], 404);
                }

                return response()->json(['success' => $ressarcimento_configuracao]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(RessarcimentoConfiguracaoUpdateRequest $request, $id)
    {
        try {
            $this->ressarcimentoConfiguracaoService->updateRessarcimentoConfiguracao($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
