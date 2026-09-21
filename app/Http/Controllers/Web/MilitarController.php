<?php

namespace App\Http\Controllers\Web;

use App\Domain\Banco\BancoService;
use App\Http\Controllers\Controller;
use App\Domain\Militar\MilitarService;
use App\Domain\Situacao\SituacaoService;
use App\Domain\Graduacao\GraduacaoService;
use App\Domain\PrestandoServico\PrestandoServicoService;
use App\Domain\Quadro\QuadroService;
use App\Domain\Unidade\UnidadeService;
use App\Domain\EstadoCivil\EstadoCivilService;
use App\Domain\Comportamento\ComportamentoService;
use App\Domain\SexoBiologico\SexoBiologicoService;
use App\Domain\TipoSanguineo\TipoSanguineoService;
use App\Domain\FatorRh\FatorRhService;
use App\Domain\Nacionalidade\NacionalidadeService;
use App\Domain\Naturalidade\NaturalidadeService;
use App\Domain\Funcao\FuncaoService;
use App\Domain\Genero\GeneroService;
use App\Domain\Escolaridade\EscolaridadeService;
use App\Http\Requests\MilitarFotografiaUpdateRequest;
use App\Http\Requests\MilitarStoreRequest;
use App\Http\Requests\MilitarUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class MilitarController extends Controller
{
    public function __construct(
        private MilitarService $militarService,
        private SituacaoService $situacaoService,
        private QuadroService $quadroService,
        private GraduacaoService $graduacaoService,
        private UnidadeService $unidadeService,
        private PrestandoServicoService $prestandoServicoService,
        private EstadoCivilService $estadoCivilService,
        private ComportamentoService $comportamentoService,
        private SexoBiologicoService $sexoBiologicoService,
        private TipoSanguineoService $tipoSanguineoService,
        private FatorRhService $fatorRhService,
        private NacionalidadeService $nacionalidadeService,
        private NaturalidadeService $naturalidadeService,
        private BancoService $bancoService,
        private FuncaoService $funcaoService,
        private GeneroService $generoService,
        private EscolaridadeService $escolaridadeService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $militares = $this->militarService->getMilitares(1000);

            // Dados recebidos com sucesso
            if ($militares) {
                return $this->datatable($militares);
            } else {
                abort(500, 'Erro Interno Militar');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('militares');

            $situacoes = $this->situacaoService->getAll();
            $quadros = $this->quadroService->getAll();
            $graduacoes = $this->graduacaoService->getAll();
            $unidades = $this->unidadeService->getAll();
            $prestando_servicos = $this->prestandoServicoService->getAll();
            $estados_civis = $this->estadoCivilService->getAll();
            $comportamentos = $this->comportamentoService->getAll();
            $sexos_biologicos = $this->sexoBiologicoService->getAll();
            $tipos_sanguineos = $this->tipoSanguineoService->getAll();
            $fatores_rh = $this->fatorRhService->getAll();
            $nacionalidades = $this->nacionalidadeService->getAll();
            $naturalidades = $this->naturalidadeService->getAll();
            $bancos = $this->bancoService->getAll();
            $funcoes = $this->funcaoService->getAll();
            $generos = $this->generoService->getAll();
            $escolaridades = $this->escolaridadeService->getAll();

            return view('militares.index', compact([
                                            'situacoes',
                                            'quadros',
                                            'graduacoes',
                                            'unidades',
                                            'prestando_servicos',
                                            'estados_civis',
                                            'comportamentos',
                                            'sexos_biologicos',
                                            'tipos_sanguineos',
                                            'fatores_rh',
                                            'nacionalidades',
                                            'naturalidades',
                                            'bancos',
                                            'funcoes',
                                            'generos',
                                            'escolaridades'
                                            ]));
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $militares = $this->militarService->getMilitaresFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($militares) {
                return $this->datatable($militares);
            } else {
                abort(500, 'Erro Interno Militar');
            }
        } else {
            return view('militares.index');
        }
    }

    public function datatable($registros)
    {
        $allData = DataTables::of($registros)
            ->addIndexColumn()
            ->editColumn('fotografia', function ($row) {
                $permissaoShow = temPermissaoSituacao('militares', 'show', $row['militarSituacaoId']);

                $retorno = "<div class='text-center'>";
                $retorno .= "<img src='" . asset($row['fotografia']) . "' alt='' class='img-thumbnail rounded-circle avatar-sm' id='militarImgFotografia-".$row['id']."'>";

                if ($permissaoShow) {
                    $retorno .= "<br>";
                    $retorno .= "<button type='button' class='btn btn-sm text-secondary' data-bs-toggle='tooltip' data-bs-placement='top' title='Visualizar Informações' onclick='crudOffCanvaInformacoesMilitar(" . $row['id'] . ");'><i class='fas fa-info-circle font-size-20'></i></button>";
                }

                $retorno .= "</div>";

                return $retorno;
            })
            ->editColumn('militar', function ($row) {
                $retorno = '<div class="text-nowrap">
                                <div class="col-12">'.$row["nome"].'</div>
                                <div class="col-12 mt-2"><b>RG</b> : '.$row["rg"].'</div>
                                <div class="col-12"><b>Situação</b> : '.$row["situacaoName"].'</div>
                                <div class="col-12"><b>Posto/Graduação</b> : '.$row["graduacaoName"].'</div>
                                <div class="col-12"><b>Quadro</b> : '.$row["quadroName"].' - '.$row['quadroEspecialidadeName'].'</div>
                            </div>';

                return $retorno;
            })
            ->editColumn('unidade', function ($row) {
                $retorno = '<div class="col-12">'.$row["unidadeName"].'</div>
                            <div class="col-12 text-primary mt-2">'.$row["prestandoServicoName"].'</div>';

                return $retorno;
            })
            ->addColumn('action', function ($row) {
                $permissaoShow = temPermissaoSituacao('militares', 'show', $row['militarSituacaoId']);
                $permissaoEdit = temPermissaoSituacao('militares', 'edit', $row['militarSituacaoId']);
                $permissaoDestroy = temPermissaoSituacao('militares', 'destroy', $row['militarSituacaoId']);

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
                $militar = $this->militarService->getMilitar($id);

                if (!$militar) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $militar->toArray();

                $dados['data_ingresso'] = $militar->data_ingresso ? $militar->data_ingresso->format('d/m/Y') : '';
                $dados['data_segunda_praca'] = $militar->data_segunda_praca ? $militar->data_segunda_praca->format('d/m/Y') : '';
                $dados['data_nascimento'] = $militar->data_nascimento ? $militar->data_nascimento->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(MilitarStoreRequest $request)
    {
        try {
            // Create
            $this->militarService->createMilitar($request->all());

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
                $militar = $this->militarService->editMilitar($id);

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $militar->toArray();

                $dados['data_ingresso'] = $militar->data_ingresso ? $militar->data_ingresso->format('d/m/Y') : '';
                $dados['data_segunda_praca'] = $militar->data_segunda_praca ? $militar->data_segunda_praca->format('d/m/Y') : '';
                $dados['data_nascimento'] = $militar->data_nascimento ? $militar->data_nascimento->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(MilitarUpdateRequest $request, int $id)
    {
        try {
            // Update
            $this->militarService->updateMilitar($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->militarService->deleteMilitar($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function informacoes_geral(Request $request, int $militar_id)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            try {
                // Buscar
                $informacoes_geral = $this->militarService->getInformacoesGeral($militar_id);

                return response()->json(['success' => $informacoes_geral]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function updateFotografia(MilitarFotografiaUpdateRequest $request)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $militar_id = $request['informacoes_militar_id'];

            $retorno = $this->militarService->updateFotografia($militar_id, $request);

            return response()->json(['success' => 'Fotografia atualizada', 'fotografia_url' => $retorno]);
        }
    }

    public function autocompleteMilitar(Request $request, string $submodulo, string $acao)
    {
        // Verificando Origem enviada pelo Fetch
        if ($request->header('request-origin') == 'fetch') {
            $registros = $this->militarService->getAutocompleteMilitar($request->pesquisa, $submodulo, $acao);

            return response()->json($registros);
        }
    }
}
