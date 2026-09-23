<?php

namespace App\Domain\RessarcimentoPagamento;

use Illuminate\Http\Request;
use App\Domain\Lock\LockService;
use App\Domain\RessarcimentoCobranca\RessarcimentoCobrancaRepository;
use App\Domain\RessarcimentoReferencia\RessarcimentoReferenciaRepository;
use App\Domain\Transacao\TransacaoRepository;
use Illuminate\Support\Facades\Auth;

class RessarcimentoPagamentoService
{
    public function __construct(
        private RessarcimentoPagamentoRepository $repository,
        private LockService $lockService,
        private TransacaoRepository $transacaoRepository,
        private RessarcimentoReferenciaRepository $ressarcimentoReferenciaRepository,
        private RessarcimentoCobrancaRepository $ressarcimentoCobrancaRepository
    ) {}

    public function getRessarcimentoPagamentos($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getRessarcimentoPagamentosFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getRessarcimentoPagamento($id)
    {
        return $this->repository->find($id);
    }

    public function getPagamentoIdFuncReferencia($identidade_funcional, $referencia)
    {
        return $this->repository->pagamento_idfunc_referencia($identidade_funcional, $referencia);
    }

    public function createRessarcimentoPagamento(array $data)
    {
        return $this->repository->create($data);
    }

    public function editRessarcimentoPagamento($id)
    {
        $this->lockService->bloquear('ressarcimento_pagamentos', $id, Auth::user()->id);

        return $this->repository->find($id);
    }

    public function updateRessarcimentoPagamento($id, array $data)
    {
        $user_id = Auth::user()->id;

        try {
            if ($this->ressarcimentoCobrancaRepository->cobrancaEncerrada($data['referencia'])) {
                throw new \Exception('Cobrança encerrada para essa referência.');
            }

            // valida lock
            $this->lockService->validar('ressarcimento_pagamentos', $id, $user_id);

            // update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('ressarcimento_pagamentos', $id, $user_id);
        }
    }

    public function deleteRessarcimentoPagamento(int $id, string $referencia)
    {
        $user_id = Auth::user()->id;

        try {
            if ($this->ressarcimentoCobrancaRepository->cobrancaEncerrada($referencia)) {
                throw new \Exception('Cobrança encerrada para essa referência.');
            }

            // Bloquear
            $this->lockService->bloquear('ressarcimento_pagamentos', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('ressarcimento_pagamentos', $id, $user_id);

            // Busca o registro
            $ressarcimento_pagamento = $this->repository->find($id);

            if (!$ressarcimento_pagamento) {
                throw new \Exception('Registro não encontrado.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('ressarcimento_pagamentos', $id, $user_id);
        }
    }

    // Importar Pagamentos - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    // Importar Pagamentos - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    public function importar(Request $request)
    {
        if (!$request->hasFile('ressarcimento_pagamento_file')) {
            throw new \Exception('Selecione um arquivo CSV.');
        }

        $file = $request->file('ressarcimento_pagamento_file');

        if (!$file->isValid()) {
            throw new \Exception('Upload inválido.');
        }

        $this->validarArquivo($file);

        $referencia = $request->ressarcimento_pagamento_referencia;

        $this->validarReferencia($referencia);

        ini_set('max_execution_time', 2400);
        ini_set('memory_limit', '1024M');

        /*
        ========================================================
        LER ARQUIVO E NORMALIZAR CODIFICAÇÃO
        ========================================================
        */

        $conteudo = file_get_contents($file->getPathname());

        if ($conteudo === false) {
            throw new \Exception('Não foi possível ler o arquivo.');
        }

        /*
        ========================================================
        Detecta automaticamente:
        - UTF-8
        - Windows-1252
        - ISO-8859-1
        ========================================================
        */
        $encoding = mb_detect_encoding($conteudo, ['UTF-8', 'Windows-1252', 'ISO-8859-1'], true);

        if ($encoding === false) {
            throw new \Exception('Não foi possível identificar a codificação do arquivo CSV.');
        }

        /*
        ========================================================
        Converte para UTF-8 caso o arquivo não esteja originalmente nessa codificação.
        ========================================================
        */
        if ($encoding !== 'UTF-8') {
            $conteudo = mb_convert_encoding($conteudo, 'UTF-8', $encoding);
        }

        /*
        ========================================================
        Cria um arquivo temporário com o conteúdo convertido para UTF-8.
        ========================================================
        */
        $arquivoTemporario = tmpfile();

        if ($arquivoTemporario === false) {
            throw new \Exception('Não foi possível criar o arquivo temporário.');
        }

        fwrite($arquivoTemporario, $conteudo);
        rewind($arquivoTemporario);

        $handle = $arquivoTemporario;

        /*
        ========================================================
        CABEÇALHO
        ========================================================
        */

        $delimitador = ';';

        $cabecalho = fgetcsv($handle, 0, $delimitador);

        if (!$cabecalho) {
            fclose($handle);

            throw new \Exception('Arquivo sem dados.');
        }

        /*
        ========================================================
        Remover BOM UTF-8 do primeiro campo.
        ========================================================
        */

        $cabecalho[0] = preg_replace('/^\xEF\xBB\xBF/', '', $cabecalho[0]);

        $planilha_error = $this->validarCabecalho($cabecalho);

        if (count($planilha_error) > 0) {
            fclose($handle);

            return [
                'registros_importados' => 0,
                'registros_erros' => [],
                'registros_importados_anteriormente' => [],
                'planilha_error' => $planilha_error,
                'referencia_militares_existe' => true
            ];
        }

        /*
        ========================================================
        BUSCAR MILITARES
        ========================================================
        */

        $militares = $this->repository->buscarMilitaresPorReferencia($referencia);

        if ($militares->count() == 0) {
            fclose($handle);

            $resultado = [
                'registros_importados' => 0,
                'registros_erros' => [],
                'registros_importados_anteriormente' => [],
                'planilha_error' => [],
                'referencia_militares_existe' => false
            ];

            $this->gravarTransacao($referencia, $resultado);

            return $resultado;
        }

        /*
        ========================================================
        RESULTADO
        ========================================================
        */

        $resultado = [
            'registros_importados' => 0,
            'registros_erros' => [],
            'registros_importados_anteriormente' => [],
            'planilha_error' => [],
            'referencia_militares_existe' => true
        ];

        /*
        ========================================================
        PROCESSAR LINHAS
        ========================================================
        */

        while (($linha = fgetcsv($handle, 0, $delimitador)) !== false) {
            if ($this->linhaVazia($linha)) {
                continue;
            }

            $linha = array_pad($linha, count($cabecalho), '');
            $linhaDados = array_combine($cabecalho, $linha);

            if (!$linhaDados) {
                continue;
            }

            $militar = $this->localizarMilitar($linhaDados['ID_FUNCIONAL'], $militares);

            if (!$militar) {
                continue;
            }

            $existe = $this->repository->registroExiste($referencia, $linhaDados['ID_FUNCIONAL']);

            if ($existe) {
                $resultado['registros_importados_anteriormente'][] = $linhaDados['NOME_COMPLETO'];

                continue;
            }

            $dados = $this->montarRegistro($linhaDados, $militar->id, $referencia);

            $this->repository->insertRegistro($dados);

            $resultado['registros_importados']++;
        }

        fclose($handle);

        /*
        ========================================================
        GRAVAR TRANSAÇÃO
        ========================================================
        */

        $this->gravarTransacao($referencia, $resultado);

        return $resultado;
    }
    

    // public function importar(Request $request)
    // {
    //     if (!$request->hasFile('ressarcimento_pagamento_file')) {
    //         throw new \Exception('Selecione um arquivo CSV.');
    //     }

    //     $file = $request->file('ressarcimento_pagamento_file');

    //     if (!$file->isValid()) {
    //         throw new \Exception('Upload inválido.');
    //     }

    //     $this->validarArquivo($file);

    //     $referencia = $request->ressarcimento_pagamento_referencia;

    //     $this->validarReferencia($referencia);

    //     ini_set('max_execution_time', 2400);
    //     ini_set('memory_limit', '1024M');

    //     $handle = fopen($file->getPathname(), 'r');

    //     if (!$handle) {
    //         throw new \Exception('Não foi possível abrir o arquivo.');
    //     }

    //     $delimitador = ';';

    //     $cabecalho = fgetcsv($handle, 0, $delimitador);

    //     if (!$cabecalho) {
    //         fclose($handle);
    //         throw new \Exception('Arquivo sem dados.');
    //     }

    //     // remover BOM
    //     $cabecalho[0] = preg_replace('/^\xEF\xBB\xBF/', '', $cabecalho[0]);

    //     $planilha_error = $this->validarCabecalho($cabecalho);

    //     if (count($planilha_error) > 0) {
    //         fclose($handle);

    //         return [
    //             'registros_importados' => 0,
    //             'registros_erros' => [],
    //             'registros_importados_anteriormente' => [],
    //             'planilha_error' => $planilha_error,
    //             'referencia_militares_existe' => true
    //         ];
    //     }

    //     $militares = $this->repository->buscarMilitaresPorReferencia($referencia);

    //     if ($militares->count() == 0) {
    //         fclose($handle);

    //         $resultado = [
    //             'registros_importados' => 0,
    //             'registros_erros' => [],
    //             'registros_importados_anteriormente' => [],
    //             'planilha_error' => [],
    //             'referencia_militares_existe' => false
    //         ];

    //         $this->gravarTransacao($referencia, $resultado);

    //         return $resultado;
    //     }

    //     $resultado = [
    //         'registros_importados' => 0,
    //         'registros_erros' => [],
    //         'registros_importados_anteriormente' => [],
    //         'planilha_error' => [],
    //         'referencia_militares_existe' => true
    //     ];

    //     while (($linha = fgetcsv($handle, 0, $delimitador)) !== false) {

    //         if ($this->linhaVazia($linha)) {
    //             continue;
    //         }

    //         $linha = array_pad($linha, count($cabecalho), '');

    //         $linhaDados = array_combine($cabecalho, $linha);

    //         if (!$linhaDados) {
    //             continue;
    //         }

    //         $militar = $this->localizarMilitar($linhaDados['ID_FUNCIONAL'], $militares);

    //         if (!$militar) {
    //             continue;
    //         }

    //         $existe = $this->repository->registroExiste($referencia, $linhaDados['ID_FUNCIONAL']);

    //         if ($existe) {
    //             $resultado['registros_importados_anteriormente'][] = $linhaDados['NOME_COMPLETO'];

    //             continue;
    //         }

    //         $dados = $this->montarRegistro($linhaDados, $militar->id, $referencia);

    //         $this->repository->insertRegistro($dados);

    //         $resultado['registros_importados']++;
    //     }

    //     fclose($handle);

    //     $this->gravarTransacao($referencia, $resultado);

    //     return $resultado;
    // }

    private function validarArquivo($file)
    {
        if (strtolower($file->getClientOriginalExtension()) != 'csv') {
            throw new \Exception('Extensão de arquivo inválida, não é CSV.');
        }

        if ($file->getSize() > 10000000) {
            throw new \Exception('Arquivo muito grande. O arquivo deve ter menos de 10MB.');
        }
    }

    private function validarReferencia($referencia)
    {
        if ($referencia === '') {
            throw new \Exception('Referência vazia.');
        }

        if (!$this->ressarcimentoReferenciaRepository->referenciaExiste($referencia)) {
            throw new \Exception('Referência não existe.');
        }

        if ($this->ressarcimentoCobrancaRepository->cobrancaEncerrada($referencia)) {
            throw new \Exception('Cobrança encerrada para essa referência.');
        }
    }

    private function validarCabecalho($cabecalho)
    {
        $colunas = [
            'ID_FUNCIONAL',
            'RG',
            'NOME_CARGO',
            'POSTO_GRAD',
            'NOME_COMPLETO',
            'UA',
            'CPF',
            'BRUTO',
            'DESCONTO',
            'LIQUIDO',
            'SOLDO',
            'HOSPITAL10',
            'RIOPREVID_22',
            'ET_FERIAS',
            'ET_DEST',
            'AJ_FARD',
            'HABILIT_PROFISS',
            'GRET',
            'FERIAS',
            'RAIOX',
            'TRIENIO',
            'FDO_SAUDE',
            'ABONO_PERMANENCIA',
            'AUX_TRANSPORTE',
            'GRAM',
            'AUX_FARD',
            'CIDADE'
        ];

        $erros = [];

        foreach ($colunas as $coluna) {
            if (!in_array($coluna, $cabecalho)) {
                $erros[] = 'Não existe coluna "' . $coluna . '".';
            }
        }

        return $erros;
    }

    private function linhaVazia($linha)
    {
        foreach ($linha as $campo) {
            if (trim($campo) !== '') {
                return false;
            }
        }

        return true;
    }

    private function localizarMilitar($idFuncional, $militares)
    {
        $idFuncional = str_pad($idFuncional, 10, '0', STR_PAD_LEFT);

        foreach ($militares as $militar) {
            if ($militar->identidade_funcional == $idFuncional) {
                return $militar;
            }
        }

        return null;
    }

    private function montarRegistro($linha, $militarId, $referencia)
    {
        return [
            'ressarcimento_militar_id' => $militarId,
            'referencia' => $referencia,
            'identidade_funcional' => $linha['ID_FUNCIONAL'],
            'rg' => $linha['RG'],
            'nome_cargo' => mb_strtoupper($linha['NOME_CARGO'], 'UTF-8'),
            'posto_graduacao' => mb_strtoupper($linha['POSTO_GRAD'], 'UTF-8'),
            'nome' => mb_strtoupper($linha['NOME_COMPLETO'], 'UTF-8'),
            'ua' => $linha['UA'],
            'cpf' => $linha['CPF'],
            'bruto' => $linha['BRUTO'],
            'desconto' => $linha['DESCONTO'],
            'liquido' => $linha['LIQUIDO'],
            'soldo' => $linha['SOLDO'],
            'hospital10' => $linha['HOSPITAL10'],
            'rioprevidencia22' => $linha['RIOPREVID_22'],
            'etapa_ferias' => $linha['ET_FERIAS'],
            'etapa_destacado' => $linha['ET_DEST'],
            'ajuda_fardamento' => $linha['AJ_FARD'],
            'habilitacao_profissional' => $linha['HABILIT_PROFISS'],
            'gret' => $linha['GRET'],
            'ferias' => $linha['FERIAS'],
            'raio_x' => $linha['RAIOX'],
            'trienio' => $linha['TRIENIO'],
            'fundo_saude' => $linha['FDO_SAUDE'],
            'abono_permanencia' => $linha['ABONO_PERMANENCIA'],
            'auxilio_transporte' => $linha['AUX_TRANSPORTE'],
            'gram' => $linha['GRAM'],
            'auxilio_fardamento' => $linha['AUX_FARD'],
            'cidade' => mb_strtoupper($linha['CIDADE'], 'UTF-8')
        ];
    }

    private function gravarTransacao($referencia, $resultado)
    {
        $dados = [
            'campos' => [['campo' => 'referencia','etiqueta' => 'Referência','anterior' => null,'atual' => $referencia,'anterior_view' => null,'atual_view' => $referencia,],
                    ['campo' => 'registros_importados','etiqueta' => 'Registros Importados','anterior' => null,'atual' => $resultado['registros_importados'],'anterior_view' => null,'atual_view' => $resultado['registros_importados'],],
                    ['campo' => 'registros_erros','etiqueta' => 'Registros Erros','anterior' => null,'atual' => count($resultado['registros_erros']),'anterior_view' => null,'atual_view' => count($resultado['registros_erros']),],
                    ['campo' => 'registros_importados_anteriormente','etiqueta' => 'Registros Importados Anteriormente','anterior' => null,'atual' => count($resultado['registros_importados_anteriormente']),'anterior_view' => null,'atual_view' => count($resultado['registros_importados_anteriormente']),]
                ]
            ];

        $transacaoData = [
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'user_id' => Auth::user()->id,
            'operacao_id' => 1,
            'submodulo_id' => 11,
            'dados' => $dados
        ];

        $this->transacaoRepository->create($transacaoData);
    }
    // Importar Pagamentos - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    // Importar Pagamentos - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}
