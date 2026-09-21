<?php

namespace App\Http\Controllers\Web;

use App\Domain\MilitarContato\MilitarContatoService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MilitarContatoStoreRequest;
use App\Http\Requests\MilitarContatoUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class MilitarContatoController extends Controller
{
    public function __construct(
        private MilitarContatoService $militarContatoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $militares_contatos = $this->militarContatoService->getMilitaresContatos(1000);

            // Dados recebidos com sucesso
            if ($militares_contatos) {
                return $this->datatable($militares_contatos);
            } else {
                abort(500, 'Erro Interno Militar Contato');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('militares_contatos');

            return view('militares_contatos.index');
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $militares_contatos = $this->militarContatoService->getMilitaresContatosFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($militares_contatos) {
                return $this->datatable($militares_contatos);
            } else {
                abort(500, 'Erro Interno Militares Contato');
            }
        } else {
            return view('militares_contatos.index');
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
            ->editColumn('contato', function ($row) {
                $retorno = '';

                if (!blank($row['cep'])) {
                    $retorno .= '<div class="col-12"><b>CEP: </b>' . getCepFormatado(1, $row["cep"]) . '</div>
                                <div class="col-12"><b>Logradouro: </b>' . $row["logradouro"] . '</div>
                                <div class="col-12"><b>Bairro: </b>' . $row["bairro"] . '</div>
                                <div class="col-12"><b>Localidade: </b>' . $row["localidade"] . '</div>
                                <div class="col-12"><b>UF: </b>' . $row["uf"] . '</div>';
                }

                if (!blank($row['celular_1'])) {
                    $retorno .= '<div class="col-12"><b>Celular 1: </b>' . getCelularFormatado(1, $row["celular_1"]) . '</div>';
                }

                if (!blank($row['celular_2'])) {
                    $retorno .= '<div class="col-12"><b>Celular 2: </b>' . getCelularFormatado(1, $row["celular_2"]) . '</div>';
                }

                if (!blank($row['telefone_1'])) {
                    $retorno .= '<div class="col-12"><b>Telefone 1: </b>' . getTelefoneFormatado(1, $row["telefone_1"]) . '</div>';
                }

                if (!blank($row['telefone_2'])) {
                    $retorno .= '<div class="col-12"><b>Telefone 2: </b>' . getTelefoneFormatado(1, $row["telefone_2"]) . '</div>';
                }

                if (!blank($row['email'])) {
                    $retorno .= '<div class="col-12"><b>E-mail: </b>' . $row["email"] . '</div>';
                }

                return $retorno;
            })
            ->addColumn('action', function ($row) {
                $permissaoShow = temPermissaoSituacao('militares_contatos', 'show', $row['militarSituacaoId']);
                $permissaoEdit = temPermissaoSituacao('militares_contatos', 'edit', $row['militarSituacaoId']);
                $permissaoDestroy = temPermissaoSituacao('militares_contatos', 'destroy', $row['militarSituacaoId']);

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
                $militar_contato = $this->militarContatoService->getMilitarContato($id);

                if (!$militar_contato) {
                    return response()->json(['error' => 'Registro não encontrado']);
                }

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $militar_contato->toArray();

                $dados['data_inicio'] = $militar_contato->data_inicio ? $militar_contato->data_inicio->format('d/m/Y') : '';
                $dados['data_termino'] = $militar_contato->data_termino ? $militar_contato->data_termino->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 403);
            }
        }
    }

    public function store(MilitarContatoStoreRequest $request)
    {
        try {
            // Create
            $this->militarContatoService->createMilitarContato($request->all());

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
                $contato = $this->militarContatoService->editMilitarContato($id);

                // Preparando Dados para a View''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
                $dados = $contato->toArray();

                $dados['data_inicio'] = $contato->data_inicio ? $contato->data_inicio->format('d/m/Y') : '';
                $dados['data_termino'] = $contato->data_termino ? $contato->data_termino->format('d/m/Y') : '';
                //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                return response()->json(['success' => $dados]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    }

    public function update(MilitarContatoUpdateRequest $request, int $id)
    {
        try {
            $this->militarContatoService->updateMilitarContato($id, $request->all());

            return response()->json(['success' => 'Registro atualizado com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->militarContatoService->deleteMilitarContato($id);

            return response()->json(['success' => 'Registro excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
