<?php

namespace App\Services;

use App\Models\MilitarAjudaCusto;
use Illuminate\Support\Facades\DB;

class MilitarAjudaCustoSyncService
{
    public function insert(MilitarAjudaCusto $militarAjudaCusto)
    {
        $this->executar('INSERT', 'portaldgf', 'sac_ajuda_custo_teste', $militarAjudaCusto->id, fn() => $this->salvarPortaldgf($militarAjudaCusto));
        $this->executar('INSERT', 'cbmerj', 'dbu_ajuda_custo_teste', $militarAjudaCusto->id, fn() => $this->salvarCbmerj($militarAjudaCusto));
    }

    public function update(MilitarAjudaCusto $militarAjudaCusto)
    {
        $this->executar('UPDATE', 'portaldgf', 'sac_ajuda_custo_teste', $militarAjudaCusto->id, fn() => $this->salvarPortaldgf($militarAjudaCusto));
        $this->executar('UPDATE', 'cbmerj', 'dbu_ajuda_custo_teste', $militarAjudaCusto->id, fn() => $this->salvarCbmerj($militarAjudaCusto));
    }

    public function delete(int $id)
    {
        $this->executar('DELETE', 'portaldgf', 'sac_ajuda_custo_teste', $id, function () use ($id) {DB::connection('portaldgf')->table('sac_ajuda_custo_teste')->where('codigo', $id)->delete();});
        $this->executar('DELETE', 'cbmerj', 'dbu_ajuda_custo_teste', $id, function () use ($id) {DB::connection('cbmerj')->table('dbu_ajuda_custo_teste')->where('ajuda_custo_id', $id)->delete();});
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

    private function salvarPortaldgf(MilitarAjudaCusto $militarAjudaCusto)
    {
        DB::connection('portaldgf')
            ->table('sac_ajuda_custo_teste')
            ->updateOrInsert(
                ['codigo' => $militarAjudaCusto->id],
                [
                    'excluido'                      =>  $militarAjudaCusto->excluido,
                    'rg'                            =>  $this->converterMilitarIdRg($militarAjudaCusto->militar_id),
                    'tipo'                          =>  $this->converterTipo($militarAjudaCusto->ajuda_custo_tipo_id),
                    'curso'                         =>  $militarAjudaCusto->curso,
                    'boletim'                       =>  $militarAjudaCusto->boletim,
                    'pagamento'                     =>  $militarAjudaCusto->pagamento,
                    'pagamento_ordenar'             =>  $militarAjudaCusto->pagamento_ordenar,
                    'observacao'                    =>  $militarAjudaCusto->observacao,
                    'referencia_processo_sei'       =>  $militarAjudaCusto->referencia_processo_sei
                ]
            );
    }

    private function salvarCbmerj(MilitarAjudaCusto $militarAjudaCusto)
    {
        DB::connection('cbmerj')
            ->table('dbu_ajuda_custo_teste')
            ->updateOrInsert(
                ['ajuda_custo_id'                   => $militarAjudaCusto->id],
                [
                    'efetivo_id'                    =>  $militarAjudaCusto->militar_id,
                    'excluido'                      =>  $militarAjudaCusto->excluido,
                    'rg'                            =>  $this->converterMilitarIdRg($militarAjudaCusto->militar_id),
                    'tipo'                          =>  $this->converterTipo($militarAjudaCusto->ajuda_custo_tipo_id),
                    'curso'                         =>  $militarAjudaCusto->curso,
                    'boletim'                       =>  $militarAjudaCusto->boletim,
                    'pagamento'                     =>  $militarAjudaCusto->pagamento,
                    'pagamento_ordenar'             =>  $militarAjudaCusto->pagamento_ordenar,
                    'observacao'                    =>  $militarAjudaCusto->observacao,
                    'referencia_processo_sei'       =>  $militarAjudaCusto->referencia_processo_sei
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

    private function converterTipo(int $ajuda_custo_tipo_id)
    {
        $tipo = DB::table('ajuda_custo_tipos')
            ->where('id', $ajuda_custo_tipo_id)
            ->value('name');

        return getRemoverAcentos($tipo);
    }
}
