<?php

namespace App\Domain\RessarcimentoMilitar;

use Illuminate\Http\Request;
use App\Domain\Lock\LockService;
use App\Domain\RessarcimentoCobranca\RessarcimentoCobrancaRepository;
use App\Domain\RessarcimentoConfiguracao\RessarcimentoConfiguracaoRepository;
use App\Domain\RessarcimentoOrgao\RessarcimentoOrgaoRepository;
use App\Domain\RessarcimentoReferencia\RessarcimentoReferenciaRepository;
use App\Domain\Transacao\TransacaoRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RessarcimentoMilitarService
{
    public function __construct(
        private RessarcimentoMilitarRepository $repository,
        private LockService $lockService,
        private TransacaoRepository $transacaoRepository,
        private RessarcimentoReferenciaRepository $ressarcimentoReferenciaRepository,
        private RessarcimentoOrgaoRepository $ressarcimentoOrgaoRepository,
        private RessarcimentoConfiguracaoRepository $ressarcimentoConfiguracaoRepository,
        private RessarcimentoCobrancaRepository $ressarcimentoCobrancaRepository
    ) {}

    public function getRessarcimentoMilitares($limit = null)
    {
        return $this->repository->index($limit);
    }

    public function getRessarcimentoMilitaresFilter($array_dados, $limit = null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getRessarcimentoMilitar($id)
    {
        return $this->repository->find($id);
    }

    public function getMilitaresLotacaoReferencia($lotacao_id, $referencia)
    {
        return $this->repository->militares_lotacao_referencia($lotacao_id, $referencia);
    }

    public function createRessarcimentoMilitar(array $data)
    {
        return $this->repository->create($data);
    }

    public function editRessarcimentoMilitar($id)
    {
        $this->lockService->bloquear('ressarcimento_militares', $id, Auth::user()->id);

        return $this->repository->find($id);
    }

    public function updateRessarcimentoMilitar($id, array $data)
    {
        $user_id = Auth::user()->id;

        try {
            // valida lock
            $this->lockService->validar('ressarcimento_militares', $id, $user_id);

            // update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('ressarcimento_militares', $id, $user_id);
        }
    }

    public function deleteRessarcimentoMilitar(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('ressarcimento_militares', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('ressarcimento_militares', $id, $user_id);

            // Busca o registro
            $ressarcimento_militar = $this->repository->find($id);

            if (!$ressarcimento_militar) {
                throw new \Exception('Registro não encontrado.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('ressarcimento_militares', $id, $user_id);
        }
    }

    // Importar Militares - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    // Importar Militares - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    public function importar(Request $request)
    {
        if (!$request->hasFile('ressarcimento_militar_file')) {
            throw new \Exception('Selecione um arquivo CSV.');
        }

        $file = $request->file('ressarcimento_militar_file');

        if (!$file->isValid()) {
            throw new \Exception('Upload inválido.');
        }

        $this->validarArquivo($file);

        $referencia = $request->ressarcimento_militar_referencia;

        $this->validarReferencia($referencia);

        $path = $file->getPathname();

        $handle = fopen($path, 'r');

        if (!$handle) {
            throw new \Exception('Não foi possível abrir o arquivo.');
        }

        $delimitador = ';';

        $cabecalho = fgetcsv($handle, 0, $delimitador);

        if (!$cabecalho) {
            fclose($handle);
            throw new \Exception('Arquivo sem dados.');
        }

        // remove BOM
        $cabecalho[0] = preg_replace('/^\xEF\xBB\xBF/', '', $cabecalho[0]);

        $errosPlanilha = $this->validarCabecalho($cabecalho);

        if (count($errosPlanilha) > 0) {
            fclose($handle);

            return [
                'registros_importados' => 0,
                'registros_erros' => [],
                'registros_importados_anteriormente' => [],
                'planilha_error' => $errosPlanilha,
                'orgaos_antes' => 0,
                'orgaos_depois' => 0,
                'configuracoes_antes' => 0,
                'configuracoes_depois' => 0
            ];
        }

        $resultado = [
            'registros_importados' => 0,
            'registros_erros' => [],
            'registros_importados_anteriormente' => [],
            'planilha_error' => [],
            'orgaos_antes' => 0,
            'orgaos_depois' => 0,
            'configuracoes_antes' => 0,
            'configuracoes_depois' => 0
        ];

        // Verificar a quantidade de orgaos antes da Importação
        $resultado['orgaos_antes'] = $this->ressarcimentoOrgaoRepository->quantidade_registros();

        // Verificar a quantidade de configuracoes antes da Importação
        $resultado['configuracoes_antes'] = $this->ressarcimentoConfiguracaoRepository->quantidade_registros();

        // Transação
        $numeroLinha = 1;

        DB::beginTransaction();

        try {
            while (($linha = fgetcsv($handle, 0, $delimitador)) !== false) {
                $numeroLinha++;

                if ($this->linhaVazia($linha)) {
                    continue;
                }

                $linha = array_pad($linha, count($cabecalho), '');

                $dadosLinha = array_combine($cabecalho, $linha);

                if (!$dadosLinha) {
                    $resultado['registros_erros'][] = 'Linha ' . $numeroLinha;
                    continue;
                }

                $registro = $this->montarRegistro($dadosLinha, $referencia);

                if (empty($registro['identidade_funcional']) || empty($registro['nome'])) {
                    $resultado['registros_erros'][] = $registro['nome'] ?: 'Linha ' . $numeroLinha;

                    continue;
                }

                $this->processarRegistro($registro, $resultado);
                $this->processarOrgao($registro);
                $this->processarConfiguracao($registro);
            }

            fclose($handle);

            DB::commit();
        } catch (\Exception $e) {
            fclose($handle);

            DB::rollBack();

            throw $e;
        }

        // Verificar a quantidade de orgaos depois da Importação
        $resultado['orgaos_depois'] = $this->ressarcimentoOrgaoRepository->quantidade_registros();

        // Verificar a quantidade de configuracoes depois da Importação
        $resultado['configuracoes_depois'] = $this->ressarcimentoConfiguracaoRepository->quantidade_registros();

        // Gravar Transação''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        // Montando Dados
        $dados = [
            'campos' => [['campo' => 'referencia','etiqueta' => 'Referência','anterior' => null,'atual' => $referencia,'anterior_view' => null,'atual_view' => $referencia,],
                    ['campo' => 'registros_importados','etiqueta' => 'Registros Importados','anterior' => null,'atual' => $resultado['registros_importados'],'anterior_view' => null,'atual_view' => $resultado['registros_importados'],],
                    ['campo' => 'registros_erros','etiqueta' => 'Registros Erros','anterior' => null,'atual' => count($resultado['registros_erros']),'anterior_view' => null,'atual_view' => count($resultado['registros_erros']),],
                    ['campo' => 'registros_importados_anteriormente','etiqueta' => 'Registros Importados Anteriormente','anterior' => null,'atual' => count($resultado['registros_importados_anteriormente']),'anterior_view' => null,'atual_view' => count($resultado['registros_importados_anteriormente']),],
                    ['campo' => 'orgaos_antes','etiqueta' => 'Órgãos Antes','anterior' => null,'atual' => $resultado['orgaos_antes'],'anterior_view' => null,'atual_view' => $resultado['orgaos_antes'],],
                    ['campo' => 'orgaos_depois','etiqueta' => 'Órgãos Depois','anterior' => null,'atual' => $resultado['orgaos_depois'],'anterior_view' => null,'atual_view' => $resultado['orgaos_depois'],],
                    ['campo' => 'configuracoes_antes','etiqueta' => 'Configurações Antes','anterior' => null,'atual' => $resultado['configuracoes_antes'],'anterior_view' => null,'atual_view' => $resultado['configuracoes_antes'],],
                    ['campo' => 'configuracoes_depois','etiqueta' => 'Configurações Depois','anterior' => null,'atual' => $resultado['configuracoes_depois'],'anterior_view' => null,'atual_view' => $resultado['configuracoes_depois'],],
                    ]
                ];

        // Gravando
        $transacaoData = [
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'user_id' => Auth::user()->id,
            'operacao_id' => 1,
            'submodulo_id' => 12,
            'dados' => $dados
        ];

        $this->transacaoRepository->create($transacaoData);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        return $resultado;
    }

    private function validarArquivo($file)
    {
        $ext = strtolower($file->getClientOriginalExtension());

        if ($ext !== 'csv') {
            throw new \Exception('Arquivo deve ser CSV.');
        }

        if ($file->getSize() > 12000000) {
            throw new \Exception('Arquivo maior que 12MB.');
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
            'ID FUNC',
            'RG',
            'NOME',
            'POSTO/GRAD',
            'QUADRO/QBM',
            'BOLETIM',
            'ID LOT',
            'LOTACAO'
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

    private function montarRegistro($linha, $referencia)
    {
        return [
            'referencia' => $referencia,
            'identidade_funcional' => trim($linha['ID FUNC']),
            'rg' => trim($linha['RG']),
            'nome' => mb_strtoupper(trim($linha['NOME']), 'UTF-8'),
            'oficial_praca' => $this->tipoMilitar($linha['POSTO/GRAD']),
            'posto_graduacao' => mb_strtoupper(trim($linha['POSTO/GRAD']), 'UTF-8'),
            'quadro_qbmp' => trim($linha['QUADRO/QBM']),
            'boletim' => trim($linha['BOLETIM']),
            'lotacao_id' => trim($linha['ID LOT']),
            'lotacao' => mb_strtoupper(trim($linha['LOTACAO']), 'UTF-8'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function processarRegistro($registro, &$resultado)
    {
        $existe = $this->repository->existe($registro['referencia'], $registro['identidade_funcional']);

        if ($existe) {
            $resultado['registros_importados_anteriormente'][] = $registro['nome'];

            return;
        }

        $this->repository->insertRegistro($registro);

        $resultado['registros_importados']++;
    }

    private function processarOrgao($registro)
    {
        $existe = $this->ressarcimentoOrgaoRepository->orgaoExiste($registro['lotacao_id']);

        if (!$existe) {
            $orgaoData = [
                'name' => mb_strtoupper($registro['lotacao'], 'UTF-8'),
                'lotacao_id' => $registro['lotacao_id'],
                'lotacao' => mb_strtoupper($registro['lotacao'], 'UTF-8'),

                'esfera_id' => 1,
                'poder_id' => 1,
                'tratamento_id' => 1,
                'vocativo_id' => 1,
                'ressarcimento_funcao_id' => 1,
                'cep' => '20735130',
                'numero' => '309'
            ];

            $this->ressarcimentoOrgaoRepository->create($orgaoData);
        }

        return;
    }

    private function processarConfiguracao($registro)
    {
        $existe = $this->ressarcimentoConfiguracaoRepository->configuracaoExiste($registro['referencia']);

        if (!$existe) {
            $ultimaConfiguracao = $this->ressarcimentoConfiguracaoRepository->ultimaConfiguracao();

            if ($ultimaConfiguracao) {
                $configuracaoData = [
                    'referencia' => $registro['referencia'],
                    'data_vencimento' => $ultimaConfiguracao->data_vencimento,
                    'diretor_identidade_funcional' => $ultimaConfiguracao->diretor_identidade_funcional,
                    'diretor_rg' => $ultimaConfiguracao->diretor_rg,
                    'diretor_nome' => $ultimaConfiguracao->diretor_nome,
                    'diretor_posto' => $ultimaConfiguracao->diretor_posto,
                    'diretor_quadro' => $ultimaConfiguracao->diretor_quadro,
                    'diretor_cargo' => $ultimaConfiguracao->diretor_cargo,
                    'dgf2_identidade_funcional' => $ultimaConfiguracao->dgf2_identidade_funcional,
                    'dgf2_rg' => $ultimaConfiguracao->dgf2_rg,
                    'dgf2_nome' => $ultimaConfiguracao->dgf2_nome,
                    'dgf2_posto' => $ultimaConfiguracao->dgf2_posto,
                    'dgf2_quadro' => $ultimaConfiguracao->dgf2_quadro,
                    'dgf2_cargo' => $ultimaConfiguracao->dgf2_cargo
                ];
            } else {
                $configuracaoData = [
                    'referencia' => $registro['referencia']
                ];
            }

            $this->ressarcimentoConfiguracaoRepository->create($configuracaoData);
        }

        return;
    }

    private function tipoMilitar($posto)
    {
        $posto = mb_strtolower(trim($posto));

        $oficiais = [
            'cel',
            'coronel',
            'ten cel',
            'tenente coronel',
            'maj',
            'major',
            'cap',
            'capitão',
            '1º ten',
            '1º tenente',
            '2º ten',
            '2º tenente'
        ];

        return in_array($posto, $oficiais) ? 1 : 2;
    }
    // Importar Militares - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    // Importar Militares - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}
