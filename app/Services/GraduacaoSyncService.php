<?php

namespace App\Services;

use App\Models\Graduacao;
use Illuminate\Support\Facades\DB;

class GraduacaoSyncService
{
    public function insert(Graduacao $graduacao)
    {
        $this->executar('INSERT', 'portaldgf', 'sac_graduacao_teste', $graduacao->id, fn() => $this->salvarPortaldgf($graduacao));
        $this->executar('INSERT', 'cbmerj', 'dbu_graduacoes_teste', $graduacao->id, fn() => $this->salvarCbmerj($graduacao));
    }

    public function update(Graduacao $graduacao)
    {
        $this->executar('UPDATE', 'portaldgf', 'sac_graduacao_teste', $graduacao->id, fn() => $this->salvarPortaldgf($graduacao));
        $this->executar('UPDATE', 'cbmerj', 'dbu_graduacoes_teste', $graduacao->id, fn() => $this->salvarCbmerj($graduacao));
    }

    public function delete(int $id, ?string $codigo_graduacao)
    {
        $this->executar('DELETE', 'portaldgf', 'sac_graduacao_teste', $id, function () use ($codigo_graduacao) {DB::connection('portaldgf')->table('sac_graduacao_teste')->where('codigo_graduacao', $codigo_graduacao)->delete();});
        $this->executar('DELETE', 'cbmerj', 'dbu_graduacoes_teste', $id, function () use ($id) {DB::connection('cbmerj')->table('dbu_graduacoes_teste')->where('graduacao_id', $id)->delete();});
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

    private function salvarPortaldgf(Graduacao $graduacao)
    {
        DB::connection('portaldgf')
            ->table('sac_graduacao_teste')
            ->updateOrInsert(
                ['codigo_graduacao'     => $graduacao->codigo_graduacao],
                [
                    'graduacao'         => $graduacao->name,
                    'graduacao_abreviacao'  => $graduacao->abreviacao
                ]
            );
    }

    private function salvarCbmerj(Graduacao $graduacao)
    {
        DB::connection('cbmerj')
            ->table('dbu_graduacoes_teste')
            ->updateOrInsert(
                ['graduacao_id'         => $graduacao->id],
                [
                    'graduacao'         => $graduacao->name,
                    'codigo_graduacao'  => $graduacao->codigo_graduacao,
                    'graduacao_abreviacao'        => $graduacao->abreviacao
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
