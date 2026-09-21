<?php

namespace App\Http\Controllers\Web;

use App\Domain\MilitarFundoSaude\MilitarFundoSaudeService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MilitarFundoSaudeStoreRequest;
use App\Http\Requests\MilitarFundoSaudeUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class MilitarFundoSaudeController extends Controller
{
    public function __construct(
        private MilitarFundoSaudeService $militarFundoSaudeService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $militares_fundos_saude = $this->militarFundoSaudeService->getMilitaresFundosSaude(1000);

            // Dados recebidos com sucesso
            if ($militares_fundos_saude) {
                return $this->datatable($militares_fundos_saude);
            } else {
                abort(500, 'Erro Interno Militar FundoSaude');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('militares_fundos_saude');

            return view('militares_fundos_saude.index', compact([]));
        }
    }

    public function filter(Request $request, string $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $militares_fundos_saude = $this->militarFundoSaudeService->getMilitaresFundosSaudeFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($militares_fundos_saude) {
                return $this->datatable($militares_fundos_saude);
            } else {
                abort(500, 'Erro Interno Militares FundoSaude');
            }
        } else {
            return view('militares_fundos_saude.index');
        }
    }

    public function datatable($registros)
    {
        $allData = DataTables::of($registros)
            ->addIndexColumn()
            ->editColumn('militar', function ($row) {
                $retorno = '<div class="text-nowrap">
                                <div class="col-12">' . $row["militarNome"] . '</div>
                                <div class="col-12 mt-2"><b>RG</b> : ' . $row["militarRg"] . '</div>
                                <div class="col-12"><b>Situação</b> : ' . $row["militarSituacaoName"] . '</div>
                                <div class="col-12"><b>Posto/Graduação</b> : ' . $row["militarGraduacaoName"] . '</div>
                                <div class="col-12"><b>Quadro</b> : ' . $row["militarQuadroName"] . ' - ' . $row['militarQuadroEspecialidadeName'] . '</div>
                            </div>';

                return $retorno;
            })
            ->editColumn('fundo_saude', function ($row) {
                $cancelarDesconto = $row['cancelar_desconto'] == 1 ? 'SIM' : 'NÃO';
                $acessoSistemaSaude = $row['acesso_sistema_saude'] == 1 ? 'SIM' : 'NÃO';

                $tipoAcesso = match ((int) $row['tipo_acesso']) {1 => 'INTEGRAL', 2 => 'AMBULATORIAL', default => 'NEGADO'};

                $retorno = '<div class="col-12"><b>Cancelar Desconto</b> : ' . $cancelarDesconto . '</div>
                            <div class="col-12"><b>Acesso Sistema Saúde</b> : ' . $acessoSistemaSaude . '</div>';

                if (!empty($row['acesso_sistema_saude_documento'])) {
                    $retorno .= '<div class="col-12"><b>Acesso Sistema Saúde Documento</b> : ' . $row['acesso_sistema_saude_documento'] . '</div>';
                }

                if (!empty($row['data_documento'])) {
                    $retorno .= '<div class="col-12"><b>Data Documento</b> : ' . getDataFormatada(1, $row['data_documento']) . '</div>';
                }

                $retorno .= '<div class="col-12"><b>Tipo Acesso</b> : ' . $tipoAcesso . '</div>';

                if (!empty($row['tipo_acesso_motivo'])) {
                    $retorno .= '<div class="col-12"><b>Tipo Acesso Motivo</b> : ' . $row['tipo_acesso_motivo'] . '</div>';
                }

                return $retorno;
            })
            ->addColumn('action', function ($row) {
                $permissaoShow = temPermissaoSituacao('militares_fundos_saude', 'show', $row['militarSituacaoId']);
                $permissaoEdit = temPermissaoSituacao('militares_fundos_saude', 'edit', $row['militarSituacaoId']);

                $botoes = 4;

                if (!$permissaoShow and !$permissaoEdit) {$botoes = 0;}
                if ($permissaoShow and !$permissaoEdit) {$botoes = 1;}
                if (!$permissaoShow and $permissaoEdit) {$botoes = 2;}
                if ($permissaoShow and $permissaoEdit) {$botoes = 4;}

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
                $militar_fundo_saude = $this->militarFundoSaudeService->getMilitarFundoSaude($id);

                if (!$militar_fundo_saude) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $militar_fundo_saude->toArray();

                $dados['data_documento'] = $militar_fundo_saude->data_documento ? $militar_fundo_saude->data_documento->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(MilitarFundoSaudeStoreRequest $request)
    {
        try {
            // Create
            $this->militarFundoSaudeService->createMilitarFundoSaude($request->all());

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
                $militar_fundo_saude = $this->militarFundoSaudeService->editMilitarFundoSaude($id);

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $militar_fundo_saude->toArray();

                $dados['data_documento'] = $militar_fundo_saude->data_documento ? $militar_fundo_saude->data_documento->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(MilitarFundoSaudeUpdateRequest $request, int $id)
    {
        try {
            $this->militarFundoSaudeService->updateMilitarFundoSaude($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
