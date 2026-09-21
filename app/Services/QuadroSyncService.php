<?php

namespace App\Services;

use App\Models\Quadro;
use Illuminate\Support\Facades\DB;

class QuadroSyncService
{
    public function insert(Quadro $quadro)
    {
        $this->executar('INSERT', 'portaldgf', 'sac_quadros_teste', $quadro->id, fn() => $this->salvarPortaldgf($quadro));
        $this->executar('INSERT', 'cbmerj', 'dbu_quadros_teste', $quadro->id, fn() => $this->salvarCbmerj($quadro));
    }

    public function update(Quadro $quadro)
    {
        $this->executar('UPDATE', 'portaldgf', 'sac_quadros_teste', $quadro->id, fn() => $this->salvarPortaldgf($quadro));
        $this->executar('UPDATE', 'cbmerj', 'dbu_quadros_teste', $quadro->id, fn() => $this->salvarCbmerj($quadro));
    }

    public function delete(int $id, ?string $codigo_quadro)
    {
        $this->executar('DELETE', 'portaldgf', 'sac_quadro_teste', $id, function () use ($codigo_quadro) {DB::connection('portaldgf')->table('sac_quadro_teste')->where('codigo_quadro', $codigo_quadro)->delete();});
        $this->executar('DELETE', 'cbmerj', 'dbu_quadros_teste', $id, function () use ($id) {DB::connection('cbmerj')->table('dbu_quadros_teste')->where('quadro_id', $id)->delete();});
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

    private function salvarPortaldgf(Quadro $quadro)
    {
        DB::connection('portaldgf')
            ->table('sac_quadro_teste')
            ->updateOrInsert(
                ['codigo_quadro'            => $quadro->codigo_quadro],
                [
                    'quadro'                => $quadro->name,
                    'especialidade'         => $quadro->especialidade,
                    'quadro_especialidade'  => $quadro->quadro_especialidade
                ]
            );
    }

    private function salvarCbmerj(Quadro $quadro)
    {
        DB::connection('cbmerj')
            ->table('dbu_quadros_teste')
            ->updateOrInsert(
                ['quadro_id'                => $quadro->id],
                [
                    'quadro'                => $quadro->name,
                    'codigo_quadro'         => $quadro->codigo_quadro,
                    'especialidade'         => $quadro->especialidade,
                    'quadro_especialidade'  => $quadro->quadro_especialidade
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
