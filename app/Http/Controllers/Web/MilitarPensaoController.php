<?php

namespace App\Http\Controllers\Web;

use App\Domain\PensaoTipo\PensaoTipoService;
use App\Domain\MilitarPensao\MilitarPensaoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MilitarPensaoStoreRequest;
use App\Http\Requests\MilitarPensaoUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MilitarPensaoController extends Controller
{
    public function __construct(
        private MilitarPensaoService $militarPensaoService,
        private PensaoTipoService $pensaoTipoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $militares_pensoes = $this->militarPensaoService->getMilitaresPensoes(1000);

            // Dados recebidos com sucesso
            if ($militares_pensoes) {
                return $this->datatable($militares_pensoes);
            } else {
                abort(500, 'Erro Interno Militar Pensão');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('militares_pensoes');

            $pensao_tipos = $this->pensaoTipoService->getPensaoTipos();

            return view('militares_pensoes.index', compact(['pensao_tipos']));
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $militares_pensoes = $this->militarPensaoService->getMilitaresPensoesFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($militares_pensoes) {
                return $this->datatable($militares_pensoes);
            } else {
                abort(500, 'Erro Interno Militares Pensão');
            }
        } else {
            return view('militares_pensoes.index');
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
            ->editColumn('pensao', function ($row) {
                $retorno = '<div class="col-12"><b>Tipo</b> : ' . $row["pensaoTipoName"] . '</div>
                            <div class="col-12"><b>Beneficiário</b> : ' . $row["beneficiario"] . '</div>
                            <div class="col-12"><b>Representante Legal</b> : ' . $row["representante_legal"] . '</div>';

                return $retorno;
            })
            ->addColumn('action', function ($row) {
                $permissaoShow = temPermissaoSituacao('militares_pensoes', 'show', $row['militarSituacaoId']);
                $permissaoEdit = temPermissaoSituacao('militares_pensoes', 'edit', $row['militarSituacaoId']);
                $permissaoDestroy = temPermissaoSituacao('militares_pensoes', 'destroy', $row['militarSituacaoId']);

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
                $militar_pensao = $this->militarPensaoService->getMilitarPensao($id);

                if (!$militar_pensao) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $militar_pensao->toArray();

                $dados['data_documento'] = $militar_pensao->data_documento ? Carbon::parse($militar_pensao->data_documento)->format('d/m/Y') : '';
                $dados['implantacao'] = $militar_pensao->implantacao ? Carbon::parse($militar_pensao->implantacao)->format('d/m/Y') : '';
                $dados['nascimento'] = $militar_pensao->nascimento ? Carbon::parse($militar_pensao->nascimento)->format('d/m/Y') : '';
                $dados['nascimento_beneficiario'] = $militar_pensao->nascimento_beneficiario ? Carbon::parse($militar_pensao->nascimento_beneficiario)->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(MilitarPensaoStoreRequest $request)
    {
        try {
            // Create
            $this->militarPensaoService->createMilitarPensao($request->all());

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
                $militar_pensao = $this->militarPensaoService->editMilitarPensao($id);

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $militar_pensao->toArray();

                $dados['data_documento'] = $militar_pensao->data_documento ? Carbon::parse($militar_pensao->data_documento)->format('d/m/Y') : '';
                $dados['implantacao'] = $militar_pensao->implantacao ? Carbon::parse($militar_pensao->implantacao)->format('d/m/Y') : '';
                $dados['nascimento'] = $militar_pensao->nascimento ? Carbon::parse($militar_pensao->nascimento)->format('d/m/Y') : '';
                $dados['nascimento_beneficiario'] = $militar_pensao->nascimento_beneficiario ? Carbon::parse($militar_pensao->nascimento_beneficiario)->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(MilitarPensaoUpdateRequest $request, int $id)
    {
        try {
            $this->militarPensaoService->updateMilitarPensao($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->militarPensaoService->deleteMilitarPensao($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
