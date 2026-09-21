<?php

namespace App\Domain\Transacao;

use App\Domain\Submodulo\SubmoduloRepository;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransacaoService
{
    // Contexto da transação
    private $operacao_id;
    private $prefix_permissao;
    private $user_id;
    private $dados;

    public function __construct(
        private TransacaoRepository $repository,
        private SubmoduloRepository $submoduloRepository
    ) {}

    public function getTransacoes($limit=null)
    {
        return $this->repository->index($limit);
    }

    public function getTransacoesFilter($array_dados, $limit=null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function createTransacao(array $data)
    {
        return $this->repository->create($data);
    }

    public function transacao(int $op, int $operacao_id, string $prefix_permissao, array $dadosAtual, array $dadosAnterior)
    {
        // Usuário logado
        $this->user_id = Auth::user()->id ?? null;

        if (!$this->user_id) {
            return false;
        }

        // Define contexto
        $this->operacao_id = $operacao_id;
        $this->prefix_permissao = $prefix_permissao;
        $this->dados = null;

        $estruturas = [];

        // users
        if ($prefix_permissao == 'users') {
            $estruturas = [
                ['campo' => 'id', 'etiqueta' => 'ID', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'name', 'etiqueta' => 'Nome', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'user', 'etiqueta' => 'Usuário', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'email', 'etiqueta' => 'E-mail', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'grupo_id', 'etiqueta' => 'Grupo', 'model_op' => '1', 'tipo' => 'string'],
                ['campo' => 'user_situacao_id', 'etiqueta' => 'Usuário Situação', 'model_op' => '2', 'tipo' => 'string'],
                ['campo' => 'user_tipo_id', 'etiqueta' => 'Usuário Tipo', 'model_op' => '3', 'tipo' => 'string'],
                ['campo' => 'layout_menu', 'etiqueta' => 'Menu', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'militar_rg', 'etiqueta' => 'Militar RG', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'militar_nome', 'etiqueta' => 'Militar Nome', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'militar_posto_graduacao', 'etiqueta' => 'Militar Posto/Graduação', 'model_op' => '', 'tipo' => 'string']
            ];
        }

        // grupos
        if ($prefix_permissao == 'grupos') {
            // tem tabela pivot, então a transação vai ser gravara no GrupoRepository
            return true;
        }

        // Situações
        if ($prefix_permissao == 'situacoes') {
            $estruturas = [
                ['campo' => 'id', 'etiqueta' => 'ID', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'excluido', 'etiqueta' => 'Excluído', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'name', 'etiqueta' => 'Nome', 'model_op' => '', 'tipo' => 'string']
            ];
        }

        // Graduações
        if ($prefix_permissao == 'graduacoes') {
            $estruturas = [
                ['campo' => 'id', 'etiqueta' => 'ID', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'excluido', 'etiqueta' => 'Excluído', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'name', 'etiqueta' => 'Nome', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'abreviacao', 'etiqueta' => 'Abreviação', 'model_op' => '', 'tipo' => 'string']
            ];
        }

        // Quadros
        if ($prefix_permissao == 'quadros') {
            $estruturas = [
                ['campo' => 'id', 'etiqueta' => 'ID', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'excluido', 'etiqueta' => 'Excluído', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'name', 'etiqueta' => 'Nome', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'especialidade', 'etiqueta' => 'Especialidade', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'quadro_especialidade', 'etiqueta' => 'Quadro Especialidade', 'model_op' => '', 'tipo' => 'string']
            ];
        }

        // Comportamentos
        if ($prefix_permissao == 'comportamentos') {
            $estruturas = [
                ['campo' => 'id', 'etiqueta' => 'ID', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'excluido', 'etiqueta' => 'Excluído', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'name', 'etiqueta' => 'Nome', 'model_op' => '', 'tipo' => 'string']
            ];
        }

        // Funções
        if ($prefix_permissao == 'funcoes') {
            $estruturas = [
                ['campo' => 'id', 'etiqueta' => 'ID', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'excluido', 'etiqueta' => 'Excluído', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'name', 'etiqueta' => 'Nome', 'model_op' => '', 'tipo' => 'string']
            ];
        }

        // Parentescos
        if ($prefix_permissao == 'parentescos') {
            $estruturas = [
                ['campo' => 'id', 'etiqueta' => 'ID', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'excluido', 'etiqueta' => 'Excluído', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'name', 'etiqueta' => 'Nome', 'model_op' => '', 'tipo' => 'string']
            ];
        }

        // Gêneros
        if ($prefix_permissao == 'generos') {
            $estruturas = [
                ['campo' => 'id', 'etiqueta' => 'ID', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'excluido', 'etiqueta' => 'Excluído', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'name', 'etiqueta' => 'Nome', 'model_op' => '', 'tipo' => 'string']
            ];
        }

        // Cursos
        if ($prefix_permissao == 'cursos') {
            $estruturas = [
                ['campo' => 'id', 'etiqueta' => 'ID', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'excluido', 'etiqueta' => 'Excluído', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'name', 'etiqueta' => 'Nome', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'tipo', 'etiqueta' => 'Tipo', 'model_op' => '33', 'tipo' => 'string'],
                ['campo' => 'abreviacao', 'etiqueta' => 'Abreviação', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'oficial_praca', 'etiqueta' => 'Oficial/Praça', 'model_op' => '34', 'tipo' => 'string'],
                ['campo' => 'percentual', 'etiqueta' => 'Percentual', 'model_op' => '', 'tipo' => 'string']
            ];
        }

        // Unidades
        if ($prefix_permissao == 'unidades') {
            $estruturas = [
                ['campo' => 'id', 'etiqueta' => 'ID', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'excluido', 'etiqueta' => 'Excluído', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'name', 'etiqueta' => 'Nome', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'sigla', 'etiqueta' => 'Sigla', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'codigo_unidade', 'etiqueta' => 'Código Unidade', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'situacao', 'etiqueta' => 'Situação', 'model_op' => '35', 'tipo' => 'string'],
                ['campo' => 'tipo', 'etiqueta' => 'Tipo', 'model_op' => '36', 'tipo' => 'string'],

            ];
        }

        // militares
        if ($prefix_permissao == 'militares') {
            $estruturas = [
                ['campo' => 'id', 'etiqueta' => 'ID', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'excluido', 'etiqueta' => 'Excluído', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'situacao_id', 'etiqueta' => 'Situação', 'model_op' => '4', 'tipo' => 'string'],
                ['campo' => 'boletim_situacao', 'etiqueta' => 'Boletim Situação', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'graduacao_id', 'etiqueta' => 'Graduação', 'model_op' => '5', 'tipo' => 'string'],
                ['campo' => 'boletim_graduacao', 'etiqueta' => 'Boletim Graduação', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'unidade_id', 'etiqueta' => 'Unidade', 'model_op' => '6', 'tipo' => 'string'],
                ['campo' => 'boletim_movimentacao', 'etiqueta' => 'Boletim Movimentação', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'quadro_id', 'etiqueta' => 'Quadro', 'model_op' => '7', 'tipo' => 'string'],
                ['campo' => 'boletim_quadro', 'etiqueta' => 'Boletim Quadro', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'rg', 'etiqueta' => 'RG', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'nome', 'etiqueta' => 'Nome', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'sexo_biologico_id', 'etiqueta' => 'Sexo Biológico', 'model_op' => '8', 'tipo' => 'string'],
                ['campo' => 'genero_id', 'etiqueta' => 'Gênero', 'model_op' => '12', 'tipo' => 'string'],
                ['campo' => 'data_ingresso', 'etiqueta' => 'Data Ingresso', 'model_op' => '', 'tipo' => 'date'],
                ['campo' => 'boletim_ingresso', 'etiqueta' => 'Boletim Ingresso', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'data_segunda_praca', 'etiqueta' => 'Data Segunda Praça', 'model_op' => '', 'tipo' => 'date'],
                ['campo' => 'boletim_segunda_praca', 'etiqueta' => 'Boletim Segunda Praça', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'nome_guerra', 'etiqueta' => 'Nome Guerra', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'prestando_servico_id', 'etiqueta' => 'Prestando Serviço', 'model_op' => '13', 'tipo' => 'string'],
                ['campo' => 'boletim_prestando_servico', 'etiqueta' => 'Boletim Prestando Serviço', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'funcao_id', 'etiqueta' => 'Função', 'model_op' => '14', 'tipo' => 'string'],
                ['campo' => 'boletim_funcao', 'etiqueta' => 'Boletim Função', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'banco_id', 'etiqueta' => 'Banco', 'model_op' => '15', 'tipo' => 'string'],
                ['campo' => 'agencia', 'etiqueta' => 'Agência', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'conta_corrente', 'etiqueta' => 'Conta Corrente', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'cpf', 'etiqueta' => 'CPF', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'pasep', 'etiqueta' => 'PASEP', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'pai', 'etiqueta' => 'Pai', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'estado_civil_id', 'etiqueta' => 'Estado Civil', 'model_op' => '16', 'tipo' => 'string'],
                ['campo' => 'mae', 'etiqueta' => 'Mãe', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'data_nascimento', 'etiqueta' => 'Data Nascimento', 'model_op' => '', 'tipo' => 'date'],
                ['campo' => 'comportamento_id', 'etiqueta' => 'Comportamento', 'model_op' => '17', 'tipo' => 'string'],
                ['campo' => 'boletim_comportamento', 'etiqueta' => 'Boletim Comportamento', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'altura', 'etiqueta' => 'Altura', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'tipo_sanguineo_id', 'etiqueta' => 'Tipo Sanguíneo', 'model_op' => '18', 'tipo' => 'string'],
                ['campo' => 'fator_rh_id', 'etiqueta' => 'Fator RH', 'model_op' => '19', 'tipo' => 'string'],
                ['campo' => 'titulo_eleitoral', 'etiqueta' => 'Título Eleitoral', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'titulo_eleitoral_zona', 'etiqueta' => 'Título Eleitoral Zona', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'titulo_eleitoral_secao', 'etiqueta' => 'Título Eleitoral Seção', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'titulo_eleitoral_uf', 'etiqueta' => 'Título Eleitoral UF', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'certificado_reservista', 'etiqueta' => 'Certificado Reservista', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'certificado_reservista_serie', 'etiqueta' => 'Certificado Reservista Série', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'certificado_reservista_categoria', 'etiqueta' => 'Certificado Reservista Categoria', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'identidade_funcional', 'etiqueta' => 'Identidade Funcional', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'vinculo', 'etiqueta' => 'Vínculo', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'temporario', 'etiqueta' => 'Temporário', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'nacionalidade_id', 'etiqueta' => 'Nacionalidade', 'model_op' => '20', 'tipo' => 'string'],
                ['campo' => 'naturalidade_id', 'etiqueta' => 'Naturalidade', 'model_op' => '21', 'tipo' => 'string'],
                ['campo' => 'escolaridade_id', 'etiqueta' => 'Escolaridade', 'model_op' => '22', 'tipo' => 'string']
            ];
        }

        // militares_cursos
        if ($prefix_permissao == 'militares_cursos') {
            $estruturas = [
                ['campo' => 'id', 'etiqueta' => 'ID', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'excluido', 'etiqueta' => 'Excluído', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'militar_id', 'etiqueta' => 'Militar', 'model_op' => '27', 'tipo' => 'string'],
                ['campo' => 'curso_id', 'etiqueta' => 'Curso', 'model_op' => '28', 'tipo' => 'string'],
                ['campo' => 'data_inicio', 'etiqueta' => 'Data Início', 'model_op' => '', 'tipo' => 'date'],
                ['campo' => 'data_termino', 'etiqueta' => 'Data Término', 'model_op' => '', 'tipo' => 'date'],
                ['campo' => 'boletim', 'etiqueta' => 'Boletim', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'conceito', 'etiqueta' => 'Conceito', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'classificacao', 'etiqueta' => 'Classificação', 'model_op' => '', 'tipo' => 'string']
            ];
        }

        // militares_contatos
        if ($prefix_permissao == 'militares_contatos') {
            $estruturas = [
                ['campo' => 'id', 'etiqueta' => 'ID', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'excluido', 'etiqueta' => 'Excluído', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'militar_id', 'etiqueta' => 'Militar', 'model_op' => '27', 'tipo' => 'string'],
                ['campo' => 'cep', 'etiqueta' => 'CEP', 'model_op' => '', 'tipo' => 'cep'],
                ['campo' => 'numero', 'etiqueta' => 'Número', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'complemento', 'etiqueta' => 'Complemento', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'logradouro', 'etiqueta' => 'Logradouro', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'bairro', 'etiqueta' => 'Bairro', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'localidade', 'etiqueta' => 'Localidade', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'uf', 'etiqueta' => 'UF', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'celular_1', 'etiqueta' => 'Celular 1', 'model_op' => '', 'tipo' => 'celular'],
                ['campo' => 'celular_2', 'etiqueta' => 'Celular 2', 'model_op' => '', 'tipo' => 'celular'],
                ['campo' => 'telefone_1', 'etiqueta' => 'Telefone 1', 'model_op' => '', 'tipo' => 'telefone'],
                ['campo' => 'telefone_2', 'etiqueta' => 'Telefone 2', 'model_op' => '', 'tipo' => 'telefone'],
                ['campo' => 'email', 'etiqueta' => 'E-mail', 'model_op' => '', 'tipo' => 'string']
            ];
        }

        // militares_ajudas_custos
        if ($prefix_permissao == 'militares_ajudas_custos') {
            $estruturas = [
                ['campo' => 'id', 'etiqueta' => 'ID', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'excluido', 'etiqueta' => 'Excluído', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'militar_id', 'etiqueta' => 'Militar', 'model_op' => '27', 'tipo' => 'string'],
                ['campo' => 'ajuda_custo_tipo_id', 'etiqueta' => 'Ajuda Custo Tipo', 'model_op' => '9', 'tipo' => 'string'],
                ['campo' => 'curso', 'etiqueta' => 'Curso', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'boletim', 'etiqueta' => 'Boletim', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'pagamento', 'etiqueta' => 'Pagamento', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'observacao', 'etiqueta' => 'Observação', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'referencia_processo_sei', 'etiqueta' => 'Referência Processo SEI', 'model_op' => '', 'tipo' => 'string']
            ];
        }

        // militares_auxilios_fardamentos
        if ($prefix_permissao == 'militares_auxilios_fardamentos') {
            $estruturas = [
                ['campo' => 'id', 'etiqueta' => 'ID', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'excluido', 'etiqueta' => 'Excluído', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'militar_id', 'etiqueta' => 'Militar', 'model_op' => '27', 'tipo' => 'string'],
                ['campo' => 'auxilio_fardamento_tipo_id', 'etiqueta' => 'Auxílio Fardamento Tipo', 'model_op' => '10', 'tipo' => 'string'],
                ['campo' => 'boletim', 'etiqueta' => 'Boletim', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'pagamento', 'etiqueta' => 'Pagamento', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'observacao', 'etiqueta' => 'Observação', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'referencia_processo_sei', 'etiqueta' => 'Referência Processo SEI', 'model_op' => '', 'tipo' => 'string']
            ];
        }

        // militares_dependentes
        if ($prefix_permissao == 'militares_dependentes') {
            $estruturas = [
                ['campo' => 'id', 'etiqueta' => 'ID', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'excluido', 'etiqueta' => 'Excluído', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'militar_id', 'etiqueta' => 'Militar', 'model_op' => '27', 'tipo' => 'string'],
                ['campo' => 'parentesco_id', 'etiqueta' => 'Parentesco', 'model_op' => '30', 'tipo' => 'string'],
                ['campo' => 'name', 'etiqueta' => 'Nome', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'cpf', 'etiqueta' => 'CPF', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'decisao_judicial', 'etiqueta' => 'Decisao Judicial', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'decisao_judicial_documento', 'etiqueta' => 'Decisao Judicial Documento', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'decisao_judicial_a_contar_de', 'etiqueta' => 'Decisao Judicial A Contar De', 'model_op' => '', 'tipo' => 'date'],
                ['campo' => 'data_casamento', 'etiqueta' => 'Data Casamento', 'model_op' => '', 'tipo' => 'date'],
                ['campo' => 'data_nascimento', 'etiqueta' => 'Data Nascimento', 'model_op' => '', 'tipo' => 'date'],
                ['campo' => 'data_inicio_dependencia', 'etiqueta' => 'Data Início Dependência', 'model_op' => '', 'tipo' => 'date'],
                ['campo' => 'data_termino_dependencia', 'etiqueta' => 'Data Término Dependência', 'model_op' => '', 'tipo' => 'date'],
                ['campo' => 'numero_processo_validacao', 'etiqueta' => 'Número Processo Validação', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'data_inicio_contagem', 'etiqueta' => 'Data Início Contagem', 'model_op' => '', 'tipo' => 'date'],
                ['campo' => 'data_fim_contagem', 'etiqueta' => 'Data Fim Contagem', 'model_op' => '', 'tipo' => 'date'],
                ['campo' => 'sexo_biologico_id', 'etiqueta' => 'Sexo Biológico', 'model_op' => '8', 'tipo' => 'string'],
                ['campo' => 'vinculo_permanente', 'etiqueta' => 'Vínculo Permanente', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'boletim', 'etiqueta' => 'Boletim', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'unidade', 'etiqueta' => 'Unidade', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'numero_requerimento', 'etiqueta' => 'Número Requerimento', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'data_requerimento', 'etiqueta' => 'Data Requerimento', 'model_op' => '', 'tipo' => 'date'],
                ['campo' => 'numero_processo', 'etiqueta' => 'Número Processo', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'data_processo', 'etiqueta' => 'Data Processo', 'model_op' => '', 'tipo' => 'date'],
                ['campo' => 'observacao', 'etiqueta' => 'Observação', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'imposto_renda', 'etiqueta' => 'Imposto Renda', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'fundo_saude', 'etiqueta' => 'Fundo Saúde', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'acesso_sistema_saude_dependente', 'etiqueta' => 'Acesso Sistema Saúde', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'tipo_acesso', 'etiqueta' => 'Tipo Acesso', 'model_op' => '32', 'tipo' => 'string'],
                ['campo' => 'referencia_processo_sei', 'etiqueta' => 'Referência Processo SEI', 'model_op' => '', 'tipo' => 'string']
            ];
        }

        // militares_fundos_saude
        if ($prefix_permissao == 'militares_fundos_saude') {
            $estruturas = [
                ['campo' => 'id', 'etiqueta' => 'ID', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'excluido', 'etiqueta' => 'Excluído', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'militar_id', 'etiqueta' => 'Militar', 'model_op' => '27', 'tipo' => 'string'],
                ['campo' => 'cancelar_desconto', 'etiqueta' => 'Cancelar Desconto', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'acesso_sistema_saude', 'etiqueta' => 'Acesso Sistema Saúde', 'model_op' => '31', 'tipo' => 'string'],
                ['campo' => 'acesso_sistema_saude_documento', 'etiqueta' => 'Acesso Sistema Saúde Documento', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'tipo_acesso', 'etiqueta' => 'Tipo Acesso', 'model_op' => '32', 'tipo' => 'string'],
                ['campo' => 'tipo_acesso_motivo', 'etiqueta' => 'Tipo Acesso Motivo', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'data_documento', 'etiqueta' => 'Data Documento', 'model_op' => '', 'tipo' => 'date']
            ];
        }

        // ressarcimento_referencias
        if ($prefix_permissao == 'ressarcimento_referencias') {
            $estruturas = [
                ['campo' => 'referencia', 'etiqueta' => 'Referência', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'ano', 'etiqueta' => 'Ano', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'mes', 'etiqueta' => 'Mês', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'parte', 'etiqueta' => 'Parte', 'model_op' => '', 'tipo' => 'string']
            ];
        }

        // ressarcimento_orgaos
        if ($prefix_permissao == 'ressarcimento_orgaos') {
            $estruturas = [
                ['campo' => 'name', 'etiqueta' => 'Nome', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'cnpj', 'etiqueta' => 'CNPJ', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'ug', 'etiqueta' => 'UG', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'responsavel', 'etiqueta' => 'Responsável', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'esfera_id', 'etiqueta' => 'Esfera', 'model_op' => '23', 'tipo' => 'string'],
                ['campo' => 'poder_id', 'etiqueta' => 'Poder', 'model_op' => '24', 'tipo' => 'string'],
                ['campo' => 'tratamento_id', 'etiqueta' => 'Tratamento', 'model_op' => '25', 'tipo' => 'string'],
                ['campo' => 'vocativo_id', 'etiqueta' => 'Vocativo', 'model_op' => '26', 'tipo' => 'string'],
                ['campo' => 'funcao_id', 'etiqueta' => 'Função', 'model_op' => '14', 'tipo' => 'string'],
                ['campo' => 'telefone_1', 'etiqueta' => 'Telefone 1', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'telefone_2', 'etiqueta' => 'Telefone 2', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'cep', 'etiqueta' => 'CEP', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'numero', 'etiqueta' => 'Número', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'complemento', 'etiqueta' => 'Complemento', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'logradouro', 'etiqueta' => 'Logradouro', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'bairro', 'etiqueta' => 'Bairro', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'localidade', 'etiqueta' => 'Localidade', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'uf', 'etiqueta' => 'UF', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'contato_nome', 'etiqueta' => 'Contato Nome', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'contato_telefone', 'etiqueta' => 'Contato Telefone', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'contato_celular', 'etiqueta' => 'Contato Celular', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'contato_email', 'etiqueta' => 'Contato E-mail', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'lotacao_id', 'etiqueta' => 'Lotação Id', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'lotacao', 'etiqueta' => 'Lotação', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'cobranca_realizar', 'etiqueta' => 'Realizar Cobrança', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'cobranca_ressarcimento_orgao_id', 'etiqueta' => 'Cobrança Orgão', 'model_op' => '29', 'tipo' => 'string']
            ];
        }

        // ressarcimento_militares
        if ($prefix_permissao == 'ressarcimento_militares') {
            $estruturas = [
                ['campo' => 'referencia', 'etiqueta' => 'Referência', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'identidade_funcional', 'etiqueta' => 'Identidade Funcional', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'rg', 'etiqueta' => 'RG', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'nome', 'etiqueta' => 'Nome', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'oficial_praca', 'etiqueta' => 'Oficial/Praca', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'posto_graduacao', 'etiqueta' => 'Graduação', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'quadro_qbmp', 'etiqueta' => 'Quadro', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'boletim', 'etiqueta' => 'Boletim', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'lotacao_id', 'etiqueta' => 'Lotação Id', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'lotacao', 'etiqueta' => 'Lotação', 'model_op' => '', 'tipo' => 'string']
            ];
        }

        // ressarcimento_configuracoes
        if ($prefix_permissao == 'ressarcimento_configuracoes') {
            $estruturas = [
                ['campo' => 'referencia', 'etiqueta' => 'Referência', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'data_vencimento', 'etiqueta' => 'Data Vencimento', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'diretor_identidade_funcional', 'etiqueta' => 'Diretor Identidade Funcional', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'diretor_rg', 'etiqueta' => 'Diretor RG', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'diretor_nome', 'etiqueta' => 'Diretor Nome', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'diretor_posto', 'etiqueta' => 'Diretor Posto', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'diretor_quadro', 'etiqueta' => 'Diretor Quadro', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'diretor_cargo', 'etiqueta' => 'Diretor Cargo', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'dgf2_identidade_funcional', 'etiqueta' => 'DGF2 Identidade Funcional', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'dgf2_rg', 'etiqueta' => 'DGF2 RG', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'dgf2_nome', 'etiqueta' => 'DGF2 Nome', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'dgf2_posto', 'etiqueta' => 'DGF2 Posto', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'dgf2_quadro', 'etiqueta' => 'DGF2 Quadro', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'dgf2_cargo', 'etiqueta' => 'DGF2 Cargo', 'model_op' => '', 'tipo' => 'string']
            ];
        }

        // ressarcimento_pagamentos
        if ($prefix_permissao == 'ressarcimento_pagamentos') {
            $estruturas = [
                ['campo' => 'referencia', 'etiqueta' => 'Referência', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'identidade_funcional', 'etiqueta' => 'Identidade Funcional', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'rg', 'etiqueta' => 'RG', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'nome_cargo', 'etiqueta' => 'Nome Cargo', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'posto_graduacao', 'etiqueta' => 'Posto/Graduação', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'nome', 'etiqueta' => 'Nome', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'ua', 'etiqueta' => 'UA', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'cpf', 'etiqueta' => 'CPF', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'bruto', 'etiqueta' => 'Bruto', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'desconto', 'etiqueta' => 'Desconto', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'liquido', 'etiqueta' => 'Líquido', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'soldo', 'etiqueta' => 'Soldo', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'hospital10', 'etiqueta' => 'Hospital 10', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'rioprevidencia22', 'etiqueta' => 'Rioprevidência 22', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'etapa_ferias', 'etiqueta' => 'Etapa Férias', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'etapa_destacado', 'etiqueta' => 'Etapa Destacado', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'ajuda_fardamento', 'etiqueta' => 'Ajuda Fardamento', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'habilitacao_profissional', 'etiqueta' => 'Habilitação Profissional', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'gret', 'etiqueta' => 'GRET', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'ferias', 'etiqueta' => 'Férias', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'raio_x', 'etiqueta' => 'Raio X', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'trienio', 'etiqueta' => 'Triênio', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'fundo_saude', 'etiqueta' => 'Fundo Saúde', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'abono_permanencia', 'etiqueta' => 'Abono Permanência', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'auxilio_transporte', 'etiqueta' => 'Auxílio Transporte', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'gram', 'etiqueta' => 'GRAM', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'auxilio_fardamento', 'etiqueta' => 'Auxílio Fardamento', 'model_op' => '', 'tipo' => 'moeda'],
                ['campo' => 'cidade', 'etiqueta' => 'Cidade', 'model_op' => '', 'tipo' => 'string'],
                ['campo' => 'observacao', 'etiqueta' => 'Observação', 'model_op' => '', 'tipo' => 'string']
            ];
        }

        // Montar Dados com as Estruturas
        $this->dados = ['campos' => $this->transacaoMontarDados($estruturas, $dadosAtual, $dadosAnterior)];

        // Só grava se tiver dados
        if (!empty($this->dados)) {
            $this->transacaoGravarDados();
        }

        // evita sujeira de estado
        $this->transacaoLimparContexto();

        return true;
    }

    public function transacaoMontarDados(array $estruturas, array $dadosAtual, array $dadosAnterior = [])
    {
        $campos = [];

        foreach ($estruturas as $estrutura) {
            $anterior = $dadosAnterior[$estrutura['campo']] ?? null;
            $atual = $dadosAtual[$estrutura['campo']] ?? null;

            if ($atual === null) {$atual = $dadosAnterior[$estrutura['campo']] ?? null;}

            // só registra se tiver valor ou alteração
            if ($anterior === null && $atual === null) {
                //continue;
            }

            $anterior_view = $anterior;
            $atual_view = $atual;

            // Verificando se tem que pegar informação em outras tabelas
            if ($estrutura['model_op'] != '') {
                if ($anterior_view !== null) {$anterior_view = $this->repository->getModelValue($estrutura['model_op'], $anterior_view);}
                if ($atual_view !== null) {$atual_view = $this->repository->getModelValue($estrutura['model_op'], $atual_view);}
            }

            // Transformando tipo (date)
            if ($estrutura['tipo'] == 'date') {
                if (!empty($anterior_view)) {$anterior_view = Carbon::parse($anterior_view)->format('d/m/Y');}
                if (!empty($atual_view)) {$atual_view = Carbon::parse($atual_view)->format('d/m/Y');}
            }

            // Transformando tipo (cep)
            if ($estrutura['tipo'] == 'cep') {
                if (!empty($anterior_view)) {$anterior_view = getCepFormatado(1, $anterior_view);}
                if (!empty($atual_view)) {$atual_view = getCepFormatado(1, $atual_view);}
            }

            // Transformando tipo (celular)
            if ($estrutura['tipo'] == 'celular') {
                if (!empty($anterior_view)) {$anterior_view = getCelularFormatado(1, $anterior_view);}
                if (!empty($atual_view)) {$atual_view = getCelularFormatado(1, $atual_view);}
            }

            // Transformando tipo (telefone)
            if ($estrutura['tipo'] == 'telefone') {
                if (!empty($anterior_view)) {$anterior_view = getTelefoneFormatado(1, $anterior_view);}
                if (!empty($atual_view)) {$atual_view = getTelefoneFormatado(1, $atual_view);}
            }

            // Transformando tipo (moeda)
            if ($estrutura['tipo'] == 'moeda') {
                $vl = getValorFormatado(1, $atual_view);
                if (!empty($atual_view)) {$atual_view = number_format((float) $vl, 2, ',', '.');}
            }

            // Campos
            $campos[] = [
                'campo' => $estrutura['campo'],
                'etiqueta' => $estrutura['etiqueta'],
                'anterior' => $anterior,
                'atual' => $atual,
                'anterior_view' => $anterior_view,
                'atual_view' => $atual_view
            ];
        }

        return $campos;
    }

    private function transacaoGravarDados()
    {
        // Buscar submodulo_id
        $submodulo = $this->submoduloRepository->getSubmoduloPrefixPermissao($this->prefix_permissao);
        $submodulo_id = $submodulo ? $submodulo->id : null;

        $transacaoData = [
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'user_id' => $this->user_id,
            'operacao_id' => $this->operacao_id,
            'submodulo_id' => $submodulo_id,
            'dados' => $this->dados
        ];

        $this->createTransacao($transacaoData);
    }

    private function transacaoLimparContexto()
    {
        $this->operacao_id = null;
        $this->prefix_permissao = null;
        $this->user_id = null;
        $this->dados = null;
    }

    public function getTotais(int $op)
    {
        // Total Geral
        if ($op == 1) {
            return $this->repository->totais($op);
        }

        // Total Inclusão
        if ($op == 2) {
            return $this->repository->totais($op);
        }

        // Total Alteração
        if ($op == 3) {
            return $this->repository->totais($op);
        }

        // Total Exclusão
        if ($op == 2) {
            return $this->repository->totais($op);
        }
    }
}
