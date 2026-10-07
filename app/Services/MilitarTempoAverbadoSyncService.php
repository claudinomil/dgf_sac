<?php

namespace App\Services;

use App\Models\MilitarTempoAverbado;
use Illuminate\Support\Facades\DB;

class MilitarTempoAverbadoSyncService
{
    public function insert(MilitarTempoAverbado $militarTempoAverbado)
    {
        $this->executar('INSERT', 'portaldgf', 'sac_tempo_averbado_teste', $militarTempoAverbado->id, fn() => $this->salvarPortaldgf($militarTempoAverbado));
    }

    public function update(MilitarTempoAverbado $militarTempoAverbado)
    {
        $this->executar('UPDATE', 'portaldgf', 'sac_tempo_averbado_teste', $militarTempoAverbado->id, fn() => $this->salvarPortaldgf($militarTempoAverbado));
    }

    public function delete(int $id)
    {
        $this->executar('DELETE', 'portaldgf', 'sac_tempo_averbado_teste', $id, function () use ($id) {DB::connection('portaldgf')->table('sac_tempo_averbado_teste')->where('codigo', $id)->delete();});
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

    private function salvarPortaldgf(MilitarTempoAverbado $militarTempoAverbado)
    {
        DB::connection('portaldgf')
            ->table('sac_tempo_averbado_teste')
            ->updateOrInsert(
                ['codigo'                               => $militarTempoAverbado->id],
                [
                    'rg'                                =>  $this->converterMilitarIdRg($militarTempoAverbado->militar_id),
                    'codigo_local'                      =>  $militarTempoAverbado->tempo_averbado_local_id,
                    'data_ingresso_local'               =>  $militarTempoAverbado->data_ingresso_local,
                    'data_termino_local'                =>  $militarTempoAverbado->data_termino_local,
                    'tempo_apurado_local'               =>  $militarTempoAverbado->tempo_apurado_local,
                    'boletim'                           =>  $militarTempoAverbado->boletim,
                    'proderj_servico_publico'           =>  $militarTempoAverbado->proderj_servico_publico,
                    'proderj_servico_publico_rj'        =>  $militarTempoAverbado->proderj_servico_publico_rj,
                    'proderj_servico_cargo'             =>  $militarTempoAverbado->proderj_servico_cargo,
                    'proderj_controle'                  =>  $militarTempoAverbado->proderj_controle,
                    'lancado_proderj'                   =>  $militarTempoAverbado->lancado_proderj,
                    'observacao'                        =>  $militarTempoAverbado->observacao,
                    'referencia_processo_sei'           =>  $militarTempoAverbado->referencia_processo_sei
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
}
