<?php

namespace App\Services;

use App\Models\Unidade;
use Illuminate\Support\Facades\DB;

class UnidadeSyncService
{
    public function insert(Unidade $unidade)
    {
        $this->executar('INSERT', 'portaldgf', 'sac_unidades_teste', $unidade->id, fn() => $this->salvarPortaldgf($unidade));
        $this->executar('INSERT', 'cbmerj', 'dbu_unidades_teste', $unidade->id, fn() => $this->salvarCbmerj($unidade));
    }

    public function update(Unidade $unidade)
    {
        $this->executar('UPDATE', 'portaldgf', 'sac_unidades_teste', $unidade->id, fn() => $this->salvarPortaldgf($unidade));
        $this->executar('UPDATE', 'cbmerj', 'dbu_unidades_teste', $unidade->id, fn() => $this->salvarCbmerj($unidade));
    }

    public function delete(int $id)
    {
        $this->executar('DELETE', 'portaldgf', 'sac_unidades_teste', $id, function () use ($id) {DB::connection('portaldgf')->table('sac_unidades_teste')->where('unidade_id', $id)->delete();});
        $this->executar('DELETE', 'cbmerj', 'dbu_unidades_teste', $id, function () use ($id) {DB::connection('cbmerj')->table('dbu_unidades_teste')->where('unidade_id', $id)->delete();});
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

    private function salvarPortaldgf(Unidade $unidade)
    {
        DB::connection('portaldgf')
            ->table('sac_unidades_teste')
            ->updateOrInsert(
                ['unidade_id'           => $unidade->id],
                [
                    'unidade'           => $unidade->name,
                    'sigla'             => $unidade->sigla,
                    'codigo_unidade'    => $unidade->codigo_unidade,
                    'situacao'          => $unidade->situacao,
                    'tipo'              => $unidade->tipo
                ]
            );
    }

    private function salvarCbmerj(Unidade $unidade)
    {
        DB::connection('cbmerj')
            ->table('dbu_unidades_teste')
            ->updateOrInsert(
                ['unidade_id'           => $unidade->id],
                [
                    'unidade'           => $unidade->name,
                    'sigla'             => $unidade->sigla,
                    'codigo_unidade'    => $unidade->codigo_unidade,
                    'situacao'          => $unidade->situacao,
                    'tipo'              => $unidade->tipo
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
