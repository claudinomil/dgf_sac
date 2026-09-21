<?php

namespace App\Services;

use App\Models\MilitarDependente;
use Illuminate\Support\Facades\DB;

class MilitarDependenteSyncService
{
    public function insert(MilitarDependente $militarDependente)
    {
        $this->executar('INSERT', 'portaldgf', 'sac_dependentes_teste', $militarDependente->id, fn() => $this->salvarPortaldgf($militarDependente));
        $this->executar('INSERT', 'cbmerj', 'dbu_dependentes_teste', $militarDependente->id, fn() => $this->salvarCbmerj($militarDependente));
    }

    public function update(MilitarDependente $militarDependente)
    {
        $this->executar('UPDATE', 'portaldgf', 'sac_dependentes_teste', $militarDependente->id, fn() => $this->salvarPortaldgf($militarDependente));
        $this->executar('UPDATE', 'cbmerj', 'dbu_dependentes_teste', $militarDependente->id, fn() => $this->salvarCbmerj($militarDependente));
    }

    public function delete(int $id)
    {
        $this->executar('DELETE', 'portaldgf', 'sac_dependentes_teste', $id, function () use ($id) {DB::connection('portaldgf')->table('sac_dependentes_teste')->where('codigo', $id)->delete();});
        $this->executar('DELETE', 'cbmerj', 'dbu_dependentes_teste', $id, function () use ($id) {DB::connection('cbmerj')->table('dbu_dependentes_teste')->where('dependente_id', $id)->delete();});
    }

    private function executar(string $operacao, string $banco, string $tabela, int $registroId, callable $callback): bool
    {
        try {
            $callback();

            $this->gravarLog($operacao, $banco, $tabela, $registroId, true);

            return true;
        } catch (\Throwable $e) {
            $this->gravarLog($operacao, $banco, $tabela, $registroId, false, $e->getMessage());

            return false;
        }
    }

    private function salvarPortaldgf(MilitarDependente $militarDependente)
    {
        DB::connection('portaldgf')
            ->table('sac_dependentes_teste')
            ->updateOrInsert(
                ['codigo' => $militarDependente->id],   
                [
                    'excluido'                          => $militarDependente->excluido,
                    'rg'                                => $this->converterMilitarIdRg($militarDependente->militar_id),
                    'dependente'                        => $militarDependente->name,
                    'cpf'                               => $militarDependente->cpf,
                    'decisao_judicial'                  => $this->converterDecisaoJudicial($militarDependente->decisao_judicial),
                    'documento_decisao_judicial'        => $militarDependente->documento_decisao_judicial,
                    'a_contar_de'                       => $militarDependente->decisao_judicial_a_contar_de,
                    'data_casamento'                    => $militarDependente->data_casamento,
                    'data_nascimento'                   => $militarDependente->data_nascimento,
                    'data_inicio_dependencia'           => $militarDependente->data_inicio_dependencia,
                    'data_termino_dependencia'          => $militarDependente->data_termino_dependencia,
                    'numero_processo_validacao'         => $militarDependente->numero_processo_validacao,
                    'data_inicio_contagem'              => $militarDependente->data_inicio_contagem,
                    'data_fim_contagem'                 => $militarDependente->data_fim_contagem,
                    'sexo'                              => $this->converterSexo($militarDependente->sexo_biologico_id),
                    'codigo_parentesco'                 => $militarDependente->parentesco_id,
                    'invalido'                          => $this->converterInvalido($militarDependente->vinculo_permanente),
                    'boletim'                           => $militarDependente->boletim,
                    'unidade'                           => $militarDependente->unidade,
                    'numero_requerimento'               => $militarDependente->numero_requerimento,
                    'data_requerimento'                 => $militarDependente->data_requerimento,
                    'numero_processo'                   => $militarDependente->numero_processo,
                    'data_processo'                     => $militarDependente->data_processo,
                    'observacao'                        => $militarDependente->observacao,
                    'imposto_renda'                     => $militarDependente->imposto_renda,
                    'fundo_saude'                       => $militarDependente->fundo_saude,
                    'acesso_sistema_saude_dependente'   => $militarDependente->acesso_sistema_saude_dependente,
                    'tipo_acesso'                       => $militarDependente->tipo_acesso,
                    'referencia_processo_sei'           => $militarDependente->referencia_processo_sei,
                    'pasep'                             =>  ''
                ]
            );
    }

    private function salvarCbmerj(MilitarDependente $militarDependente)
    {
        DB::connection('cbmerj')
            ->table('dbu_dependentes_teste')
            ->updateOrInsert(
                ['dependente_id'                   => $militarDependente->id],
                [
                    'efetivo_id'                        => $militarDependente->militar_id,
                    'excluido'                          => $militarDependente->excluido,
                    'rg'                                => $this->converterMilitarIdRg($militarDependente->militar_id),
                    'dependente'                        => $militarDependente->name,
                    'cpf'                               => $militarDependente->cpf,
                    'decisao_judicial'                  => $this->converterDecisaoJudicial($militarDependente->decisao_judicial),
                    'documento_decisao_judicial'        => $militarDependente->documento_decisao_judicial,
                    'a_contar_de'                       => $militarDependente->decisao_judicial_a_contar_de,
                    'data_casamento'                    => $militarDependente->data_casamento,
                    'data_nascimento'                   => $militarDependente->data_nascimento,
                    'data_inicio_dependencia'           => $militarDependente->data_inicio_dependencia,
                    'data_termino_dependencia'          => $militarDependente->data_termino_dependencia,
                    'numero_processo_validacao'         => $militarDependente->numero_processo_validacao,
                    'data_inicio_contagem'              => $militarDependente->data_inicio_contagem,
                    'data_fim_contagem'                 => $militarDependente->data_fim_contagem,
                    'sexo'                              => $this->converterSexo($militarDependente->sexo_biologico_id),
                    'parentesco_id'                     => $militarDependente->parentesco_id,
                    'invalido'                          => $this->converterInvalido($militarDependente->vinculo_permanente),
                    'boletim'                           => $militarDependente->boletim,
                    'unidade'                           => $militarDependente->unidade,
                    'numero_requerimento'               => $militarDependente->numero_requerimento,
                    'data_requerimento'                 => $militarDependente->data_requerimento,
                    'numero_processo'                   => $militarDependente->numero_processo,
                    'data_processo'                     => $militarDependente->data_processo,
                    'observacao'                        => $militarDependente->observacao,
                    'imposto_renda'                     => $militarDependente->imposto_renda,
                    'fundo_saude'                       => $militarDependente->fundo_saude,
                    'acesso_sistema_saude_dependente'   => $militarDependente->acesso_sistema_saude_dependente,
                    'tipo_acesso'                       => $militarDependente->tipo_acesso,
                    'referencia_processo_sei'           => $militarDependente->referencia_processo_sei
                ]
            );
    }

    private function gravarLog(string $operacao, string $banco, string $tabela, int $registroId, bool $sucesso, ?string $erro = null)
    {
        DB::table('sincronizacoes')->insert([
            'operacao'    => $operacao,
            'banco'       => $banco,
            'tabela_nome' => $tabela,
            'registro_id' => $registroId,
            'sucesso'     => $sucesso,
            'erro'        => $erro,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }

    private function converterMilitarIdRg(int $militar_id)
    {
        return DB::table('militares')
            ->where('id', $militar_id)
            ->value('rg');
    }

    private function converterDecisaoJudicial($valor)
    {
        if ($valor == 0) {return 'NÃO';}
        if ($valor == 1) {return 'SIM';}

        return 'NÃO';
    }

    private function converterSexo($id)
    {
        $name = DB::table('sexos_biologicos')->where('id', $id)->value('name');

        return $name ? substr($name, 0, 1) : '';
    }

    private function converterInvalido($valor)
    {
        if ($valor == 0) {return 'N';}
        if ($valor == 1) {return 'S';}

        return 'N';
    }
}
