<?php

namespace App\Services;

use App\Models\Comportamento;
use Illuminate\Support\Facades\DB;

class ComportamentoSyncService
{
    public function insert(Comportamento $comportamento)
    {
        $this->executar('INSERT', 'portaldgf', 'sac_comportamentos_teste', $comportamento->id, fn() => $this->salvarPortaldgf($comportamento));
        $this->executar('INSERT', 'cbmerj', 'dbu_comportamentos_teste', $comportamento->id, fn() => $this->salvarCbmerj($comportamento));
    }

    public function update(Comportamento $comportamento)
    {
        $this->executar('UPDATE', 'portaldgf', 'sac_comportamentos_teste', $comportamento->id, fn() => $this->salvarPortaldgf($comportamento));
        $this->executar('UPDATE', 'cbmerj', 'dbu_comportamentos_teste', $comportamento->id, fn() => $this->salvarCbmerj($comportamento));
    }

    public function delete(int $id)
    {
        $this->executar('DELETE', 'portaldgf', 'sac_comportamentos_teste', $id, function () use ($id) {DB::connection('portaldgf')->table('sac_comportamentos_teste')->where('comportamento_id', $id)->delete();});
        $this->executar('DELETE', 'cbmerj', 'dbu_comportamentos_teste', $id, function () use ($id) {DB::connection('cbmerj')->table('dbu_comportamentos_teste')->where('comportamento_id', $id)->delete();});
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

    private function salvarPortaldgf(Comportamento $comportamento)
    {
        DB::connection('portaldgf')
            ->table('sac_comportamentos_teste')
            ->updateOrInsert(
                ['comportamento_id'         => $comportamento->id],   
                [
                    'comportamento'         => $comportamento->name
                ]
            );
    }

    private function salvarCbmerj(Comportamento $comportamento)
    {
        DB::connection('cbmerj')
            ->table('dbu_comportamentos_teste')
            ->updateOrInsert(
                ['comportamento_id'          => $comportamento->id],
                [
                    'comportamento'          => $comportamento->name
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
}
