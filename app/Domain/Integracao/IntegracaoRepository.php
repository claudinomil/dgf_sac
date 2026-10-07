<?php

namespace App\Domain\Integracao;

use App\Models\Banco;
use App\Models\Comportamento;
use App\Models\Curso;
use App\Models\MilitarCurso;
use App\Models\MilitarAjudaCusto;
use App\Models\MilitarAuxilioFardamento;
use App\Models\Militar;
use App\Models\Escolaridade;
use App\Models\EstadoCivil;
use App\Models\FatorRh;
use App\Models\Funcao;
use App\Models\Graduacao;
use App\Models\MilitarDependente;
use App\Models\MilitarFerias;
use App\Models\MilitarFundoSaude;
use App\Models\MilitarFundoSaudeAdesao;
use App\Models\MilitarFundoSaudeControle;
use App\Models\MilitarPensao;
use App\Models\MilitarTempoAverbado;
use App\Models\Nacionalidade;
use App\Models\Naturalidade;
use App\Models\Parentesco;
use App\Models\Quadro;
use App\Models\SexoBiologico;
use App\Models\Situacao;
use App\Models\TempoAverbadoLocal;
use App\Models\TipoSanguineo;
use App\Models\Unidade;

class IntegracaoRepository
{
    // Importações SAC antigo (impsac) - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    public function impsac_totais()
    {
        $ar = array();

        $ar[] = array(
            'total_situacoes' => Situacao::count(),
            'total_graduacoes' => Graduacao::count(),
            'total_unidades' => Unidade::count(),
            'total_quadros' => Quadro::count(),
            'total_funcoes' => Funcao::count(),
            'total_estados_civis' => EstadoCivil::count(),
            'total_comportamentos' => Comportamento::count(),
            'total_tipos_sanguineos' => TipoSanguineo::count(),
            'total_fatores_rh' => FatorRh::count(),
            'total_nacionalidades' => Nacionalidade::count(),
            'total_naturalidades' => Naturalidade::count(),
            'total_escolaridades' => Escolaridade::count(),
            'total_sexos_biologicos' => SexoBiologico::count(),
            'total_bancos' => Banco::count(),
            'total_militares' => Militar::count(),
            'total_cursos' => Curso::count(),
            'total_militares_cursos' => MilitarCurso::count(),
            'total_militares_ajudas_custos' => MilitarAjudaCusto::count(),
            'total_militares_auxilios_fardamentos' => MilitarAuxilioFardamento::count(),
            'total_militares_fundos_saude' => MilitarFundoSaude::count(),
            'total_militares_fundos_saude_controle' => MilitarFundoSaudeControle::count(),
            'total_militares_fundos_saude_adesao' => MilitarFundoSaudeAdesao::count(),
            'total_parentescos' => Parentesco::count(),
            'total_militares_dependentes' => MilitarDependente::count(),
            'total_tempos_averbados_locais' => TempoAverbadoLocal::count(),
            'total_militares_tempos_averbados' => MilitarTempoAverbado::count(),
            'total_militares_pensoes' => MilitarPensao::count(),
            'total_militares_ferias' => MilitarFerias::count()
        );

        return $ar[0];
    }

    public function impsac_atualizar_dados($tabela, $dadosLegado)
    {
        if ($tabela == 'situacoes') {
            foreach($dadosLegado as $dado) {
                Situacao::upsert(
                    [$dado],
                    ['id'],
                    ['name', 'codigo_situacao']
                );
            }
        }

        if ($tabela == 'graduacoes') {
            foreach($dadosLegado as $dado) {
                Graduacao::upsert(
                    [$dado],
                    ['id'],
                    ['name', 'codigo_graduacao', 'abreviacao']
                );
            }
        }

        if ($tabela == 'unidades') {
            foreach($dadosLegado as $dado) {
                Unidade::upsert(
                    [$dado],
                    ['id'],
                    [
                        'codigo_unidade',
                        'situacao',
                        'tipo',
                        'ordem_estrutura',
                        'name',
                        'sigla',
                        'ua',
                        'cba',
                        'agregado',
                        'controle',
                        'esfera',
                        'poder',
                        'vocativo',
                        'funcao_id',
                        'responsavel',
                        'cep',
                        'numero',
                        'complemento',
                        'telefone',
                        'fax',
                        'cnpj',
                        'subordinacao_unidade_id',
                        'subordinacao_ordem'
                    ]
                );
            }
        }

        if ($tabela == 'quadros') {
            foreach($dadosLegado as $dado) {
                Quadro::upsert(
                    [$dado],
                    ['id'],
                    [
                        'codigo_quadro',
                        'name',
                        'especialidade',
                        'quadro_especialidade'
                    ]
                );
            }
        }

        if ($tabela == 'funcoes') {
            foreach($dadosLegado as $dado) {
                Funcao::upsert(
                    [$dado],
                    ['id'],
                    ['name']
                );
            }
        }

        if ($tabela == 'estados_civis') {
            foreach($dadosLegado as $dado) {
                EstadoCivil::upsert(
                    [$dado],
                    ['id'],
                    ['name']
                );
            }
        }

        if ($tabela == 'comportamentos') {
            foreach($dadosLegado as $dado) {
                Comportamento::upsert(
                    [$dado],
                    ['id'],
                    ['name']
                );
            }
        }

        if ($tabela == 'tipos_sanguineos') {
            foreach($dadosLegado as $dado) {
                TipoSanguineo::upsert(
                    [$dado],
                    ['id'],
                    ['name']
                );
            }
        }

        if ($tabela == 'fatores_rh') {
            foreach($dadosLegado as $dado) {
                FatorRh::upsert(
                    [$dado],
                    ['id'],
                    ['name']
                );
            }
        }

        if ($tabela == 'nacionalidades') {
            foreach($dadosLegado as $dado) {
                Nacionalidade::upsert(
                    [$dado],
                    ['id'],
                    ['name']
                );
            }
        }

        if ($tabela == 'naturalidades') {
            foreach($dadosLegado as $dado) {
                Naturalidade::upsert(
                    [$dado],
                    ['id'],
                    ['name']
                );
            }
        }

        if ($tabela == 'escolaridades') {
            foreach($dadosLegado as $dado) {
                Escolaridade::upsert(
                    [$dado],
                    ['id'],
                    ['name']
                );
            }
        }

        if ($tabela == 'sexos_biologicos') {
            foreach($dadosLegado as $dado) {
                SexoBiologico::upsert(
                    [$dado],
                    ['id'],
                    ['name']
                );
            }
        }

        if ($tabela == 'bancos') {
            foreach($dadosLegado as $dado) {
                Banco::upsert(
                    [$dado],
                    ['id'],
                    [
                        'name',
                        'sigla'
                    ]
                );
            }
        }

        if ($tabela == 'militares_1' or $tabela == 'militares_2' or $tabela == 'militares_3' or $tabela == 'militares_4') {
            foreach($dadosLegado as $dado) {
                Militar::upsert(
                    [$dado],
                    ['id'],
                    [
                        'situacao_id',
                        'boletim_situacao',
                        'graduacao_id',
                        'boletim_graduacao',
                        'unidade_id',
                        'boletim_movimentacao',
                        'quadro_id',
                        'boletim_quadro',
                        'rg',
                        'nome',
                        'sexo_biologico_id',
                        'genero_id',
                        'data_ingresso',
                        'boletim_ingresso',
                        'data_segunda_praca',
                        'boletim_segunda_praca',
                        'nome_guerra',
                        'prestando_servico_id',
                        'boletim_prestando_servico',
                        'funcao_id',
                        'boletim_funcao',
                        'banco_id',
                        'agencia',
                        'conta_corrente',
                        'cpf',
                        'pasep',
                        'pai',
                        'estado_civil_id',
                        'mae',
                        'data_nascimento',
                        'aniversario',
                        'comportamento_id',
                        'boletim_comportamento',
                        'altura',
                        'tipo_sanguineo_id',
                        'fator_rh_id',
                        'titulo_eleitoral',
                        'titulo_eleitoral_zona',
                        'titulo_eleitoral_secao',
                        'titulo_eleitoral_uf',
                        'certificado_reservista',
                        'certificado_reservista_serie',
                        'certificado_reservista_categoria',
                        'identidade_funcional',
                        'vinculo',
                        'temporario',
                        'nacionalidade_id',
                        'naturalidade_id',
                        'escolaridade_id'
                    ]
                );
            }
        }

        if ($tabela == 'cursos') {
            foreach($dadosLegado as $dado) {
                Curso::upsert(
                    [$dado],
                    ['id'],
                    [
                        'name',
                        'tipo',
                        'abreviacao',
                        'oficial_praca',
                        'percentual'
                    ]
                );
            }
        }

        if ($tabela == 'militares_cursos_1' or $tabela == 'militares_cursos_2' or $tabela == 'militares_cursos_3' or $tabela == 'militares_cursos_4' or $tabela == 'militares_cursos_5' or $tabela == 'militares_cursos_6' or $tabela == 'militares_cursos_7' or $tabela == 'militares_cursos_8') {
            foreach($dadosLegado as $dado) {
                MilitarCurso::upsert(
                    [$dado],
                    ['id'],
                    [
                        'militar_id',
                        'curso_id',
                        'data_inicio',
                        'data_termino',
                        'boletim',
                        'conceito',
                        'classificacao'
                    ]
                );
            }
        }

        if ($tabela == 'militares_ajudas_custos') {
            foreach($dadosLegado as $dado) {
                MilitarAjudaCusto::upsert(
                    [$dado],
                    ['id'],
                    [
                        'militar_id',
                        'excluido',
                        'ajuda_custo_tipo_id',
                        'curso',
                        'boletim',
                        'pagamento',
                        'pagamento_ordenar',
                        'observacao',
                        'referencia_processo_sei'
                    ]
                );
            }
        }

        if ($tabela == 'militares_auxilios_fardamentos_1' or $tabela == 'militares_auxilios_fardamentos_2' or $tabela == 'militares_auxilios_fardamentos_3') {
            foreach($dadosLegado as $dado) {
                MilitarAuxilioFardamento::upsert(
                    [$dado],
                    ['id'],
                    [
                        'militar_id',
                        'excluido',
                        'auxilio_fardamento_tipo_id',
                        'boletim',
                        'pagamento',
                        'pagamento_ordenar',
                        'observacao',
                        'referencia_processo_sei',
                        'requerimento_numero',
                        'requerimento_data',
                        'requerimento_unidade',
                        'documento',
                        'unidade',
                        'mes_pagamento',
                        'ano_pagamento',
                        'mes_recebimento',
                        'ano_recebimento',
                        'data_requerimento',
                        'controle_sistema_cadastramento_fardamentos'
                    ]
                );
            }
        }

        if ($tabela == 'militares_fundos_saude_1' or $tabela == 'militares_fundos_saude_2' or $tabela == 'militares_fundos_saude_3' or $tabela == 'militares_fundos_saude_4') {
            foreach($dadosLegado as $dado) {
                MilitarFundoSaude::upsert(
                    [$dado],
                    ['id'],
                    [
                        'militar_id',
                        'cancelar_desconto',
                        'acesso_sistema_saude',
                        'tipo_acesso',
                        'tipo_acesso_motivo',
                        'acesso_sistema_saude_documento',
                        'data_documento'
                    ]
                );
            }
        }

        if ($tabela == 'militares_fundos_saude_controle') {
            foreach($dadosLegado as $dado) {
                MilitarFundoSaudeControle::upsert(
                    [$dado],
                    ['id'],
                    [
                        'militar_id',
                        'data',
                        'documento',
                        'acao'
                    ]
                );
            }
        }

        if ($tabela == 'militares_fundos_saude_adesao') {
            foreach($dadosLegado as $dado) {
                MilitarFundoSaudeAdesao::upsert(
                    [$dado],
                    ['id'],
                    [
                        'militar_id',
                        'adesao',
                        'documento_sei',
                        'processo_sei',
                        'formulario_adesao_nome',
                        'ciente'
                    ]
                );
            }
        }

        if ($tabela == 'parentescos') {
            foreach($dadosLegado as $dado) {
                Parentesco::upsert(
                    [$dado],
                    ['id'],
                    [
                        'ativo',
                        'name'
                    ]
                );
            }
        }

        if ($tabela == 'tempos_averbados_locais') {
            foreach($dadosLegado as $dado) {
                TempoAverbadoLocal::upsert(
                    [$dado],
                    ['id'],
                    [
                        'tipo',
                        'name'
                    ]
                );
            }
        }

        if ($tabela == 'militares_dependentes_1' or $tabela == 'militares_dependentes_2' or $tabela == 'militares_dependentes_3' or $tabela == 'militares_dependentes_4' or $tabela == 'militares_dependentes_5' or $tabela == 'militares_dependentes_6' or $tabela == 'militares_dependentes_7') {
            foreach($dadosLegado as $dado) {
                MilitarDependente::upsert(
                    [$dado],
                    ['id'],
                    [
                        'militar_id',
                        'parentesco_id',
                        'excluido',
                        'name',
                        'cpf',
                        'decisao_judicial',
                        'decisao_judicial_documento',
                        'decisao_judicial_a_contar_de',
                        'data_casamento',
                        'data_nascimento',
                        'data_inicio_dependencia',
                        'data_termino_dependencia',
                        'numero_processo_validacao',
                        'data_inicio_contagem',
                        'data_fim_contagem',
                        'sexo_biologico_id',
                        'vinculo_permanente',
                        'boletim',
                        'unidade',
                        'numero_requerimento',
                        'data_requerimento',
                        'numero_processo',
                        'data_processo',
                        'observacao',
                        'imposto_renda',
                        'fundo_saude',
                        'acesso_sistema_saude_dependente',
                        'tipo_acesso',
                        'referencia_processo_sei'
                    ]
                );
            }
        }

        if ($tabela == 'militares_pensoes_1' or $tabela == 'militares_pensoes_2') {
            foreach($dadosLegado as $dado) {
                MilitarPensao::upsert(
                    [$dado],
                    ['id'],
                    [
                        'militar_id',
                        'excluido',
                        'pensao_tipo_id',
                        'nome_militar',
                        'beneficiario',
                        'desconto',
                        'representante_legal',
                        'logradouro',
                        'bairro',
                        'cidade',
                        'estado',
                        'cep',
                        'telefone',
                        'celular',
                        'banco',
                        'agencia',
                        'conta_corrente',
                        'cpf',
                        'documento',
                        'data_documento',
                        'numero_processo',
                        'vara_familia',
                        'implantacao',
                        'nascimento',
                        'cancelar_em',
                        'alterar_em',
                        'nascimento_beneficiario',
                        'observacao',
                        'pasta_dip'
                    ]
                );
            }
        }

        if ($tabela == 'militares_tempos_averbados') {
            foreach($dadosLegado as $dado) {
                MilitarTempoAverbado::upsert(
                    [$dado],
                    ['id'],
                    [
                        'militar_id',
                        'excluido',
                        'tempo_averbado_local_id',
                        'data_ingresso_local',
                        'data_termino_local',
                        'tempo_apurado_local',
                        'boletim',
                        'proderj_servico_publico',
                        'proderj_servico_publico_rj',
                        'proderj_servico_cargo',
                        'proderj_controle',
                        'lancado_proderj',
                        'observacao',
                        'referencia_processo_sei'
                    ]
                );
            }
        }

        if ($tabela == 'militares_ferias_1' or
            $tabela == 'militares_ferias_2' or
            $tabela == 'militares_ferias_3' or
            $tabela == 'militares_ferias_4' or
            $tabela == 'militares_ferias_5' or
            $tabela == 'militares_ferias_6' or
            $tabela == 'militares_ferias_7' or
            $tabela == 'militares_ferias_8' or
            $tabela == 'militares_ferias_9' or
            $tabela == 'militares_ferias_10' or
            $tabela == 'militares_ferias_11' or
            $tabela == 'militares_ferias_12' or
            $tabela == 'militares_ferias_13' or
            $tabela == 'militares_ferias_14' or
            $tabela == 'militares_ferias_15' or
            $tabela == 'militares_ferias_16' or
            $tabela == 'militares_ferias_17' or
            $tabela == 'militares_ferias_18' or
            $tabela == 'militares_ferias_19' or
            $tabela == 'militares_ferias_20' or
            $tabela == 'militares_ferias_21' or
            $tabela == 'militares_ferias_22' or
            $tabela == 'militares_ferias_23' or
            $tabela == 'militares_ferias_24' or
            $tabela == 'militares_ferias_25' or
            $tabela == 'militares_ferias_26' or
            $tabela == 'militares_ferias_27' or
            $tabela == 'militares_ferias_28' or
            $tabela == 'militares_ferias_29' or
            $tabela == 'militares_ferias_30' or
            $tabela == 'militares_ferias_31' or
            $tabela == 'militares_ferias_32' or
            $tabela == 'militares_ferias_33' or
            $tabela == 'militares_ferias_34' or
            $tabela == 'militares_ferias_35' or
            $tabela == 'militares_ferias_36' or
            $tabela == 'militares_ferias_37' or
            $tabela == 'militares_ferias_38' or
            $tabela == 'militares_ferias_39' or
            $tabela == 'militares_ferias_40') {
            foreach($dadosLegado as $dado) {
                MilitarFerias::upsert(
                    [$dado],
                    ['id'],
                    [
                        'militar_id',
                        'excluido',
                        'mes',
                        'ano',
                        'referencia',
                        'documento_origem',
                        'boletim',
                        'ciente',
                        'documento',
                        'unidade',
                        'excecao_id',
                        'controle_sistema_cadastramento_ferias',
                        'observacao'
                    ]
                );
            }
        }

        return true;
    }
    // Importações SAC antigo (impsac) - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}
