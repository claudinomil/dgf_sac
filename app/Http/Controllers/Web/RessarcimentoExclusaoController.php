<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Domain\RessarcimentoExclusao\RessarcimentoExclusaoService;
use App\Domain\Transacao\TransacaoService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RessarcimentoExclusaoController extends Controller
{
    public function __construct(
        private TransacaoService $transacaoService,
        private RessarcimentoExclusaoService $ressarcimentoExclusaoService
    ) {}

    public function index(Request $request)
    {
        // Requisição Ajax
        if ($request->ajax()) {
            $ressarcimento_exclusoes = $this->ressarcimentoExclusaoService->getRessarcimentoExclusoes(1000);

            // Dados recebidos com sucesso
            if ($ressarcimento_exclusoes) {
                return $this->datatable($ressarcimento_exclusoes);
            } else {
                abort(500, 'Erro Interno RessarcimentoExclusoes');
            }
        } else {
            // Definir CRUD Sessions
            setCrudSessions('ressarcimento_exclusoes');

            return view('ressarcimento_exclusoes.index');
        }
    }

    public function filter(Request $request, $array_dados)
    {
        //Requisição Ajax
        if ($request->ajax()) {
            $ressarcimento_exclusoes = $this->ressarcimentoExclusaoService->getRessarcimentoExclusoesFilter($array_dados, 1000);

            // Dados recebidos com sucesso
            if ($ressarcimento_exclusoes) {
                return $this->datatable($ressarcimento_exclusoes);
            } else {
                abort(500, 'Erro Interno RessarcimentoExclusoes');
            }
        } else {
            return view('ressarcimento_exclusoes.index');
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

    public function ultima_referencia()
    {
        //Verificando Origem enviada pelo Fetch
        if ($_SERVER['HTTP_REQUEST_ORIGIN'] == 'fetch') {
            return $this->ressarcimentoExclusaoService->getUltimaReferencia();
        }
    }

    public function dados_ressarcimento(string $referencia)
    {
        try {
            $dados_ressarcimento = $this->ressarcimentoExclusaoService->getDadosRessarcimento($referencia);


            // Verificar se tem os 3(três) arquivos pdf de cobrança'''''''''''''''''''''''''''''''''''''''''''''''''

            // Padrão dos arquivos
            // Listagem: cobranca_referencia_listagem_orgao id => cobranca_20231001_listagem_1
            // Nota: cobranca_referencia_nota_orgao id => cobranca_20231001_nota_1
            // Ofício: cobranca_referencia_oficio_orgao id => cobranca_20231001_oficio_1

            // Variaveis
            $arqListagemQtd = 0;
            $arqNotaQtd = 0;
            $arqOficioQtd = 0;

            // varrer orgãos procurando arquivos
            foreach ($dados_ressarcimento['re_orgaos'] as $orgao) {
                $arqListagemNome = 'cobranca_'.$referencia.'_listagem_'.$orgao['id'].'.pdf';
                $arqNotaNome = 'cobranca_'.$referencia.'_nota_'.$orgao['id'].'.pdf';
                $arqOficioNome = 'cobranca_'.$referencia.'_oficio_'.$orgao['id'].'.pdf';

                if (file_exists('build/assets/pdfs/cobrancas/'.$arqListagemNome)) {$arqListagemQtd++;}
                if (file_exists('build/assets/pdfs/cobrancas/'.$arqNotaNome)) {$arqNotaQtd++;}
                if (file_exists('build/assets/pdfs/cobrancas/'.$arqOficioNome)) {$arqOficioQtd++;}
            }

            // Verificação de status: Listagens
            if ($arqListagemQtd == count($dados_ressarcimento['re_orgaos'])) {
                $listagem_status_cor = 'success';
                $listagem_status = 'Quantidade de PDFs Listagens Ok';
            } else {
                if ($arqListagemQtd == 0) {
                    $listagem_status_cor = 'danger';
                    $listagem_status = 'Não existem arquivos de PDFs Listagens';
                } else {
                    $listagem_status_cor = 'danger';
                    $listagem_status = 'Quantidade de arquivos PDFs de Listagens: '.$arqListagemQtd;
                }
            }

            // Verificação de status: Notas
            if ($arqNotaQtd == count($dados_ressarcimento['re_orgaos'])) {
                $nota_status_cor = 'success';
                $nota_status = 'Quantidade de PDFs Notas Ok';
            } else {
                if ($arqNotaQtd == 0) {
                    $nota_status_cor = 'danger';
                    $nota_status = 'Não existem arquivos de PDFs Notas';
                } else {
                    $nota_status_cor = 'danger';
                    $nota_status = 'Quantidade de arquivos PDFs de Notas: '.$arqNotaQtd;
                }
            }

            // Verificação de status: Ofícios
            if ($arqOficioQtd == count($dados_ressarcimento['re_orgaos'])) {
                $oficio_status_cor = 'success';
                $oficio_status = 'Quantidade de PDFs Ofícios Ok';
            } else {
                if ($arqOficioQtd == 0) {
                    $oficio_status_cor = 'danger';
                    $oficio_status = 'Não existem arquivos de PDFs Ofícios';
                } else {
                    $oficio_status_cor = 'danger';
                    $oficio_status = 'Quantidade de arquivos PDFs de Ofícios: '.$arqOficioQtd;
                }
            }

            // colocando Status no array para mostrar na View
            $dados_ressarcimento['re_registros_grade_status_documentos'][] = [
                'status_cor' => $listagem_status_cor,
                'status' => $listagem_status,
                'detalhes' => ''
            ];

            $dados_ressarcimento['re_registros_grade_status_documentos'][] = [
                'status_cor' => $nota_status_cor,
                'status' => $nota_status,
                'detalhes' => ''
            ];

            $dados_ressarcimento['re_registros_grade_status_documentos'][] = [
                'status_cor' => $oficio_status_cor,
                'status' => $oficio_status,
                'detalhes' => ''
            ];
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            return response()->json(['success' => $dados_ressarcimento]);
        } catch (\Throwable $e) {
            $mensagem = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();

            return response()->json(['error' => $mensagem]);
        }
    }

    public function deletar_pdfs_gerados(string $referencia)
    {
        // Apagando listagem
        array_map('unlink', glob('build/assets/pdfs/cobrancas/cobranca_'.$referencia.'_listagem_*.pdf'));

        // Apagando Notas
        array_map('unlink', glob('build/assets/pdfs/cobrancas/cobranca_'.$referencia.'_nota_*.pdf'));

        // Apagando Ofícios
        array_map('unlink', glob('build/assets/pdfs/cobrancas/cobranca_'.$referencia.'_oficio_*.pdf'));

        // Apagando ZIP
        array_map('unlink', glob('build/assets/pdfs/cobrancas/cobranca_'.$referencia.'.zip'));
    }

    public function deletar_cobranca(string $referencia)
    {
        try {
            $gerar_cobrancas = $this->ressarcimentoExclusaoService->deletar_cobranca($referencia);

            // Gravar Transação''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Dados
            $apagar_cobranca = $gerar_cobrancas['transacoes']['apagar_cobranca'];

            // Montando Dados
            $dados = [
                'campos' => [['campo' => 'referencia','etiqueta' => 'Referência','anterior' => null,'atual' => $referencia,'anterior_view' => null,'atual_view' => $referencia,],
                        ['campo' => 'apagar_cobranca','etiqueta' => 'Apagar Cobrança','anterior' => null,'atual' => $apagar_cobranca,'anterior_view' => null,'atual_view' => $apagar_cobranca,]
                    ]
                ];

            // Gravando
            $transacaoData = [
                'date' => date('Y-m-d'),
                'time' => date('H:i:s'),
                'user_id' => Auth::user()->id,
                'operacao_id' => 1,
                'submodulo_id' => 13,
                'dados' => $dados
            ];

            $this->transacaoService->createTransacao($transacaoData);
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            return response()->json(['success' => 'Cobrança Deletada com sucesso.']);
        } catch (\Throwable $e) {
            $mensagem = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();

            return response()->json(['error' => $mensagem]);
        }
    }
}
