<?php

namespace App\Services;

use App\Models\Parentesco;
use Illuminate\Support\Facades\DB;

class ParentescoSyncService
{
    public function insert(Parentesco $parentesco)
    {
        $this->executar('INSERT', 'portaldgf', 'sac_dependentes_parentescos_teste', $parentesco->id, fn() => $this->salvarPortaldgf($parentesco));
        $this->executar('INSERT', 'cbmerj', 'dbu_dependentes_parentescos_teste', $parentesco->id, fn() => $this->salvarCbmerj($parentesco));
    }

    public function update(Parentesco $parentesco)
    {
        $this->executar('UPDATE', 'portaldgf', 'sac_dependentes_parentescos_teste', $parentesco->id, fn() => $this->salvarPortaldgf($parentesco));
        $this->executar('UPDATE', 'cbmerj', 'dbu_dependentes_parentescos_teste', $parentesco->id, fn() => $this->salvarCbmerj($parentesco));
    }

    public function delete(int $id)
    {
        $this->executar('DELETE', 'portaldgf', 'sac_dependentes_parentescos_teste', $id, function () use ($id) {DB::connection('portaldgf')->table('sac_dependentes_parentescos_teste')->where('codigo_parentesco', $id)->delete();});
        $this->executar('DELETE', 'cbmerj', 'dbu_dependentes_parentescos_teste', $id, function () use ($id) {DB::connection('cbmerj')->table('dbu_dependentes_parentescos_teste')->where('parentesco_id', $id)->delete();});
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

    private function salvarPortaldgf(Parentesco $parentesco)
    {
        DB::connection('portaldgf')
            ->table('sac_dependentes_parentescos_teste')
            ->updateOrInsert(
                ['codigo_parentesco'    => $parentesco->id],
                [
                    'parentesco'        => $parentesco->name
                ]
            );
    }

    private function salvarCbmerj(Parentesco $parentesco)
    {
        DB::connection('cbmerj')
            ->table('dbu_dependentes_parentescos_teste')
            ->updateOrInsert(
                ['parentesco_id'        => $parentesco->id],
                [
                    'parentesco'        => $parentesco->name
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
