<?php

namespace App\Http\Controllers\Web;

use App\Domain\HomologacaoTransacao\HomologacaoTransacaoService;
use App\Domain\Submodulo\SubmoduloService;
use App\Domain\User\UserService;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class HomologacaoTransacaoController extends Controller
{
    public function __construct(
        private HomologacaoTransacaoService $homologacaoTransacoesService,
        private SubmoduloService $submoduloService,
        private UserService $userService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $homologacao_transacoes = $this->homologacaoTransacoesService->getHomologacaoTransacoes(1000);

            // Dados recebidos com sucesso
            if ($homologacao_transacoes) {
                return $this->datatable($homologacao_transacoes);
            } else {
                abort(500, 'Erro Interno Homologação Transacao');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('homologacao_transacoes');

            $transacoes = $this->homologacaoTransacoesService->getHomologacaoTransacoes(1000);
            $submodulos = $this->submoduloService->getSubmodulos();
            $users = $this->userService->getUsers(1000);

            return view('homologacao_transacoes.index', compact(['transacoes', 'submodulos', 'users']));
        }
    }

    public function filter(Request $request, string $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $homologacao_transacoes = $this->homologacaoTransacoesService->getHomologacaoTransacoesFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($homologacao_transacoes) {
                return $this->datatable($homologacao_transacoes);
            } else {
                abort(500, 'Erro Interno Homologação Transacao');
            }
        } else {
            return view('homologacao_transacoes.index');
        }
    }

    public function datatable($registros)
    {
        $allData = DataTables::of($registros)
            ->addIndexColumn()
            ->editColumn('operacao', function ($row) {
                $class = 'text-dark';

                if ($row['operacao'] == 'Consulta') {
                    $class = 'text-dark';
                } else if ($row['operacao'] == 'Inclusão') {
                    $class = 'text-success';
                } else if ($row['operacao'] == 'Alteração') {
                    $class = 'text-primary';
                } else if ($row['operacao'] == 'Exclusão') {
                    $class = 'text-danger';
                } else if ($row['operacao'] == 'Importação') {
                    $class = 'text-warning';
                } else if ($row['operacao'] == 'Cobrança') {
                    $class = 'text-info';
                }

                return '<span class="'.$class.'">'.$row['operacao'].'</span>';
            })
            ->editColumn('data', function ($row) {
                return getDataFormatada(1, $row['data']);
            })
            ->escapeColumns([])
            ->make(true);

        return $allData;
    }
}
