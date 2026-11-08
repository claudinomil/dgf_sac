<?php

namespace App\Domain\DashboardTv;

use Illuminate\Support\Facades\DB;

class DashboardTvRepository
{
    /*
     * Situações permitidas para o Dashboard TV (TODAS)
     * 1    :   ATIVO
     * 2    :   INATIVO
     * 3    :   EXCLUÍDO
     * 4    :   FALECIDO
     * 5    :   PENSIONISTA
     * 6    :   LICENCIADO
     * 7    :   INATIVO CIVIL
     * 8    :   DEMITIDO
     * 9    :   EXTRAVIADO
     * 10   :   ATIVO - DECISÃO JUDICIAL
     * 11   :   REFORMADO ART. 105 I
     * 12   :   PENSIONISTA PROVISÓRIO
     * 13   :   PENSIONISTA ESPECIAL
     * 14   :   PENSIONISTA RIOPREVIDÊNCIA
     * 15   :   RESERVA REMUNERADA A PEDIDO
     * 16   :   REFORMADO
     * 17   :   RESERVA REMUNERADA
     * 18   :   RESERVA REMUNERADA EX-OFFÍCIO
     * 19   :   DESERTOR
     * 20   :   LICENCIAMENTO A PEDIDO
     * 21   :   EXCLUSÃO INCAP. MORAL OU A BEM DA DISCIPLINA
     * 22   :   LICENCIAMENTO EX-OFFÍCIO
     * 23   :   EXCLUSÃO EX-OFFÍCIO
     * 24   :   DEMISSÃO A PEDIDO
     * 25   :   DEMISSÃO EX-OFFÍCIO
     * 26   :   PERDA DO POSTO E DA PATENTE
     * 27   :   EXCLUSÃO DO SERVIÇO ATIVO
     * 28   :   RESERVA NÃO REMUNERADA
     * 29   :   ANULAÇÃO DE INCORPORAÇÃO DE PRAÇA
     * 30   :   EX-MILITAR DO CBMERJ
     * 31   :   MATRÍCULA TRANCADA - CFO
     * 32   :   ATUALIZAR
     * 33   :   EXCLUSÃO POR DESERÇÃO
     */
    private array $situacoes_ids_todas = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33];

    /*
     * Situações permitidas para o Dashboard TV (ATIVOS E INATIVOS)
     * 1    :   ATIVO
     * 2    :   INATIVO
     * 3    :   EXCLUÍDO                                            (NÃO)
     * 4    :   FALECIDO                                            (NÃO)
     * 5    :   PENSIONISTA                                         (NÃO)
     * 6    :   LICENCIADO
     * 7    :   INATIVO CIVIL                                       (NÃO)
     * 8    :   DEMITIDO                                            (NÃO)
     * 9    :   EXTRAVIADO
     * 10   :   ATIVO - DECISÃO JUDICIAL
     * 11   :   REFORMADO ART. 105 I
     * 12   :   PENSIONISTA PROVISÓRIO                              (NÃO)
     * 13   :   PENSIONISTA ESPECIAL                                (NÃO)
     * 14   :   PENSIONISTA RIOPREVIDÊNCIA                          (NÃO)
     * 15   :   RESERVA REMUNERADA A PEDIDO
     * 16   :   REFORMADO
     * 17   :   RESERVA REMUNERADA
     * 18   :   RESERVA REMUNERADA EX-OFFÍCIO
     * 19   :   DESERTOR                                            (NÃO)
     * 20   :   LICENCIAMENTO A PEDIDO
     * 21   :   EXCLUSÃO INCAP. MORAL OU A BEM DA DISCIPLINA        (NÃO)
     * 22   :   LICENCIAMENTO EX-OFFÍCIO
     * 23   :   EXCLUSÃO EX-OFFÍCIO                                 (NÃO)
     * 24   :   DEMISSÃO A PEDIDO                                   (NÃO)
     * 25   :   DEMISSÃO EX-OFFÍCIO                                 (NÃO)
     * 26   :   PERDA DO POSTO E DA PATENTE                         (NÃO)
     * 27   :   EXCLUSÃO DO SERVIÇO ATIVO                           (NÃO)
     * 28   :   RESERVA NÃO REMUNERADA
     * 29   :   ANULAÇÃO DE INCORPORAÇÃO DE PRAÇA                   (NÃO)
     * 30   :   EX-MILITAR DO CBMERJ                                (NÃO)
     * 31   :   MATRÍCULA TRANCADA - CFO                            (NÃO)
     * 32   :   ATUALIZAR                                           (NÃO)
     * 33   :   EXCLUSÃO POR DESERÇÃO                               (NÃO)
     */
    private array $situacoes_ids_ativos_inativos = [1,2,6,9,10,11,15,16,17,18,20,22,28];

    /*
     * Situações permitidas para o Dashboard TV (ATIVOS)
     * 1    :   ATIVO
     * 2    :   INATIVO                                             (NÃO)
     * 3    :   EXCLUÍDO                                            (NÃO)
     * 4    :   FALECIDO                                            (NÃO)
     * 5    :   PENSIONISTA                                         (NÃO)
     * 6    :   LICENCIADO                                          (NÃO)
     * 7    :   INATIVO CIVIL                                       (NÃO)
     * 8    :   DEMITIDO                                            (NÃO)
     * 9    :   EXTRAVIADO                                          (NÃO)
     * 10   :   ATIVO - DECISÃO JUDICIAL
     * 11   :   REFORMADO ART. 105 I                                (NÃO)
     * 12   :   PENSIONISTA PROVISÓRIO                              (NÃO)
     * 13   :   PENSIONISTA ESPECIAL                                (NÃO)
     * 14   :   PENSIONISTA RIOPREVIDÊNCIA                          (NÃO)
     * 15   :   RESERVA REMUNERADA A PEDIDO                         (NÃO)
     * 16   :   REFORMADO                                           (NÃO)
     * 17   :   RESERVA REMUNERADA                                  (NÃO)
     * 18   :   RESERVA REMUNERADA EX-OFFÍCIO                       (NÃO)
     * 19   :   DESERTOR                                            (NÃO)
     * 20   :   LICENCIAMENTO A PEDIDO                              (NÃO)
     * 21   :   EXCLUSÃO INCAP. MORAL OU A BEM DA DISCIPLINA        (NÃO)
     * 22   :   LICENCIAMENTO EX-OFFÍCIO                            (NÃO)
     * 23   :   EXCLUSÃO EX-OFFÍCIO                                 (NÃO)
     * 24   :   DEMISSÃO A PEDIDO                                   (NÃO)
     * 25   :   DEMISSÃO EX-OFFÍCIO                                 (NÃO)
     * 26   :   PERDA DO POSTO E DA PATENTE                         (NÃO)
     * 27   :   EXCLUSÃO DO SERVIÇO ATIVO                           (NÃO)
     * 28   :   RESERVA NÃO REMUNERADA                              (NÃO)
     * 29   :   ANULAÇÃO DE INCORPORAÇÃO DE PRAÇA                   (NÃO)
     * 30   :   EX-MILITAR DO CBMERJ                                (NÃO)
     * 31   :   MATRÍCULA TRANCADA - CFO                            (NÃO)
     * 32   :   ATUALIZAR                                           (NÃO)
     * 33   :   EXCLUSÃO POR DESERÇÃO                               (NÃO)
     */
    private array $situacoes_ids_ativos = [1,10];

    /*
     * Situações permitidas para o Dashboard TV (INATIVOS)
     * 1    :   ATIVO                                               (NÃO)
     * 2    :   INATIVO
     * 3    :   EXCLUÍDO                                            (NÃO)
     * 4    :   FALECIDO                                            (NÃO)
     * 5    :   PENSIONISTA                                         (NÃO)
     * 6    :   LICENCIADO
     * 7    :   INATIVO CIVIL                                       (NÃO)
     * 8    :   DEMITIDO                                            (NÃO)
     * 9    :   EXTRAVIADO
     * 10   :   ATIVO - DECISÃO JUDICIAL                            (NÃO)
     * 11   :   REFORMADO ART. 105 I
     * 12   :   PENSIONISTA PROVISÓRIO                              (NÃO)
     * 13   :   PENSIONISTA ESPECIAL                                (NÃO)
     * 14   :   PENSIONISTA RIOPREVIDÊNCIA                          (NÃO)
     * 15   :   RESERVA REMUNERADA A PEDIDO
     * 16   :   REFORMADO
     * 17   :   RESERVA REMUNERADA
     * 18   :   RESERVA REMUNERADA EX-OFFÍCIO
     * 19   :   DESERTOR                                            (NÃO)
     * 20   :   LICENCIAMENTO A PEDIDO
     * 21   :   EXCLUSÃO INCAP. MORAL OU A BEM DA DISCIPLINA        (NÃO)
     * 22   :   LICENCIAMENTO EX-OFFÍCIO
     * 23   :   EXCLUSÃO EX-OFFÍCIO                                 (NÃO)
     * 24   :   DEMISSÃO A PEDIDO                                   (NÃO)
     * 25   :   DEMISSÃO EX-OFFÍCIO                                 (NÃO)
     * 26   :   PERDA DO POSTO E DA PATENTE                         (NÃO)
     * 27   :   EXCLUSÃO DO SERVIÇO ATIVO                           (NÃO)
     * 28   :   RESERVA NÃO REMUNERADA
     * 29   :   ANULAÇÃO DE INCORPORAÇÃO DE PRAÇA                   (NÃO)
     * 30   :   EX-MILITAR DO CBMERJ                                (NÃO)
     * 31   :   MATRÍCULA TRANCADA - CFO                            (NÃO)
     * 32   :   ATUALIZAR                                           (NÃO)
     * 33   :   EXCLUSÃO POR DESERÇÃO                               (NÃO)
     */
    private array $situacoes_ids_inativos = [2,6,9,11,15,16,17,18,20,22,28];

    /*
     * Graduações permitidas para o Dashboard TV (TODAS)
     * 1    :   NATUREZA CIVIL
     * 2    :   CORONEL
     * 3    :   TENENTE CORONEL
     * 4    :   MAJOR
     * 5    :   CAPITÃO
     * 6    :   1º TENENTE
     * 7    :   2º TENENTE
     * 8    :   ASPIRANTE
     * 9    :   CADETE DO 3º ANO
     * 10   :   CADETE DO 2º ANO
     * 11   :   CADETE DO 1º ANO
     * 12   :   SUBTENENTE
     * 13   :   1º SARGENTO
     * 14   :   2º SARGENTO
     * 15   :   3º SARGENTO
     * 16   :   CABO
     * 17   :   SOLDADO
     * 18   :   SOLDADO RECRUTA
     * 19   :   PENSIONISTA
     */
    private array $graduacoes_ids_todas = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19];

    /*
     * Graduações permitidas para o Dashboard TV (OFICIAIS)
     * 1    :   NATUREZA CIVIL                                      (NÃO)
     * 2    :   CORONEL
     * 3    :   TENENTE CORONEL
     * 4    :   MAJOR
     * 5    :   CAPITÃO
     * 6    :   1º TENENTE
     * 7    :   2º TENENTE
     * 8    :   ASPIRANTE                                           (NÃO)
     * 9    :   CADETE DO 3º ANO                                    (NÃO)
     * 10   :   CADETE DO 2º ANO                                    (NÃO)
     * 11   :   CADETE DO 1º ANO                                    (NÃO)
     * 12   :   SUBTENENTE
     * 13   :   1º SARGENTO
     * 14   :   2º SARGENTO
     * 15   :   3º SARGENTO
     * 16   :   CABO
     * 17   :   SOLDADO
     * 18   :   SOLDADO RECRUTA                                     (NÃO)
     * 19   :   PENSIONISTA                                         (NÃO)
     */
    private array $graduacoes_ids_oficiais_pracas = [2,3,4,5,6,7,12,13,14,15,16,17];

    /*
     * Graduações permitidas para o Dashboard TV (OFICIAIS)
     * 1    :   NATUREZA CIVIL                                      (NÃO)
     * 2    :   CORONEL
     * 3    :   TENENTE CORONEL
     * 4    :   MAJOR
     * 5    :   CAPITÃO
     * 6    :   1º TENENTE
     * 7    :   2º TENENTE
     * 8    :   ASPIRANTE                                           (NÃO)
     * 9    :   CADETE DO 3º ANO                                    (NÃO)
     * 10   :   CADETE DO 2º ANO                                    (NÃO)
     * 11   :   CADETE DO 1º ANO                                    (NÃO)
     * 12   :   SUBTENENTE                                          (NÃO)
     * 13   :   1º SARGENTO                                         (NÃO)
     * 14   :   2º SARGENTO                                         (NÃO)
     * 15   :   3º SARGENTO                                         (NÃO)
     * 16   :   CABO                                                (NÃO)
     * 17   :   SOLDADO                                             (NÃO)
     * 18   :   SOLDADO RECRUTA                                     (NÃO)
     * 19   :   PENSIONISTA                                         (NÃO)
     */
    private array $graduacoes_ids_oficiais = [2,3,4,5,6,7];

    /*
     * Graduações permitidas para o Dashboard TV (PRAÇAS)
     * 1    :   NATUREZA CIVIL                                      (NÃO)
     * 2    :   CORONEL                                             (NÃO)
     * 3    :   TENENTE CORONEL                                     (NÃO)
     * 4    :   MAJOR                                               (NÃO)
     * 5    :   CAPITÃO                                             (NÃO)
     * 6    :   1º TENENTE                                          (NÃO)
     * 7    :   2º TENENTE                                          (NÃO)
     * 8    :   ASPIRANTE                                           (NÃO)
     * 9    :   CADETE DO 3º ANO                                    (NÃO)
     * 10   :   CADETE DO 2º ANO                                    (NÃO)
     * 11   :   CADETE DO 1º ANO                                    (NÃO)
     * 12   :   SUBTENENTE
     * 13   :   1º SARGENTO
     * 14   :   2º SARGENTO
     * 15   :   3º SARGENTO
     * 16   :   CABO
     * 17   :   SOLDADO
     * 18   :   SOLDADO RECRUTA                                     (NÃO)
     * 19   :   PENSIONISTA                                         (NÃO)
     */
    private array $graduacoes_ids_pracas = [12,13,14,15,16,17];

    /**
     * Consultar indicadores e gráficos habilitados no Dashboard TV.
     */
    public function indicadores_graficos()
    {
        // Buscar configuração do Dashboard
        $controle = DB::table('dashboards_tvs_controles')
            ->where('id', 1)
            ->first();

        if (!$controle) {
            return [
                'unidade_id' => null,
                'unidade_nome' => null,
                'ano' => null,
                'indicadores' => collect(),
                'graficos' => collect(),
            ];
        }

        // Identificar indicadores habilitados
        $identificadores_indicadores = collect((array) $controle)
            ->filter(function ($valor, $campo) {
                return preg_match('/^indicador_\d+$/', $campo) && (int) $valor === 1;
            })
            ->keys()
            ->values();

        // Buscar indicadores
        $resultado_indicadores = DB::table('dashboards_tvs_indicadores_graficos')
            ->whereIn('identificador', $identificadores_indicadores)
            ->orderBy('ordem')
            ->get();

        // Identificar gaficos habilitados
        $identificadores_graficos = collect((array) $controle)
            ->filter(function ($valor, $campo) {
                return preg_match('/^grafico_\d+$/', $campo) && (int) $valor === 1;
            })
            ->keys()
            ->values();

        // Buscar graficos
        $resultado_graficos = DB::table('dashboards_tvs_indicadores_graficos')
            ->whereIn('identificador', $identificadores_graficos)
            ->orderBy('ordem')
            ->get();

        // Unidade configurada para o Dashboard
        $unidadeId = $controle->unidade_id ? (int) $controle->unidade_id : null;

        // Buscar nome da unidade
        $unidadeNome = $unidadeId ? DB::table('unidades')->where('id', $unidadeId)->value('name') : null;

        // Ano configurado para o Dashboard
        $ano = $controle->ano ? (int) $controle->ano : null;

        // Adicionar dados dos indicadores
        $indicadores = $resultado_indicadores->map(function ($item) use ($unidadeId, $ano) {
            $item->dados_grafico = $this->buscarDadosGrafico($item->identificador, $unidadeId, $ano);

            return $item;
        });

        // Adicionar dados dos graficos
        $graficos = $resultado_graficos->map(function ($item) use ($unidadeId, $ano) {
            $item->dados_grafico = $this->buscarDadosGrafico($item->identificador, $unidadeId, $ano);

            return $item;
        });

        // Retornar dados
        return [
            'unidade_id' => $unidadeId,
            'unidade_nome' => primeiraMaiuscula($unidadeNome),
            'ano' => $ano,
            'indicadores' => $indicadores,
            'graficos' => $graficos,
        ];
    }

    /**
     * Direcionar para a consulta correspondente.
     */
    private function buscarDadosGrafico(string $identificador, ?int $unidadeId = null, ?int $ano = null): array
    {
        return match ($identificador) {
            'indicador_1' => $this->dadosTotalMilitares($unidadeId),
            'indicador_2' => $this->dadosTotalMilitaresAtivos($unidadeId),
            'indicador_3' => $this->dadosTotalMilitaresInativos($unidadeId),
            'indicador_4' => $this->dadosTotalMilitaresOficiais($unidadeId),
            'indicador_5' => $this->dadosTotalMilitaresPracas($unidadeId),
            'indicador_6' => $this->dadosTotalMilitaresAjudasCustos($unidadeId, $ano),
            'indicador_7' => $this->dadosTotalMilitaresAuxiliosFardamentos($unidadeId, $ano),
            'indicador_8' => $this->dadosTotalMilitaresCursos($unidadeId, $ano),
            'indicador_9' => $this->dadosTotalMilitaresDependentes($unidadeId, $ano),
            'indicador_10' => $this->dadosTotalMilitaresFerias($unidadeId, $ano),
            'indicador_11' => $this->dadosTotalMilitaresPensoes($unidadeId, $ano),
            'indicador_12' => $this->dadosTotalMilitaresTemposAverbados($unidadeId, $ano),

            'grafico_1' => $this->dadosGraficoMilitaresPorSituacao($unidadeId),
            'grafico_2' => $this->dadosGraficoMilitaresPorGraduacao($unidadeId),
            'grafico_3' => $this->dadosGraficoMilitaresPorComportamento($unidadeId),

            default => []
        };
    }

    /**
     * Indicador 1 - TOTAL DE MILITARES
     */
    private function dadosTotalMilitares(?int $unidadeId = null): array
    {
        $query = DB::table('militares')
            ->where('militares.excluido', 0)
            ->whereIn('militares.situacao_id', $this->situacoes_ids_ativos_inativos)
            ->whereIn('militares.graduacao_id', $this->graduacoes_ids_oficiais_pracas)
            ->selectRaw("'Total de Militares' as name, COUNT(militares.id) as value");

        if ($unidadeId) {
            $query->where('militares.unidade_id', $unidadeId);
        }

        return $this->formatarDadosGrafico($query->get());
    }

    /**
     * Indicador 2 - TOTAL DE MILITARES ATIVOS
     */
    private function dadosTotalMilitaresAtivos(?int $unidadeId = null): array
    {
        $query = DB::table('militares')
            ->where('militares.excluido', 0)
            ->whereIn('militares.situacao_id', $this->situacoes_ids_ativos)
            ->whereIn('militares.graduacao_id', $this->graduacoes_ids_oficiais_pracas)
            ->selectRaw("'Total de Militares' as name, COUNT(militares.id) as value");

        if ($unidadeId) {
            $query->where('militares.unidade_id', $unidadeId);
        }

        return $this->formatarDadosGrafico($query->get());
    }

    /**
     * Indicador 3 - TOTAL DE MILITARES INATIVOS
     */
    private function dadosTotalMilitaresInativos(?int $unidadeId = null): array
    {
        $query = DB::table('militares')
            ->where('militares.excluido', 0)
            ->whereIn('militares.situacao_id', $this->situacoes_ids_inativos)
            ->whereIn('militares.graduacao_id', $this->graduacoes_ids_oficiais_pracas)
            ->selectRaw("'Total de Militares' as name, COUNT(militares.id) as value");

        if ($unidadeId) {
            $query->where('militares.unidade_id', $unidadeId);
        }

        return $this->formatarDadosGrafico($query->get());
    }

    /**
     * Indicador 4 - TOTAL DE MILITARES OFICIAIS
     */
    private function dadosTotalMilitaresOficiais(?int $unidadeId = null): array
    {
        $query = DB::table('militares')
            ->where('militares.excluido', 0)
            ->whereIn('militares.situacao_id', $this->situacoes_ids_ativos_inativos)
            ->whereIn('militares.graduacao_id', $this->graduacoes_ids_oficiais)
            ->selectRaw("'Total de Militares' as name, COUNT(militares.id) as value");

        if ($unidadeId) {
            $query->where('militares.unidade_id', $unidadeId);
        }

        return $this->formatarDadosGrafico($query->get());
    }

    /**
     * Indicador 5 - TOTAL DE MILITARES PRAÇAS
     */
    private function dadosTotalMilitaresPracas(?int $unidadeId = null): array
    {
        $query = DB::table('militares')
            ->where('militares.excluido', 0)
            ->whereIn('militares.situacao_id', $this->situacoes_ids_ativos_inativos)
            ->whereIn('militares.graduacao_id', $this->graduacoes_ids_pracas)
            ->selectRaw("'Total de Militares' as name, COUNT(militares.id) as value");

        if ($unidadeId) {
            $query->where('militares.unidade_id', $unidadeId);
        }

        return $this->formatarDadosGrafico($query->get());
    }

    /**
     * Indicador 6 - TOTAL DE AJUDAS DE CUSTOS
     */
    private function dadosTotalMilitaresAjudasCustos(?int $unidadeId = null, ?int $ano = null): array
    {
        $query = DB::table('militares_ajudas_custos')
            ->join('militares', 'militares.id', '=', 'militares_ajudas_custos.militar_id')
            ->where('militares_ajudas_custos.excluido', 0)
            ->where('militares.excluido', 0)
            ->whereIn('militares.situacao_id', $this->situacoes_ids_ativos_inativos)
            ->whereIn('militares.graduacao_id', $this->graduacoes_ids_oficiais_pracas)
            ->selectRaw("'Total de Militares' as name, COUNT(militares.id) as value");

        if ($unidadeId) {
            $query->where('militares.unidade_id', $unidadeId);
        }

        if ($ano) {
            $query->where('militares_ajudas_custos.pagamento', 'LIKE', '%'.$ano);
        }

        return $this->formatarDadosGrafico($query->get());
    }

    /**
     * Indicador 7 - TOTAL DE AUXÍLIOS FARDAMENTOS
     */
    private function dadosTotalMilitaresAuxiliosFardamentos(?int $unidadeId = null, ?int $ano = null): array
    {
        $query = DB::table('militares_auxilios_fardamentos')
            ->join('militares', 'militares.id', '=', 'militares_auxilios_fardamentos.militar_id')
            ->where('militares_auxilios_fardamentos.excluido', 0)
            ->where('militares.excluido', 0)
            ->whereIn('militares.situacao_id', $this->situacoes_ids_ativos_inativos)
            ->whereIn('militares.graduacao_id', $this->graduacoes_ids_oficiais_pracas)
            ->selectRaw("'Total de Militares' as name, COUNT(militares.id) as value");

        if ($unidadeId) {
            $query->where('militares.unidade_id', $unidadeId);
        }

        if ($ano) {
            $query->where('militares_auxilios_fardamentos.pagamento', 'LIKE', '%'.$ano);
        }

        return $this->formatarDadosGrafico($query->get());
    }

    /**
     * Indicador 8 - TOTAL DE CURSOS
     */
    private function dadosTotalMilitaresCursos(?int $unidadeId = null, ?int $ano = null): array
    {
        $query = DB::table('militares_cursos')
            ->join('militares', 'militares.id', '=', 'militares_cursos.militar_id')
            ->where('militares_cursos.excluido', 0)
            ->where('militares.excluido', 0)
            ->whereIn('militares.situacao_id', $this->situacoes_ids_ativos_inativos)
            ->whereIn('militares.graduacao_id', $this->graduacoes_ids_oficiais_pracas)
            ->selectRaw("'Total de Militares' as name, COUNT(militares.id) as value");

        if ($unidadeId) {
            $query->where('militares.unidade_id', $unidadeId);
        }

        if ($ano) {
            $query->where('militares_cursos.data_termino', 'LIKE', $ano.'%');
        }

        return $this->formatarDadosGrafico($query->get());
    }

    /**
     * Indicador 9 - TOTAL DE DEPENDENTES
     */
    private function dadosTotalMilitaresDependentes(?int $unidadeId = null, ?int $ano = null): array
    {
        $query = DB::table('militares_dependentes')
            ->join('militares', 'militares.id', '=', 'militares_dependentes.militar_id')
            ->where('militares_dependentes.excluido', 0)
            ->where('militares.excluido', 0)
            ->whereIn('militares.situacao_id', $this->situacoes_ids_ativos_inativos)
            ->whereIn('militares.graduacao_id', $this->graduacoes_ids_oficiais_pracas)
            ->selectRaw("'Total de Militares' as name, COUNT(militares.id) as value");

        if ($unidadeId) {
            $query->where('militares.unidade_id', $unidadeId);
        }

        if ($ano) {
            $query->where('militares_dependentes.data_requerimento', 'LIKE', $ano.'%');
        }

        return $this->formatarDadosGrafico($query->get());
    }

    /**
     * Indicador 10 - TOTAL DE FÉRIAS
     */
    private function dadosTotalMilitaresFerias(?int $unidadeId = null, ?int $ano = null): array
    {
        $query = DB::table('militares_ferias')
            ->join('militares', 'militares.id', '=', 'militares_ferias.militar_id')
            ->where('militares_ferias.excluido', 0)
            ->where('militares.excluido', 0)
            ->whereIn('militares.situacao_id', $this->situacoes_ids_ativos_inativos)
            ->whereIn('militares.graduacao_id', $this->graduacoes_ids_oficiais_pracas)
            ->selectRaw("'Total de Militares' as name, COUNT(militares.id) as value");

        if ($unidadeId) {
            $query->where('militares.unidade_id', $unidadeId);
        }

        if ($ano) {
            $query->where('militares_ferias.ano', 'LIKE', '%'.$ano);
        }

        return $this->formatarDadosGrafico($query->get());
    }

    /**
     * Indicador 11 - TOTAL DE PENSÕES
     */
    private function dadosTotalMilitaresPensoes(?int $unidadeId = null, ?int $ano = null): array
    {
        $query = DB::table('militares_pensoes')
            ->join('militares', 'militares.id', '=', 'militares_pensoes.militar_id')
            ->where('militares_pensoes.excluido', 0)
            ->where('militares.excluido', 0)
            ->whereIn('militares.situacao_id', $this->situacoes_ids_ativos_inativos)
            ->whereIn('militares.graduacao_id', $this->graduacoes_ids_oficiais_pracas)
            ->selectRaw("'Total de Militares' as name, COUNT(militares.id) as value");

        if ($unidadeId) {
            $query->where('militares.unidade_id', $unidadeId);
        }

        return $this->formatarDadosGrafico($query->get());
    }

    /**
     * Indicador 12 - TOTAL DE TEMPOS AVERBADOS
     */
    private function dadosTotalMilitaresTemposAverbados(?int $unidadeId = null, ?int $ano = null): array
    {
        $query = DB::table('militares_tempos_averbados')
            ->join('militares', 'militares.id', '=', 'militares_tempos_averbados.militar_id')
            ->where('militares_tempos_averbados.excluido', 0)
            ->where('militares.excluido', 0)
            ->whereIn('militares.situacao_id', $this->situacoes_ids_ativos_inativos)
            ->whereIn('militares.graduacao_id', $this->graduacoes_ids_oficiais_pracas)
            ->selectRaw("'Total de Militares' as name, COUNT(militares.id) as value");

        if ($unidadeId) {
            $query->where('militares.unidade_id', $unidadeId);
        }

        return $this->formatarDadosGrafico($query->get());
    }

    /**
     * Gráfico 1 - MILITARES POR SITUAÇÕES
     */
    private function dadosGraficoMilitaresPorSituacao(?int $unidadeId = null): array
    {
        $query = DB::table('militares')
            ->join('situacoes', 'situacoes.id', '=', 'militares.situacao_id')
            ->where('militares.excluido', 0)
            ->where('situacoes.excluido', 0)
            ->whereIn('militares.situacao_id', $this->situacoes_ids_ativos_inativos)
            ->whereIn('militares.graduacao_id', $this->graduacoes_ids_oficiais_pracas)
            ->selectRaw("CASE WHEN militares.situacao_id IN (" . implode(',', $this->situacoes_ids_ativos) . ")
                        THEN 'Ativos' ELSE 'Inativos' END as name, COUNT(militares.id) as value
            ")
            ->groupByRaw("CASE WHEN militares.situacao_id IN (" . implode(',', $this->situacoes_ids_ativos) . ")
                        THEN 'Ativos' ELSE 'Inativos' END
            ");

        if ($unidadeId) {
            $query->where('militares.unidade_id', $unidadeId);
        }

        return $this->formatarDadosGrafico($query->get());
    }

    /**
     * Gráfico 2 - MILITARES POR GRADUAÇÕES
     */
    private function dadosGraficoMilitaresPorGraduacao(?int $unidadeId = null): array
    {
        $query = DB::table('militares')
            ->join('graduacoes', 'graduacoes.id', '=', 'militares.graduacao_id')
            ->where('militares.excluido', 0)
            ->where('graduacoes.excluido', 0)
            ->whereIn('militares.situacao_id', $this->situacoes_ids_ativos_inativos)
            ->whereIn('militares.graduacao_id', $this->graduacoes_ids_oficiais_pracas)
            ->selectRaw('graduacoes.abreviacao as name, COUNT(militares.id) as value')
            ->groupBy('graduacoes.id', 'graduacoes.name')
            ->orderBy('graduacoes.id');

        if ($unidadeId) {
            $query->where('militares.unidade_id', $unidadeId);
        }

        return $this->formatarDadosGrafico($query->get());
    }

    /**
     * Gráfico 3 - MILITARES POR COMPORTAMENTOS
     */
    private function dadosGraficoMilitaresPorComportamento(?int $unidadeId = null): array
    {
        $query = DB::table('militares')
            ->join('comportamentos', 'comportamentos.id', '=', 'militares.comportamento_id')
            ->where('militares.excluido', 0)
            ->where('comportamentos.excluido', 0)
            ->whereIn('militares.situacao_id', $this->situacoes_ids_ativos_inativos)
            ->whereIn('militares.graduacao_id', $this->graduacoes_ids_oficiais_pracas)
            ->selectRaw('comportamentos.name as name, COUNT(militares.id) as value')
            ->groupBy('comportamentos.id', 'comportamentos.name')
            ->orderBy('comportamentos.id');

        if ($unidadeId) {
            $query->where('militares.unidade_id', $unidadeId);
        }

        return $this->formatarDadosGrafico($query->get());
    }

    /**
     * Formatar dados para utilização no ECharts.
     */
    private function formatarDadosGrafico($dados): array
    {
        $cores = [
            '#4ade80',
            '#fbbf24',
            '#60a5fa',
            '#f87171',
            '#a78bfa',
            '#2dd4bf',
            '#fb923c',
            '#94a3b8',
            '#e879f9',
            '#38bdf8',
            '#bef264',
            '#f472b6',
        ];

        return $dados->values()->map(function ($item, $index) use ($cores) {
            return [
                'value' => (int) $item->value,
                'name' => primeiraMaiuscula($item->name),
                'itemStyle' => [
                    'color' => $cores[$index % count($cores)]
                ]
            ];
        })->all();
    }
}
