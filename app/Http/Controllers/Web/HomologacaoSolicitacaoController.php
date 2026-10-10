<?php

namespace App\Http\Controllers\Web;

use App\Domain\HomologacaoSolicitacao\HomologacaoSolicitacaoService;
use App\Domain\Submodulo\SubmoduloService;
use App\Domain\User\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\HomologacaoSolicitacaoStoreRequest;
use App\Http\Requests\HomologacaoSolicitacaoUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class HomologacaoSolicitacaoController extends Controller
{
    public function __construct(
        private HomologacaoSolicitacaoService $homologacaoSolicitacoesService,
        private SubmoduloService $submoduloService,
        private UserService $userService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $homologacao_solicitacoes = $this->homologacaoSolicitacoesService->getHomologacaoSolicitacoes(1000);

            // Dados recebidos com sucesso
            if ($homologacao_solicitacoes) {
                return $this->datatable($homologacao_solicitacoes);
            } else {
                abort(500, 'Erro Interno Homologação Solicitação');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('homologacao_solicitacoes');

            $submodulos = $this->submoduloService->getSubmodulos();
            $users = $this->userService->getUsers(1000);

            return view('homologacao_solicitacoes.index', compact(['submodulos', 'users']));
        }
    }

    public function filter(Request $request, string $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $homologacao_solicitacoes = $this->homologacaoSolicitacoesService->getHomologacaoSolicitacoesFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($homologacao_solicitacoes) {
                return $this->datatable($homologacao_solicitacoes);
            } else {
                abort(500, 'Erro Interno Homologação Solicitação');
            }
        } else {
            return view('homologacao_solicitacoes.index');
        }
    }

    public function datatable($registros)
    {
        $allData = DataTables::of($registros)
            ->addIndexColumn()
            ->editColumn('solicitacao', function ($row) {
                $retorno = '<div class="row py-3">
                                <div class="col-12">
                                    <table class="table table-bordered mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Tipo</th>
                                                <th>Prioridade</th>
                                                <th>Data</th>
                                                <th>Hora</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>' . $row["solicitacao_tipo"] . '</th>
                                                <td>' . $row["solicitacao_prioridade"] . '</td>
                                                <td>' . getDataFormatada(1, $row["solicitacao_data"]) . '</td>
                                                <td>' . $row["solicitacao_hora"] . '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 mt-3" style="text-align: justify;"><b>Solicitação: </b>' . $row["solicitacao"] . '</div>
                            </div>';

                return $retorno;
            })
            ->editColumn('resposta', function ($row) {
                $retorno = '<div class="row py-3">
                                <div class="col-12">
                                    <table class="table table-bordered mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Status</th>
                                                <th>Data</th>
                                                <th>Hora</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>' . $row["resposta_status"] . '</th>
                                                <td>' . getDataFormatada(1, $row["resposta_data"]) . '</td>
                                                <td>' . $row["resposta_hora"] . '</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 mt-3" style="text-align: justify;"><b>Resposta: </b>' . $row["resposta"] . '</div>
                            </div>';

                return $retorno;
            })
            ->addColumn('action', function ($row) {
                // Verificar se Usuário é Claudino ou outros
                if (session('userContext.user.id') == 1) {
                    $botoes = 7;
                } else {
                    $botoes = 1;
                }

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
                $homologacao_solicitacao = $this->homologacaoSolicitacoesService->getHomologacaoSolicitacao($id);

                if (!$homologacao_solicitacao) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $homologacao_solicitacao->toArray();

                $dados['solicitacao_data'] = $homologacao_solicitacao->solicitacao_data ? $homologacao_solicitacao->solicitacao_data->format('d/m/Y') : '';
                $dados['resposta_data'] = $homologacao_solicitacao->resposta_data ? $homologacao_solicitacao->resposta_data->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(HomologacaoSolicitacaoStoreRequest $request)
    {
        try {
            // Create
            $this->homologacaoSolicitacoesService->createHomologacaoSolicitacao($request->all());

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
                $homologacao_solicitacao = $this->homologacaoSolicitacoesService->editHomologacaoSolicitacao($id);

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $homologacao_solicitacao->toArray();

                $dados['solicitacao_data'] = $homologacao_solicitacao->solicitacao_data ? $homologacao_solicitacao->solicitacao_data->format('d/m/Y') : '';
                $dados['resposta_data'] = $homologacao_solicitacao->resposta_data ? $homologacao_solicitacao->resposta_data->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(HomologacaoSolicitacaoUpdateRequest $request, int $id)
    {
        try {
            $this->homologacaoSolicitacoesService->updateHomologacaoSolicitacao($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->homologacaoSolicitacoesService->deleteHomologacaoSolicitacao($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
