<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Domain\RessarcimentoCobranca\RessarcimentoCobrancaService;
use App\Domain\RessarcimentoReferencia\RessarcimentoReferenciaService;
use App\Domain\Transacao\TransacaoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;

class RessarcimentoCobrancaController extends Controller
{
    public function __construct(
        private TransacaoService $transacaoService,
        private RessarcimentoCobrancaService $ressarcimentoCobrancaService,
        private RessarcimentoReferenciaService $ressarcimentoReferenciaService
    ) {}

    public function index(Request $request)
    {
        // Definir CRUD Sessions
        setCrudSessions('ressarcimento_cobrancas');

        $ressarcimento_cobrancas = $this->ressarcimentoCobrancaService->getRessarcimentoCobrancas();

        $referencias = $this->ressarcimentoReferenciaService->getReferenciasComMilitares();

        return view('ressarcimento_cobrancas.index', compact(['referencias']));
    }

    public function dados_ressarcimento($referencia)
    {
        try {
            $dados_ressarcimento = $this->ressarcimentoCobrancaService->getDadosRessarcimento($referencia);


            //Verificar se tem os 3(três) arquivos pdf de cobrança''''''''''''''''''''''''''''''''''''''''''''''''''

            //Padrão dos arquivos
            //Listagem: cobranca_referencia_listagem_orgao id => cobranca_20231001_listagem_1
            //Nota: cobranca_referencia_nota_orgao id => cobranca_20231001_nota_1
            //Ofício: cobranca_referencia_oficio_orgao id => cobranca_20231001_oficio_1

            //Variaveis
            $arqListagemQtd = 0;
            $arqNotaQtd = 0;
            $arqOficioQtd = 0;

            //varrer orgãos procurando arquivos
            foreach ($dados_ressarcimento['re_orgaos'] as $orgao) {
                $arqListagemNome = 'cobranca_'.$referencia.'_listagem_'.$orgao['id'].'.pdf';
                $arqNotaNome = 'cobranca_'.$referencia.'_nota_'.$orgao['id'].'.pdf';
                $arqOficioNome = 'cobranca_'.$referencia.'_oficio_'.$orgao['id'].'.pdf';

                if (file_exists('build/assets/pdfs/cobrancas/'.$arqListagemNome)) {$arqListagemQtd++;}
                if (file_exists('build/assets/pdfs/cobrancas/'.$arqNotaNome)) {$arqNotaQtd++;}
                if (file_exists('build/assets/pdfs/cobrancas/'.$arqOficioNome)) {$arqOficioQtd++;}
            }

            //Variáveis de Controle''''''''
            $re_status_documentos = $dados_ressarcimento['re_status_documentos'];
            $re_status_documentos_texto = $dados_ressarcimento['re_status_documentos_texto'];

            //Verificação de status: Listagens
            if ($arqListagemQtd == count($dados_ressarcimento['re_orgaos'])) {
                $listagem_status_cor = 'success';
                $listagem_status = 'Quantidade de PDFs Listagens Ok';
            } else {
                //Variáveis de Controle''''''''
                $re_status_documentos = 0;
                $re_status_documentos_texto = 'Documentos Falhou.';
                //'''''''''''''''''''''''''''''

                if ($arqListagemQtd == 0) {
                    $listagem_status_cor = 'danger';
                    $listagem_status = 'Não existem arquivos de PDFs Listagens';
                } else {
                    $listagem_status_cor = 'danger';
                    $listagem_status = 'Quantidade de arquivos PDFs de Listagens';
                }
            }

            //Verificação de status: Notas
            if ($arqNotaQtd == count($dados_ressarcimento['re_orgaos'])) {
                $nota_status_cor = 'success';
                $nota_status = 'Quantidade de PDFs Notas Ok';
            } else {
                //Variáveis de Controle''''''''
                $re_status_documentos = 0;
                $re_status_documentos_texto = 'Documentos Falhou.';
                //'''''''''''''''''''''''''''''

                if ($arqNotaQtd == 0) {
                    $nota_status_cor = 'danger';
                    $nota_status = 'Não existem arquivos de PDFs Notas';
                } else {
                    $nota_status_cor = 'danger';
                    $nota_status = 'Quantidade de arquivos PDFs de Notas';
                }
            }

            //Verificação de status: Ofícios
            if ($arqOficioQtd == count($dados_ressarcimento['re_orgaos'])) {
                $oficio_status_cor = 'success';
                $oficio_status = 'Quantidade de PDFs Ofícios Ok';
            } else {
                //Variáveis de Controle''''''''
                $re_status_documentos = 0;
                $re_status_documentos_texto = 'Documentos Falhou.';
                //'''''''''''''''''''''''''''''

                if ($arqOficioQtd == 0) {
                    $oficio_status_cor = 'danger';
                    $oficio_status = 'Não existem arquivos de PDFs Ofícios';
                } else {
                    $oficio_status_cor = 'danger';
                    $oficio_status = 'Quantidade de arquivos PDFs de Ofícios';
                }
            }

            //Variáveis de Controle''''''''
            if ($re_status_documentos == 0) {
                $dados_ressarcimento['re_status_documentos'] = $re_status_documentos;
                $dados_ressarcimento['re_status_documentos_texto'] = $re_status_documentos_texto;
            }

            //colocando Status no array para mostrar na View
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

    public function gerar_cobrancas($referencia)
    {
        try {
            $gerar_cobrancas = $this->ressarcimentoCobrancaService->gerar_cobrancas($referencia);

            // Gravar Transação''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Dados
            $apagar_cobranca = $gerar_cobrancas['transacoes']['apagar_cobranca'];
            $criar_cobranca = $gerar_cobrancas['transacoes']['criar_cobranca'];
            $criar_listagens = $gerar_cobrancas['transacoes']['criar_listagens'];
            $criar_oficios = $gerar_cobrancas['transacoes']['criar_oficios'];
            $criar_notas = $gerar_cobrancas['transacoes']['criar_notas'];

            // Montando Dados
            $dados = [
                'campos' => [['campo' => 'referencia','etiqueta' => 'Referência','anterior' => null,'atual' => $referencia,'anterior_view' => null,'atual_view' => $referencia,],
                        ['campo' => 'apagar_cobranca','etiqueta' => 'Apagar Cobrança','anterior' => null,'atual' => $apagar_cobranca,'anterior_view' => null,'atual_view' => $apagar_cobranca,],
                        ['campo' => 'criar_cobranca','etiqueta' => 'Criar Cobrança','anterior' => null,'atual' => $criar_cobranca,'anterior_view' => null,'atual_view' => $criar_cobranca,],
                        ['campo' => 'criar_listagens','etiqueta' => 'Criar Listagens','anterior' => null,'atual' => $criar_listagens,'anterior_view' => null,'atual_view' => $criar_listagens,],
                        ['campo' => 'criar_oficios','etiqueta' => 'Criar Ofícios','anterior' => null,'atual' => $criar_oficios,'anterior_view' => null,'atual_view' => $criar_oficios,],
                        ['campo' => 'criar_notas','etiqueta' => 'Criar Notas','anterior' => null,'atual' => $criar_notas,'anterior_view' => null,'atual_view' => $criar_notas,]
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

            return response()->json(['success' => 'Cobrança Gerada com sucesso.']);
        } catch (\Throwable $e) {
            $mensagem = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();

            return response()->json(['error' => $mensagem]);
        }
    }

    public function gerar_pdfs($referencia)
    {
        try {
            $gerar_pdfs = $this->ressarcimentoCobrancaService->gerar_pdfs($referencia);

            // Variaveis para Gravação da Transação
            $total_pdfs_listagens = 0;
            $total_pdfs_notas = 0;
            $total_pdfs_oficios = 0;
            $total_pdfs_zipados = 0;

            // Gerar PDF Listagem
            $listagens = $gerar_pdfs['cobranca_pdfs_listagens'];
            $listagens_dados = $gerar_pdfs['cobranca_pdfs_listagens_dados'];
            foreach ($listagens as $listagem) {
                $listagem = $listagem;
                $pdf = Pdf::loadView('ressarcimento_cobrancas.pdf_listagem', compact('listagem', 'listagens_dados'))->setPaper('a4', 'portrait');
                $pdf->save('build/assets/pdfs/cobrancas/cobranca_' . $referencia . '_listagem_' . $listagem['ressarcimento_orgao_id'] . '.pdf');

                $total_pdfs_listagens++;
            }

            // Gerar PDF Notas
            $notas = $gerar_pdfs['cobranca_pdfs_notas'];
            foreach ($notas as $nota) {
                $dados = $nota;
                $pdf = Pdf::loadView('ressarcimento_cobrancas.pdf_nota', compact('dados'))->setPaper('a4', 'portrait');
                $pdf->save('build/assets/pdfs/cobrancas/cobranca_' . $referencia . '_nota_' . $nota['ressarcimento_orgao_id'] . '.pdf');

                $total_pdfs_notas++;
            }

            // Gerar PDF Ofícios
            $oficios = $gerar_pdfs['cobranca_pdfs_oficios'];
            foreach ($oficios as $oficio) {
                $dados = $oficio;
                $pdf = Pdf::loadView('ressarcimento_cobrancas.pdf_oficio', compact('dados'))->setPaper('a4', 'portrait');
                $pdf->save('build/assets/pdfs/cobrancas/cobranca_' . $referencia . '_oficio_' . $oficio['ressarcimento_orgao_id'] . '.pdf');

                $total_pdfs_oficios++;
            }

            // Gerar ZIP
            $pasta = 'build/assets/pdfs/cobrancas/';
            $arquivos = glob($pasta . '*_'.$referencia.'*.pdf');

            if (count($arquivos) > 0) {
                $zip = new ZipArchive();
                $nomeZip = $pasta . 'cobranca_' . $referencia . '.zip';

                if ($zip->open($nomeZip, ZipArchive::CREATE) === TRUE) {
                    foreach ($arquivos as $arquivo) {
                        $nomeArquivo = basename($arquivo);
                        $zip->addFile($arquivo, $nomeArquivo);
                    }

                    $zip->close();

                    $total_pdfs_zipados++;
                }
            }

            // Gravar Transação''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            // Montando Dados
            $dados = [
                'campos' => [['campo' => 'referencia','etiqueta' => 'Referência','anterior' => null,'atual' => $referencia,'anterior_view' => null,'atual_view' => $referencia,],
                        ['campo' => 'pdfs_criados_listagens','etiqueta' => 'PDFs de Listagens','anterior' => null,'atual' => $total_pdfs_listagens,'anterior_view' => null,'atual_view' => $total_pdfs_listagens,],
                        ['campo' => 'pdfs_criados_oficios','etiqueta' => 'PDFs de Ofícios','anterior' => null,'atual' => $total_pdfs_oficios,'anterior_view' => null,'atual_view' => $total_pdfs_oficios,],
                        ['campo' => 'pdfs_criados_notas','etiqueta' => 'PDFs de Notas','anterior' => null,'atual' => $total_pdfs_notas,'anterior_view' => null,'atual_view' => $total_pdfs_notas,],
                        ['campo' => 'zip_criado','etiqueta' => 'Arquivo Zipado com PDFs','anterior' => null,'atual' => $total_pdfs_zipados,'anterior_view' => null,'atual_view' => $total_pdfs_zipados,]

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

            return response()->json(['success' => 'PDFs Gerados com sucesso.']);
        } catch (\Throwable $e) {
            $mensagem = $e->getPrevious() ? $e->getPrevious()->getMessage() : $e->getMessage();

            return response()->json(['error' => $mensagem]);
        }
    }

    public function verificar_existe_zip($referencia)
    {
        if (file_exists('build/assets/pdfs/cobrancas/cobranca_' . $referencia . '.zip')) {
            return response()->json(['success' => 'Arquivo encontrado.']);
        } else {
            return response()->json(['error' => 'Arquivo não encontrado.']);
        }
    }

    public function deletar_pdfs_gerados($referencia)
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
}
