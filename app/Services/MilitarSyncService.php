<?php

namespace App\Services;

use App\Models\Militar;
use Illuminate\Support\Facades\DB;

class MilitarSyncService
{
    public function insert(Militar $militar)
    {
        $this->executar('INSERT', 'portaldgf', 'sac_efetivo_teste', $militar->id, fn() => $this->salvarPortaldgf($militar));
        $this->executar('INSERT', 'cbmerj', 'dbu_efetivo_teste', $militar->id, fn() => $this->salvarCbmerj($militar));
    }

    public function update(Militar $militar)
    {
        $this->executar('UPDATE', 'portaldgf', 'sac_efetivo_teste', $militar->id, fn() => $this->salvarPortaldgf($militar));
        $this->executar('UPDATE', 'cbmerj', 'dbu_efetivo_teste', $militar->id, fn() => $this->salvarCbmerj($militar));
    }

    public function delete($id)
    {
        $this->executar('DELETE', 'portaldgf', 'sac_efetivo_teste', $id, function () use ($id) {DB::connection('portaldgf')->table('sac_efetivo_teste')->where('efetivo_id', $id)->delete();});
        $this->executar('DELETE', 'cbmerj', 'dbu_efetivo_teste', $id, function () use ($id) {DB::connection('cbmerj')->table('dbu_efetivo_teste')->where('efetivo_id', $id)->delete();});
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

    private function salvarPortaldgf(Militar $militar)
    {
        DB::connection('portaldgf')
            ->table('sac_efetivo_teste')
            ->updateOrInsert(
                ['efetivo_id' => $militar->id],
                [
                    'codigo_situacao'                   =>  $this->converterSituacao($militar->situacao_id),
                    'codigo_graduacao'                  =>  $this->converterGraduacao($militar->graduacao_id),
                    'codigo_unidade'                    =>  $this->converterUnidade($militar->unidade_id),
                    'codigo_quadro'                     =>  $this->converterQuadro($militar->quadro_id),
                    'rg'                                =>  $militar->rg,
                    'nome'                              =>  $militar->nome,
                    'sexo'                              =>  $this->converterSexo($militar->sexo_biologico_id),
                    'boletim_situacao'                  =>  $this->converterBoletim($militar->boletim_situacao),
                    'boletim_quadro'                    =>  $this->converterBoletim($militar->boletim_quadro),
                    'boletim_promocao'                  =>  $this->converterBoletim($militar->boletim_graduacao),
                    'data_ingresso'                     =>  $militar->data_ingresso,
                    'boletim_ingresso'                  =>  $this->converterBoletim($militar->boletim_ingresso),
                    'data_segunda_praca'                =>  $militar->data_segunda_praca,
                    'boletim_segunda_praca'             =>  $this->converterBoletim($militar->boletim_segunda_praca),
                    'nome_guerra'                       =>  $militar->nome_guerra,
                    'boletim_movimentacao'              =>  $this->converterBoletim($militar->boletim_movimentacao),
                    'codigo_prestando_servico'          =>  $this->converterUnidade($militar->prestando_servico_id),
                    'boletim_prestando_servico'         =>  $this->converterBoletim($militar->boletim_prestando_servico),
                    'funcao'                            =>  $this->converterFuncao($militar->funcao_id),
                    'banco'                             =>  $this->converterBanco($militar->banco_id),
                    'agencia'                           =>  $militar->agencia,
                    'conta_corrente'                    =>  $militar->conta_corrente,
                    'cpf'                               =>  $militar->cpf,
                    'pasep'                             =>  $militar->pasep,
                    'pai'                               =>  $militar->pai,
                    'estado_civil'                      =>  $this->converterEstadoCivil($militar->estado_civil_id),
                    'mae'                               =>  $militar->mae,
                    'data_nascimento'                   =>  $militar->data_nascimento,
                    'aniversario'                       =>  $militar->aniversario,
                    'comportamento'                     =>  $this->converterComportamento($militar->comportamento_id),
                    'tipo_sanguineo'                    =>  $this->converterTipoSanguineo($militar->tipo_sanguineo_id),
                    'fator_rh'                          =>  $this->converterFatorRh($militar->fator_rh_id),
                    'titulo_eleitoral'                  =>  $militar->titulo_eleitoral,
                    'titulo_eleitoral_zona'             =>  $militar->titulo_eleitoral_zona,
                    'titulo_eleitoral_secao'            =>  $militar->titulo_eleitoral_secao,
                    'titulo_eleitoral_uf'               =>  $militar->titulo_eleitoral_uf,
                    'certificado_reservista'            =>  $militar->certificado_reservista,
                    'certificado_reservista_serie'      =>  $militar->certificado_reservista_serie,
                    'certificado_reservista_categoria'  =>  $militar->certificado_reservista_categoria,
                    'identidade_funcional'              =>  $militar->identidade_funcional,
                    'vinculo'                           =>  $militar->vinculo,
                    'nacionalidade_id'                  =>  $militar->nacionalidade_id,
                    'naturalidade_id'                   =>  $militar->naturalidade_id,
                    'grau_escolaridade_id'              =>  $militar->escolaridade_id,
                    'temporario'                        =>  $militar->temporario
                ]
            );
    }

    private function salvarCbmerj(Militar $militar)
    {
        DB::connection('cbmerj')
            ->table('dbu_efetivo_teste')
            ->updateOrInsert(
                ['efetivo_id' => $militar->id],
                [
                    'situacao_id'                       =>  $militar->situacao_id,
                    'boletim_situacao'                  =>  $this->converterBoletim($militar->boletim_situacao),
                    'graduacao_id'                      =>  $militar->graduacao_id,
                    'boletim_graduacao'                 =>  $this->converterBoletim($militar->boletim_graduacao),
                    'unidade_id'                        =>  $militar->unidade_id,
                    'boletim_movimentacao'              =>  $this->converterBoletim($militar->boletim_movimentacao),
                    'quadro_id'                         =>  $militar->quadro_id,
                    'boletim_quadro'                    =>  $this->converterBoletim($militar->boletim_quadro),
                    'rg'                                =>  $militar->rg,
                    'nome'                              =>  $militar->nome,
                    'sexo'                              =>  $this->converterSexo($militar->sexo_biologico_id),
                    'data_ingresso'                     =>  $militar->data_ingresso,
                    'boletim_ingresso'                  =>  $this->converterBoletim($militar->boletim_ingresso),
                    'data_segunda_praca'                =>  $militar->data_segunda_praca,
                    'boletim_segunda_praca'             =>  $this->converterBoletim($militar->boletim_segunda_praca),
                    'nome_guerra'                       =>  $militar->nome_guerra,
                    'prestando_servico_id'              =>  $militar->prestando_servico_id,
                    'boletim_prestando_servico'         =>  $this->converterBoletim($militar->boletim_prestando_servico),
                    'funcao_id'                         =>  $this->converterZero($militar->funcao_id),
                    'boletim_funcao'                    =>  $this->converterBoletim($militar->boletim_funcao),
                    'banco'                             =>  $this->converterBanco($militar->banco_id),
                    'agencia'                           =>  $militar->agencia,
                    'conta_corrente'                    =>  $militar->conta_corrente,
                    'cpf'                               =>  $militar->cpf,
                    'pasep'                             =>  $militar->pasep,
                    'pai'                               =>  $militar->pai,
                    'estado_civil_id'                   =>  $this->converterZero($militar->estado_civil_id),
                    'mae'                               =>  $militar->mae,
                    'data_nascimento'                   =>  $militar->data_nascimento,
                    'aniversario'                       =>  $militar->aniversario,
                    'comportamento_id'                  =>  $this->converterZero($militar->comportamento_id),
                    'boletim_comportamento'             =>  $this->converterBoletim($militar->boletim_comportamento),
                    'altura'                            =>  $militar->altura,
                    'tipo_sanguineo_id'                 =>  $this->converterZero($militar->tipo_sanguineo_id),
                    'fator_rh_id'                       =>  $this->converterZero($militar->fator_rh_id),
                    'titulo_eleitoral'                  =>  $militar->titulo_eleitoral,
                    'titulo_eleitoral_zona'             =>  $militar->titulo_eleitoral_zona,
                    'titulo_eleitoral_secao'            =>  $militar->titulo_eleitoral_secao,
                    'titulo_eleitoral_uf'               =>  $militar->titulo_eleitoral_uf,
                    'certificado_reservista'            =>  $militar->certificado_reservista,
                    'certificado_reservista_serie'      =>  $militar->certificado_reservista_serie,
                    'certificado_reservista_categoria'  =>  $militar->certificado_reservista_categoria,
                    'identidade_funcional'              =>  $militar->identidade_funcional,
                    'vinculo'                           =>  $militar->vinculo,
                    'temporario'                        =>  $militar->temporario,
                    'nacionalidade_id'                  =>  $this->converterZero($militar->nacionalidade_id),
                    'naturalidade_id'                   =>  $this->converterZero($militar->naturalidade_id),
                    'escolaridade_id'                   =>  $this->converterZero($militar->escolaridade_id)
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

    private function converterSituacao($id)
    {
        return DB::table('situacoes')
            ->where('id', $id)
            ->value('codigo_situacao');
    }

    private function converterGraduacao($id)
    {
        return DB::table('graduacoes')
            ->where('id', $id)
            ->value('codigo_graduacao');
    }

    private function converterUnidade($id)
    {
        return DB::table('unidades')
            ->where('id', $id)
            ->value('codigo_unidade');
    }

    private function converterQuadro($id)
    {
        return DB::table('quadros')
            ->where('id', $id)
            ->value('codigo_quadro');
    }

    private function converterSexo($id)
    {
        $name = DB::table('sexos_biologicos')->where('id', $id)->value('name');

        return $name ? substr($name, 0, 1) : '';
    }

    private function converterFuncao($id)
    {
        return DB::table('funcoes')
            ->where('id', $id)
            ->value('name');
    }

    private function converterBanco($id)
    {
        return '237';

        // return DB::table('bancos')
        //     ->where('id', $id)
        //     ->value('name');
        
    }

    private function converterEstadoCivil($id)
    {
        return DB::table('estados_civis')
            ->where('id', $id)
            ->value('name');
    }

    private function converterComportamento($id)
    {
        return DB::table('comportamentos')
            ->where('id', $id)
            ->value('name');
    }

    private function converterTipoSanguineo($id)
    {
        return DB::table('tipos_sanguineos')
            ->where('id', $id)
            ->value('name');
    }

    private function converterFatorRh($id)
    {
        return DB::table('fatores_rh')
            ->where('id', $id)
            ->value('name');
    }

    private function converterBoletim($boletim)
    {
        return blank($boletim) ? '111-11/11/1111' : $boletim;
    }

    // Retorna Zero se $id não definido
    private function converterZero($id)
    {
        return blank($id) ? 0 : $id;
    }
}
