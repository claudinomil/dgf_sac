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
use App\Models\MilitarFundoSaude;
use App\Models\MilitarFundoSaudeAdesao;
use App\Models\MilitarFundoSaudeControle;
use App\Models\Nacionalidade;
use App\Models\Naturalidade;
use App\Models\Parentesco;
use App\Models\Quadro;
use App\Models\SexoBiologico;
use App\Models\Situacao;
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
            'total_militares_dependentes' => MilitarDependente::count()
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

        if ($tabela == 'militares') {
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

        if ($tabela == 'militares_cursos') {
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

        if ($tabela == 'militares_auxilios_fardamentos') {
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

        if ($tabela == 'militares_fundos_saude') {
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

        if ($tabela == 'militares_dependentes') {
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

        return true;
    }
    // Importações SAC antigo (impsac) - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}
