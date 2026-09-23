<?php

namespace App\Domain\RessarcimentoExclusao;

use App\Domain\Lock\LockService;

class RessarcimentoExclusaoService
{
    public function __construct(
        private RessarcimentoExclusaoRepository $repository,
        private LockService $lockService
    ) {}

    public function getRessarcimentoExclusoes($limit=null)
    {
        return $this->repository->index($limit);
    }

    public function getRessarcimentoExclusoesFilter(string $array_dados, ?int $limit=null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getUltimaReferencia()
    {
        return $this->repository->ultima_referencia();
    }

    public function getDadosRessarcimento(string $referencia)
    {
        try {
            $content = $this->repository->dados_ressarcimento($referencia);

            // Registros Órgãos
            $orgaos = $content['orgaos'];

            // Registros Militares
            $militares = $content['militares'];

            // Registros Pagamentos
            $pagamentos = $content['pagamentos'];

            // Registros Configurações
            $configuracoes = $content['configuracoes'];

            // Registros Cobrancas
            $cobrancas_dados = $content['cobrancas_dados'];

            // Registros Cobrancas PDFs Listagens
            $cobrancas_pdfs_listagens = $content['cobrancas_pdfs_listagens'];

            // Registros Cobrancas PDFs Notas
            $cobrancas_pdfs_notas = $content['cobrancas_pdfs_notas'];

            // Registros Cobrancas PDFs Ofícios
            $cobrancas_pdfs_oficios = $content['cobrancas_pdfs_oficios'];

            //Grade de Status dos Dados - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //Grade de Status dos Dados - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Array para guardar dados da grade de Status dos Dados
            $registros_grade_status_dados = array(); //colunas: Status / Detalhes

            //Variáveis de Controle''''''''
            $re_status_dados = 1;
            $re_status_dados_texto = 'Dados Ok.';
            //'''''''''''''''''''''''''''''

            //Verificar Órgãos : se existe para todos os Militares''''''''''''''''''
            //Colunas
            if ($orgaos->count() > 0) {
                $status_cor = 'success';
                $status = 'Quantidade de Órgãos Ok';
            } else {
                //Variáveis de Controle''''''''
                $re_status_dados = 0;
                $re_status_dados_texto = 'Dados Falhou.';
                //'''''''''''''''''''''''''''''

                $status_cor = 'danger';
                $status = 'Não existem registros de Órgãos';
            }

            $detalhes = '';

            //Varrer militares
            foreach ($militares as $militar) {
                $lotacao_id = $militar['lotacao_id'];
                $lotacao = $militar['lotacao'];
                $militar_nome = $militar['nome'];
                $lotacao_encontrada = false;

                foreach ($orgaos as $orgao) {
                    if ($orgao['lotacao_id'] == $lotacao_id) {
                        $lotacao_encontrada = true;
                        break;
                    }
                }

                if ($lotacao_encontrada === false) {
                    //Variáveis de Controle''''''''
                    $re_status_dados = 0;
                    $re_status_dados_texto = 'Dados Falhou.';
                    //'''''''''''''''''''''''''''''

                    //Colunas
                    $status_cor = 'danger';
                    $status = 'Existem Militares sem registro de Órgãos';
                    $detalhes .= $militar_nome.'<br>';
                }
            }

            $registros_grade_status_dados[] = [
                'status_cor' => $status_cor,
                'status' => $status,
                'detalhes' => $detalhes
            ];
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Verificar Órgãos : se existem dados incompletos'''''''''''''''''''''''
            //Colunas
            if ($orgaos->count() > 0) {
                $status_cor = 'success';
                $status = 'Dados de Órgãos completos';
            } else {
                //Variáveis de Controle''''''''
                $re_status_dados = 0;
                $re_status_dados_texto = 'Dados Falhou.';
                //'''''''''''''''''''''''''''''

                $status_cor = 'danger';
                $status = 'Não existem registros de Órgãos';
            }

            $detalhes = '';

            //Varrer militares
            foreach ($orgaos as $orgao) {
                $orgao_nome = $orgao['name'];

                if ($orgao['name'] == '' or $orgao['name'] === null
                    or $orgao['esfera_id'] == '' or $orgao['esfera_id'] === null
                    or $orgao['poder_id'] == '' or $orgao['poder_id'] === null
                    or $orgao['tratamento_id'] == '' or $orgao['tratamento_id'] === null
                    or $orgao['vocativo_id'] == '' or $orgao['vocativo_id'] === null
                    or $orgao['ressarcimento_funcao_id'] == '' or $orgao['ressarcimento_funcao_id'] === null
                    or $orgao['cep'] == '' or $orgao['cep'] === null
                    or $orgao['numero'] == '' or $orgao['numero'] === null
                    ) {
                    //Variáveis de Controle''''''''
                    $re_status_dados = 0;
                    $re_status_dados_texto = 'Dados Falhou.';
                    //'''''''''''''''''''''''''''''

                    //Colunas
                    $status_cor = 'danger';
                    $status = 'Existem registros de Órgãos incompletos';
                    $detalhes .= $orgao_nome.'<br>';
                }
            }

            $registros_grade_status_dados[] = [
                'status_cor' => $status_cor,
                'status' => $status,
                'detalhes' => $detalhes
            ];
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Verificar Militares : se existem dados incompletos''''''''''''''''''''
            //Colunas
            $status_cor = 'success';
            $status = 'Dados de Militares completos';
            $detalhes = '';

            //Varrer militares
            foreach ($militares as $militar) {
                $militar_nome = $militar['nome'];

                if ($militar['identidade_funcional'] == '' or $militar['identidade_funcional'] === null
                    or $militar['rg'] == '' or $militar['rg'] === null
                    or $militar['nome'] == '' or $militar['nome'] === null
                    or $militar['posto_graduacao'] == '' or $militar['posto_graduacao'] === null
                    or $militar['quadro_qbmp'] == '' or $militar['quadro_qbmp'] === null
                    or $militar['boletim'] == '' or $militar['boletim'] === null
                    or $militar['lotacao_id'] == '' or $militar['lotacao_id'] === null
                    or $militar['lotacao'] == '' or $militar['lotacao'] === null) {
                    //Variáveis de Controle''''''''
                    $re_status_dados = 0;
                    $re_status_dados_texto = 'Dados Falhou.';
                    //'''''''''''''''''''''''''''''

                    //Colunas
                    $status_cor = 'danger';
                    $status = 'Existem registros de Militares incompletos';
                    $detalhes .= $militar_nome.'<br>';
                }
            }

            $registros_grade_status_dados[] = [
                'status_cor' => $status_cor,
                'status' => $status,
                'detalhes' => $detalhes
            ];
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Verificar Pagamentos : se existe para todos os Militares'''''''''''
            //Colunas
            if ($pagamentos->count() > 0) {
                $status_cor = 'success';
                $status = 'Quantidade de Pagamentos Ok';
            } else {
                //Variáveis de Controle''''''''
                $re_status_dados = 0;
                $re_status_dados_texto = 'Dados Falhou.';
                //'''''''''''''''''''''''''''''

                $status_cor = 'danger';
                $status = 'Não existem registros de Pagamentos';
            }

            $detalhes = '';

            //Varrer militares
            foreach ($militares as $militar) {
                $militar_nome = $militar['nome'];
                $identidade_funcional = $militar['identidade_funcional'];
                $identidade_funcional_encontrada = false;

                foreach ($pagamentos as $pagamento) {
                    if ($pagamento['identidade_funcional'] == $identidade_funcional) {
                        $identidade_funcional_encontrada = true;
                        break;
                    }
                }

                if ($identidade_funcional_encontrada === false) {
                    //Variáveis de Controle''''''''
                    $re_status_dados = 0;
                    $re_status_dados_texto = 'Dados Falhou.';
                    //'''''''''''''''''''''''''''''

                    //Colunas
                    $status_cor = 'danger';
                    $status = 'Existem Militares sem registro de Pagamentos';
                    $detalhes .= $militar_nome.'<br>';
                }
            }

            $registros_grade_status_dados[] = [
                'status_cor' => $status_cor,
                'status' => $status,
                'detalhes' => $detalhes
            ];
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Verificar Pagamentos : se existem dados incompletos''''''''''''''''
            //Colunas
            if ($pagamentos->count() > 0) {
                $status_cor = 'success';
                $status = 'Dados de Pagamentos completos';
            } else {
                //Variáveis de Controle''''''''
                $re_status_dados = 0;
                $re_status_dados_texto = 'Dados Falhou.';
                //'''''''''''''''''''''''''''''

                $status_cor = 'danger';
                $status = 'Não existem registros de Pagamentos';
            }

            $detalhes = '';

            //Varrer Pagamentos
            foreach ($pagamentos as $pagamento) {
                $pagamento_nome = $pagamento['nome'];

                if ($pagamento['identidade_funcional'] == '' or $pagamento['identidade_funcional'] === null
                    or $pagamento['rg'] == '' or $pagamento['rg'] === null
                    or $pagamento['nome_cargo'] == '' or $pagamento['nome_cargo'] === null
                    or $pagamento['posto_graduacao'] == '' or $pagamento['posto_graduacao'] === null
                    or $pagamento['nome'] == '' or $pagamento['nome'] === null
                    or $pagamento['ua'] == '' or $pagamento['ua'] === null
                    or $pagamento['cpf'] == '' or $pagamento['cpf'] === null
                    or $pagamento['bruto'] == '' or $pagamento['bruto'] === null
                    or $pagamento['desconto'] == '' or $pagamento['desconto'] === null
                    or $pagamento['liquido'] == '' or $pagamento['liquido'] === null
                    or $pagamento['soldo'] == '' or $pagamento['soldo'] === null
                    or $pagamento['hospital10'] == '' or $pagamento['hospital10'] === null
                    or $pagamento['rioprevidencia22'] == '' or $pagamento['rioprevidencia22'] === null
                    or $pagamento['etapa_ferias'] == '' or $pagamento['etapa_ferias'] === null
                    or $pagamento['etapa_destacado'] == '' or $pagamento['etapa_destacado'] === null
                    or $pagamento['ajuda_fardamento'] == '' or $pagamento['ajuda_fardamento'] === null
                    or $pagamento['habilitacao_profissional'] == '' or $pagamento['habilitacao_profissional'] === null
                    or $pagamento['gret'] == '' or $pagamento['gret'] === null
                    or $pagamento['ferias'] == '' or $pagamento['ferias'] === null
                    or $pagamento['raio_x'] == '' or $pagamento['raio_x'] === null
                    or $pagamento['trienio'] == '' or $pagamento['trienio'] === null
                    or $pagamento['fundo_saude'] == '' or $pagamento['fundo_saude'] === null
                    or $pagamento['abono_permanencia'] == '' or $pagamento['abono_permanencia'] === null
                    or $pagamento['auxilio_transporte'] == '' or $pagamento['auxilio_transporte'] === null
                    or $pagamento['gram'] == '' or $pagamento['gram'] === null
                    or $pagamento['auxilio_fardamento'] == '' or $pagamento['auxilio_fardamento'] === null
                    or $pagamento['cidade'] == '' or $pagamento['cidade'] === null) {
                    //Variáveis de Controle''''''''
                    $re_status_dados = 0;
                    $re_status_dados_texto = 'Dados Falhou.';
                    //'''''''''''''''''''''''''''''

                    //Colunas
                    $status_cor = 'danger';
                    $status = 'Existem registros de Pagamentos incompletos';
                    $detalhes .= $pagamento_nome.'<br>';
                }
            }

            $registros_grade_status_dados[] = [
                'status_cor' => $status_cor,
                'status' => $status,
                'detalhes' => $detalhes
            ];
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Verificar Configurações : se existe para a referência'''''''''''''''''
            //Colunas
            if ($configuracoes->count() == 1) {
                $status_cor = 'success';
                $status = 'Quantidade de Configurações Ok';
            } else {
                //Variáveis de Controle''''''''
                $re_status_dados = 0;
                $re_status_dados_texto = 'Dados Falhou.';
                //'''''''''''''''''''''''''''''

                $status_cor = 'danger';
                $status = 'Não existem registros de Configurações';
            }

            $detalhes = '';

            $registros_grade_status_dados[] = [
                'status_cor' => $status_cor,
                'status' => $status,
                'detalhes' => $detalhes
            ];
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Verificar Configurações : se existem dados incompletos''''''''''''''''
            //Colunas
            if ($configuracoes->count() == 1) {
                $status_cor = 'success';
                $status = 'Dados de Configurações completos';
            } else {
                //Variáveis de Controle''''''''
                $re_status_dados = 0;
                $re_status_dados_texto = 'Dados Falhou.';
                //'''''''''''''''''''''''''''''

                $status_cor = 'danger';
                $status = 'Não existem registros de Configurações';
            }

            $detalhes = '';

            //Varrer militares
            foreach ($configuracoes as $configuracao) {
                $configuracao_referencia = getReferencia(1, $configuracao['referencia']);

                if ($configuracao['data_vencimento'] == '' or $configuracao['data_vencimento'] === null
                    or $configuracao['diretor_identidade_funcional'] == '' or $configuracao['diretor_identidade_funcional'] === null
                    or $configuracao['diretor_rg'] == '' or $configuracao['diretor_rg'] === null
                    or $configuracao['diretor_nome'] == '' or $configuracao['diretor_nome'] === null
                    or $configuracao['diretor_posto'] == '' or $configuracao['diretor_posto'] === null
                    or $configuracao['diretor_quadro'] == '' or $configuracao['diretor_quadro'] === null
                    or $configuracao['diretor_cargo'] == '' or $configuracao['diretor_cargo'] === null
                    or $configuracao['dgf2_identidade_funcional'] == '' or $configuracao['dgf2_identidade_funcional'] === null
                    or $configuracao['dgf2_rg'] == '' or $configuracao['dgf2_rg'] === null
                    or $configuracao['dgf2_nome'] == '' or $configuracao['dgf2_nome'] === null
                    or $configuracao['dgf2_posto'] == '' or $configuracao['dgf2_posto'] === null
                    or $configuracao['dgf2_quadro'] == '' or $configuracao['dgf2_quadro'] === null
                    or $configuracao['dgf2_cargo'] == '' or $configuracao['diretor_cargo'] === null) {
                    //Variáveis de Controle''''''''
                    $re_status_dados = 0;
                    $re_status_dados_texto = 'Dados Falhou.';
                    //'''''''''''''''''''''''''''''

                    //Colunas
                    $status_cor = 'danger';
                    $status = 'Existem registros de Configurações incompletos';
                    $detalhes .= $configuracao_referencia.'<br>';
                }
            }

            $registros_grade_status_dados[] = [
                'status_cor' => $status_cor,
                'status' => $status,
                'detalhes' => $detalhes
            ];
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Grade de Status dos Dados - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //Grade de Status dos Dados - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Grade de Status dos Documentos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //Grade de Status dos Documentos - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Array para guardar dados da grade de Status dos Documentos
            $registros_grade_status_documentos = array(); //colunas: Status / Detalhes

            //Variáveis de Controle''''''''
            $re_status_documentos = 1;
            $re_status_documentos_texto = 'Documentos Ok.';
            //'''''''''''''''''''''''''''''

            //Verificar Dados Cobranças : se existe para todos os Militares'''''''''
            //Colunas
            if ($militares->count() == $cobrancas_dados->count()) {
                $status_cor = 'success';
                $status = 'Quantidade de Dados Ok';
            } else {
                //Variáveis de Controle''''''''
                $re_status_documentos = 0;
                $re_status_documentos_texto = 'Documentos Falhou.';
                //'''''''''''''''''''''''''''''

                if ($cobrancas_dados->count() == 0) {
                    $status_cor = 'danger';
                    $status = 'Não existem registros de Cobrança';
                } else {
                    $status_cor = 'danger';
                    $status = 'Quantidade de registros de Cobrança';
                }
            }

            $detalhes = '';

            //Varrer militares
            foreach ($militares as $militar) {
                $identidade_funcional = $militar['identidade_funcional'];
                $militar_nome = $militar['nome'];
                $identidade_funcional_encontrada = false;

                foreach ($cobrancas_dados as $cobrancas_dado) {
                    if ($cobrancas_dado['militar_identidade_funcional'] == $identidade_funcional) {
                        $identidade_funcional_encontrada = true;
                        break;
                    }
                }

                if ($identidade_funcional_encontrada === false) {
                    //Variáveis de Controle''''''''
                    $re_status_documentos = 0;
                    $re_status_documentos_texto = 'Documentos Falhou.';
                    //'''''''''''''''''''''''''''''

                    //Colunas
                    $status_cor = 'danger';
                    $status = 'Existem Militares sem registro de Cobrança';
                    $detalhes .= $militar_nome.'<br>';
                }
            }

            $registros_grade_status_documentos[] = [
                'status_cor' => $status_cor,
                'status' => $status,
                'detalhes' => $detalhes
            ];
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Verificar Dados PDFs Listagens''''''''''''''''''''''''''''''''''''''''
            //Colunas
            if ($orgaos->count() == $cobrancas_pdfs_listagens->count()) {
                $status_cor = 'success';
                $status = 'Quantidade de Listagens Ok';
            } else {
                //Variáveis de Controle''''''''
                $re_status_documentos = 0;
                $re_status_documentos_texto = 'Documentos Falhou.';
                //'''''''''''''''''''''''''''''

                if ($cobrancas_pdfs_listagens->count() == 0) {
                    $status_cor = 'danger';
                    $status = 'Não existem registros de Listagens';
                } else {
                    $status_cor = 'danger';
                    $status = 'Quantidade de registros de Listagens';
                }
            }

            $detalhes = '';

            //Varrer Orgaos
            foreach ($orgaos as $orgao) {
                $orgao_id = $orgao['id'];
                $orgao_nome = $orgao['name'];
                $orgao_encontrado = false;

                foreach ($cobrancas_pdfs_listagens as $cobrancas_pdfs_listagem) {
                    if ($cobrancas_pdfs_listagem['ressarcimento_orgao_id'] == $orgao_id) {
                        $orgao_encontrado = true;
                        break;
                    }
                }

                if ($orgao_encontrado === false) {
                    //Variáveis de Controle''''''''
                    $re_status_documentos = 0;
                    $re_status_documentos_texto = 'Documentos Falhou.';
                    //'''''''''''''''''''''''''''''

                    //Colunas
                    $status_cor = 'danger';
                    $status = 'Existem Órgãos sem registro de Listagens';
                    $detalhes .= $orgao_nome.'<br>';
                }
            }

            $registros_grade_status_documentos[] = [
                'status_cor' => $status_cor,
                'status' => $status,
                'detalhes' => $detalhes
            ];
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Verificar Dados PDFs Notas''''''''''''''''''''''''''''''''''''''''''''
            //Colunas
            if ($orgaos->count() == $cobrancas_pdfs_notas->count()) {
                $status_cor = 'success';
                $status = 'Quantidade de Notas Ok';
            } else {
                //Variáveis de Controle''''''''
                $re_status_documentos = 0;
                $re_status_documentos_texto = 'Documentos Falhou.';
                //'''''''''''''''''''''''''''''

                if ($cobrancas_pdfs_notas->count() == 0) {
                    $status_cor = 'danger';
                    $status = 'Não existem registros de Notas';
                } else {
                    $status_cor = 'danger';
                    $status = 'Quantidade de registros de Notas';
                }
            }

            $detalhes = '';

            //Varrer Orgaos
            foreach ($orgaos as $orgao) {
                $orgao_id = $orgao['id'];
                $orgao_nome = $orgao['name'];
                $orgao_encontrado = false;

                foreach ($cobrancas_pdfs_notas as $cobrancas_pdfs_nota) {
                    if ($cobrancas_pdfs_nota['ressarcimento_orgao_id'] == $orgao_id) {
                        $orgao_encontrado = true;
                        break;
                    }
                }

                if ($orgao_encontrado === false) {
                    //Variáveis de Controle''''''''
                    $re_status_documentos = 0;
                    $re_status_documentos_texto = 'Documentos Falhou.';
                    //'''''''''''''''''''''''''''''

                    //Colunas
                    $status_cor = 'danger';
                    $status = 'Existem Órgãos sem registro de Notas';
                    $detalhes .= $orgao_nome.'<br>';
                }
            }

            $registros_grade_status_documentos[] = [
                'status_cor' => $status_cor,
                'status' => $status,
                'detalhes' => $detalhes
            ];
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Verificar Dados PDFs Oficios''''''''''''''''''''''''''''''''''''''''''
            //Colunas
            if ($orgaos->count() == $cobrancas_pdfs_oficios->count()) {
                $status_cor = 'success';
                $status = 'Quantidade de Ofícios Ok';
            } else {
                //Variáveis de Controle''''''''
                $re_status_documentos = 0;
                $re_status_documentos_texto = 'Documentos Falhou.';
                //'''''''''''''''''''''''''''''

                if ($cobrancas_pdfs_oficios->count() == 0) {
                    $status_cor = 'danger';
                    $status = 'Não existem registros de Ofícios';
                } else {
                    $status_cor = 'danger';
                    $status = 'Quantidade de registros de Ofícios';
                }
            }

            $detalhes = '';

            //Varrer Orgaos
            foreach ($orgaos as $orgao) {
                $orgao_id = $orgao['id'];
                $orgao_nome = $orgao['name'];
                $orgao_encontrado = false;

                foreach ($cobrancas_pdfs_oficios as $cobrancas_pdfs_oficio) {
                    if ($cobrancas_pdfs_oficio['ressarcimento_orgao_id'] == $orgao_id) {
                        $orgao_encontrado = true;
                        break;
                    }
                }

                if ($orgao_encontrado === false) {
                    //Variáveis de Controle''''''''
                    $re_status_documentos = 0;
                    $re_status_documentos_texto = 'Documentos Falhou.';
                    //'''''''''''''''''''''''''''''

                    //Colunas
                    $status_cor = 'danger';
                    $status = 'Existem Órgãos sem registro de Ofícios';
                    $detalhes .= $orgao_nome.'<br>';
                }
            }

            $registros_grade_status_documentos[] = [
                'status_cor' => $status_cor,
                'status' => $status,
                'detalhes' => $detalhes
            ];
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Grade de Status dos Documentos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //Grade de Status dos Documentos - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Html''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $retorno = array();

            $retorno['re_referencia'] = getReferencia(1, $referencia);
            $retorno['re_orgaos'] = $orgaos;
            $retorno['re_configuracoes'] = $configuracoes;
            $retorno['re_quantidade_orgaos'] = $orgaos->count();
            $retorno['re_quantidade_militares'] = $militares->count();
            $retorno['re_quantidade_pagamentos'] = $pagamentos->count();
            $retorno['re_quantidade_configuracoes'] = $configuracoes->count();
            $retorno['re_quantidade_cobranca'] = $cobrancas_dados->count();
            $retorno['re_quantidade_listagens'] = $cobrancas_pdfs_listagens->count();
            $retorno['re_quantidade_notas'] = $cobrancas_pdfs_notas->count();
            $retorno['re_quantidade_oficios'] = $cobrancas_pdfs_oficios->count();
            $retorno['re_status_dados'] = $re_status_dados;
            $retorno['re_status_dados_texto'] = $re_status_dados_texto;
            $retorno['re_registros_grade_status_dados'] = $registros_grade_status_dados;
            $retorno['re_status_documentos'] = $re_status_documentos;
            $retorno['re_status_documentos_texto'] = $re_status_documentos_texto;
            $retorno['re_registros_grade_status_documentos'] = $registros_grade_status_documentos;
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            return $retorno;
        } catch (\Exception $e) {
            throw new \Exception('Erro ao processar', 0, $e);
        }
    }

    public function deletar_cobranca(string $referencia)
    {
        try {
            // Array de retorno
            $content = array();

            // Apagando dados de Cobrança caso tenha e refazer
            $this->repository->deletar_cobranca($referencia);

            // Array para guardar o passo-a-passo da operação de Gerar Cobrança para gravar no Log de Transações'''''''''''''
            $arrayTransacoes = array();
            $arrayTransacoes['apagar_cobranca'] = 'Apagado Cobrança para a referência.';
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // retorno
            $content['transacoes'] = $arrayTransacoes;

            return $content;
        } catch (\Exception $e) {
            throw new \Exception('Erro ao processar', 0, $e);
        }
    }
}
