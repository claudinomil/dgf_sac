<?php

namespace App\Services;

use App\Models\TempoAverbadoLocal;
use Illuminate\Support\Facades\DB;

class TempoAverbadoLocalSyncService
{
    public function insert(TempoAverbadoLocal $tempo_averbado_local)
    {
        $this->executar('INSERT', 'portaldgf', 'sac_tempo_averbado_locais_teste', $tempo_averbado_local->id, fn() => $this->salvarPortaldgf($tempo_averbado_local));
    }

    public function update(TempoAverbadoLocal $tempo_averbado_local)
    {
        $this->executar('UPDATE', 'portaldgf', 'sac_tempo_averbado_locais_teste', $tempo_averbado_local->id, fn() => $this->salvarPortaldgf($tempo_averbado_local));
    }

    public function delete(int $id)
    {
        $this->executar('DELETE', 'portaldgf', 'sac_tempo_averbado_locais_teste', $id, function () use ($id) {DB::connection('portaldgf')->table('sac_tempos_averbados_locais_teste')->where('codigo', $id)->delete();});
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

    private function salvarPortaldgf(TempoAverbadoLocal $tempo_averbado_local)
    {
        DB::connection('portaldgf')
            ->table('sac_tempo_averbado_locais_teste')
            ->updateOrInsert(
                ['codigo_averbacao'             => $tempo_averbado_local->id],
                [
                    'local'                     => $tempo_averbado_local->name,
                    'tipo'                      => $this->converterTipo($tempo_averbado_local->tipo)
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

    private function converterTipo($valor)
    {
        if ($valor == 1) {return 'SERVICO PUBLICO';}
        if ($valor == 2) {return 'SERVICO PUBLICO RJ';}

        return null;
    }
}