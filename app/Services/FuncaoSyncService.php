<?php

namespace App\Services;

use App\Models\Funcao;
use Illuminate\Support\Facades\DB;

class FuncaoSyncService
{
    public function insert(Funcao $funcao)
    {
        $this->executar('INSERT', 'portaldgf', 'sac_funcoes_teste', $funcao->id, fn() => $this->salvarPortaldgf($funcao));
        $this->executar('INSERT', 'cbmerj', 'dbu_funcoes_teste', $funcao->id, fn() => $this->salvarCbmerj($funcao));
    }

    public function update(Funcao $funcao)
    {
        $this->executar('UPDATE', 'portaldgf', 'sac_funcoes_teste', $funcao->id, fn() => $this->salvarPortaldgf($funcao));
        $this->executar('UPDATE', 'cbmerj', 'dbu_funcoes_teste', $funcao->id, fn() => $this->salvarCbmerj($funcao));
    }

    public function delete(int $id)
    {
        $this->executar('DELETE', 'portaldgf', 'sac_funcoes_teste', $id, function () use ($id) {DB::connection('portaldgf')->table('sac_funcoes_teste')->where('funcao_id', $id)->delete();});
        $this->executar('DELETE', 'cbmerj', 'dbu_funcoes_teste', $id, function () use ($id) {DB::connection('cbmerj')->table('dbu_funcoes_teste')->where('funcao_id', $id)->delete();});
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

    private function salvarPortaldgf(Funcao $funcao)
    {
        DB::connection('portaldgf')
            ->table('sac_funcoes_teste')
            ->updateOrInsert(
                ['funcao_id'         => $funcao->id],
                [
                    'funcao'         => $funcao->name
                ]
            );
    }

    private function salvarCbmerj(Funcao $funcao)
    {
        DB::connection('cbmerj')
            ->table('dbu_funcoes_teste')
            ->updateOrInsert(
                ['funcao_id'          => $funcao->id],
                [
                    'funcao'          => $funcao->name
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
