<?php

namespace App\Services;

use App\Models\Situacao;
use Illuminate\Support\Facades\DB;

class SituacaoSyncService
{
    public function insert(Situacao $situacao)
    {
        $this->executar('INSERT', 'portaldgf', 'sac_situacao_teste', $situacao->id, fn() => $this->salvarPortaldgf($situacao));
        $this->executar('INSERT', 'cbmerj', 'dbu_situacoes_teste', $situacao->id, fn() => $this->salvarCbmerj($situacao));
    }

    public function update(Situacao $situacao)
    {
        $this->executar('UPDATE', 'portaldgf', 'sac_situacao_teste', $situacao->id, fn() => $this->salvarPortaldgf($situacao));
        $this->executar('UPDATE', 'cbmerj', 'dbu_situacoes_teste', $situacao->id, fn() => $this->salvarCbmerj($situacao));
    }

    public function delete(int $id)
    {
        $this->executar('DELETE', 'portaldgf', 'sac_situacao_teste', $id, function () use ($id) {DB::connection('portaldgf')->table('sac_situacao_teste')->where('ordem_dbu', $id)->delete();});
        $this->executar('DELETE', 'cbmerj', 'dbu_situacoes_teste', $id, function () use ($id) {DB::connection('cbmerj')->table('dbu_situacoes_teste')->where('situacao_id', $id)->delete();});
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

    private function salvarPortaldgf(Situacao $situacao)
    {
        DB::connection('portaldgf')
            ->table('sac_situacao_teste')
            ->updateOrInsert(
                ['ordem_dbu'            => $situacao->id],   
                [
                    'situacao'          => $situacao->name,
                    'codigo_situacao'   => $situacao->codigo_situacao
                ]
            );
    }

    private function salvarCbmerj(Situacao $situacao)
    {
        DB::connection('cbmerj')
            ->table('dbu_situacoes_teste')
            ->updateOrInsert(
                ['situacao_id'          => $situacao->id],
                [
                    'situacao'          => $situacao->name,
                    'codigo_situacao'   => $situacao->codigo_situacao
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
