<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Domain\Transacao\TransacaoService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class TransacaoController extends Controller
{
    public function __construct(
        private TransacaoService $transacaoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $transacoes = $this->transacaoService->getTransacoes(1000);

            // Dados recebidos com sucesso
            if ($transacoes) {
                return $this->datatable($transacoes);
            } else {
                abort(500, 'Erro Interno Transacao');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('transacoes');

            return view('transacoes.index');
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $transacoes = $this->transacaoService->getTransacoesFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($transacoes) {
                return $this->datatable($transacoes);
            } else {
                abort(500, 'Erro Interno Transacao');
            }
        } else {
            return view('transacoes.index');
        }
    }

    public function datatable($registros)
    {
        $allData = DataTables::of($registros)
            ->addIndexColumn()
            ->editColumn('date', function ($row) {
                $date = date('d/m/Y', strtotime($row['date']));
                $time = $row['time'];

                $retorno = "<h5 class='text-truncate font-size-14'>" . $date . "</h5>";
                $retorno .= "<p class='text-muted mb-0'>" . $time . "</p>";

                return $retorno;
            })
            ->editColumn('submoduloName', function ($row) {
                $submodulo = e($row['submoduloName']);
                $operacao = e($row['operacaoName']);

                $cores = [
                    1 => 'text-success', // Inclusão
                    2 => 'text-primary', // Alteração
                    3 => 'text-danger',  // Exclusão
                ];

                $corOperacao = $cores[$row['operacao_id']] ?? 'text-muted';

                return "
                            <div class='d-flex flex-column'>
                                <span class='fw-semibold text-truncate'>{$submodulo}</span>
                                <small class='{$corOperacao}'>{$operacao}</small>
                            </div>
                        ";
            })
            ->editColumn('dados', function ($row) {
                $identRegistro = '<div class="alert alert-success p-0 p-1 small text-center">';

                $retorno = "<div class='table-responsive'>";
                $retorno .= "   <table class='table table-striped mb-0'>";
                $retorno .= "       <thead class='table-light'>";
                $retorno .= "           <tr>";
                $retorno .= "               <th>#</th>";

                // Inclusão
                if ($row['operacao_id'] == 1) {
                    $retorno .= "           <th>Atual</th>";
                }

                // Alteração
                if ($row['operacao_id'] == 2) {
                    $retorno .= "           <th>Anterior</th>";
                    $retorno .= "           <th>Atual</th>";
                }

                // Exclusão
                if ($row['operacao_id'] == 3) {
                    $retorno .= "           <th>Anterior</th>";
                }

                $retorno .= "           </tr>";
                $retorno .= "       </thead>";
                $retorno .= "       <tbody>";

                $dados = $row['dados'];

                if (!empty($dados['campos'])) {
                    foreach ($dados['campos'] as $registro) {
                        $campo = $registro['campo'];
                        $etiqueta = $registro['etiqueta'];
                        $anterior_view = $registro['anterior_view'];
                        $atual_view = $registro['atual_view'];
                        $class = 'text-dark';

                        // Campo Principal Fixo para mostrar (serve para Identificar o Registro)'''''''''''''''''''''''

                        // Campos permitidos por submódulo
                        $camposPermitidos = [
                            1   =>  ['user', 'name'],       // Submódulo Users
                            2   =>  ['name'],               // Submódulo Grupos
                            6   =>  ['referencia'],         // Submódulo Ressarcimento Configurações
                            7   =>  ['referencia'],         // Submódulo Ressarcimento Referências
                            10  =>  ['name'],               // Submódulo Ressarcimento Orgãos
                            11  =>  ['referencia'],         // Submódulo Ressarcimento Pagamentos
                            12  =>  ['referencia'],         // Submódulo Ressarcimento Militares
                            13  =>  ['referencia'],         // Submódulo Ressarcimento Cobranças
                            18  =>  ['rg', 'nome'],         // Submódulo Militares
                            15  =>  ['militar_id'],         // Submódulo Militares Cursos
                            23  =>  ['militar_id'],         // Submódulo Militares Contatos
                            3   =>  ['militar_id'],         // Submódulo Militares Ajudas de Custos
                            5   =>  ['militar_id'],         // Submódulo Militares Auxílios Fardamentos
                            16  =>  ['militar_id'],         // Submódulo Militares Dependentes
                            19  =>  ['militar_id'],         // Submódulo Militares Fundos Saúde
                            26  =>  ['name'],               // Submódulo Situações
                            27  =>  ['name'],               // Submódulo Graduações
                            28  =>  ['name'],               // Submódulo Quadros
                            29  =>  ['name'],               // Submódulo Comportamentos
                            30  =>  ['name'],               // Submódulo Unidades
                            31  =>  ['name'],               // Submódulo Funções
                            32  =>  ['name'],               // Submódulo Gêneros
                            33  =>  ['name'],               // Submódulo Parentescos
                            34  =>  ['name'],               // Submódulo Cursos
                        ];

                        // Verifica se existe para o submódulo atual
                        if (isset($camposPermitidos[$row['submodulo_id']])) {
                            // Se a etiqueta estiver entre os campos permitidos
                            if (in_array($campo, $camposPermitidos[$row['submodulo_id']])) {
                                $identRegistro .= $atual_view . '<br>';
                            }
                        }
                        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

                        $mostrar = false;

                        // Inclusão
                        if ($row['operacao_id'] == 1) {
                            $mostrar = true;
                        }

                        // Alteração
                        if ($row['operacao_id'] == 2) {
                            // Mostrar campos diferentes
                            if ($anterior_view !== $atual_view) {
                                $mostrar = true;
                                $class = 'text-primary';
                            }
                        }

                        // Exclusão
                        if ($row['operacao_id'] == 3) {
                            $mostrar = true;
                        }

                        // Sem valor Atual
                        if ($atual_view === null) {
                            $mostrar = false;
                        }

                        // Mostrar
                        if ($mostrar) {
                            $retorno .= "<tr>";
                            $retorno .= "   <td>" . $etiqueta . "</td>";

                            // Inclusão
                            if ($row['operacao_id'] == 1) {
                                $retorno .= "   <td class='" . $class . "'>" . $atual_view . "</td>";
                            }

                            // Alteração
                            if ($row['operacao_id'] == 2) {
                                $retorno .= "   <td class='text-dark'>" . $anterior_view . "</td>";
                                $retorno .= "   <td class='" . $class . "'>" . $atual_view . "</td>";
                            }

                            // Exclusão
                            if ($row['operacao_id'] == 3) {
                                $retorno .= "   <td class='" . $class . "'>" . $atual_view . "</td>";
                            }

                            $retorno .= "</tr>";
                        }
                    }
                }

                $retorno .= "       </tbody>";
                $retorno .= "   </table>";
                $retorno .= "</div>";

                $identRegistro .= '</div>';

                return $identRegistro . $retorno;
            })
            ->escapeColumns([])
            ->make(true);

        return $allData;
    }
}
