<?php

namespace App\Services;

use App\Models\MilitarFerias;
use Illuminate\Support\Facades\DB;

class MilitarFeriasSyncService
{
    public function insert(MilitarFerias $militarFerias)
    {
        $this->executar('INSERT', 'portaldgf', 'sac_ferias_teste', $militarFerias->id, fn() => $this->salvarPortaldgf($militarFerias));
    }

    public function update(MilitarFerias $militarFerias)
    {
        $this->executar('UPDATE', 'portaldgf', 'sac_ferias_teste', $militarFerias->id, fn() => $this->salvarPortaldgf($militarFerias));
    }

    public function delete(int $id)
    {
        $this->executar('DELETE', 'portaldgf', 'sac_ferias_teste', $id, function () use ($id) {DB::connection('portaldgf')->table('sac_ferias_teste')->where('codigo', $id)->delete();});
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

    private function salvarPortaldgf(MilitarFerias $militarFerias)
    {
        DB::connection('portaldgf')
            ->table('sac_ferias_teste')
            ->updateOrInsert(
                ['codigo' => $militarFerias->id],
                [
                    'rg'                                =>  $this->converterMilitarIdRg($militarFerias->militar_id),
                    'mes'                               =>  $militarFerias->mes,
                    'ano'                               =>  $militarFerias->ano,
                    'referencia'                        =>  $militarFerias->referencia,
                    'boletim'                           =>  $militarFerias->boletim,
                    'documento'                         =>  $militarFerias->documento,
                    'unidade'                           =>  $militarFerias->unidade,
                    'observacao'                        =>  $militarFerias->observacao
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
