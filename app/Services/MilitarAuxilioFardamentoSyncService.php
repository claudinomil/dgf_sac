<?php

namespace App\Services;

use App\Models\MilitarAuxilioFardamento;
use Illuminate\Support\Facades\DB;

class MilitarAuxilioFardamentoSyncService
{
    public function insert(MilitarAuxilioFardamento $militarAuxilioFardamento)
    {
        $this->executar('INSERT', 'portaldgf', 'sac_auxilio_fardamento_teste', $militarAuxilioFardamento->id, fn() => $this->salvarPortaldgf($militarAuxilioFardamento));
        $this->executar('INSERT', 'cbmerj', 'dbu_auxilio_fardamento_teste', $militarAuxilioFardamento->id, fn() => $this->salvarCbmerj($militarAuxilioFardamento));
    }

    public function update(MilitarAuxilioFardamento $militarAuxilioFardamento)
    {
        $this->executar('UPDATE', 'portaldgf', 'sac_auxilio_fardamento_teste', $militarAuxilioFardamento->id, fn() => $this->salvarPortaldgf($militarAuxilioFardamento));
        $this->executar('UPDATE', 'cbmerj', 'dbu_auxilio_fardamento_teste', $militarAuxilioFardamento->id, fn() => $this->salvarCbmerj($militarAuxilioFardamento));
    }

    public function delete(int $id)
    {
        $this->executar('DELETE', 'portaldgf', 'sac_auxilio_fardamento_teste', $id, function () use ($id) {DB::connection('portaldgf')->table('sac_auxilio_fardamento_teste')->where('codigo', $id)->delete();});
        $this->executar('DELETE', 'cbmerj', 'dbu_auxilio_fardamento_teste', $id, function () use ($id) {DB::connection('cbmerj')->table('dbu_auxilio_fardamento_teste')->where('auxilio_fardamento_id', $id)->delete();});
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

    private function salvarPortaldgf(MilitarAuxilioFardamento $militarAuxilioFardamento)
    {
        DB::connection('portaldgf')
            ->table('sac_auxilio_fardamento_teste')
            ->updateOrInsert(
                ['codigo' => $militarAuxilioFardamento->id],
                [
                    'excluido'                      =>  $militarAuxilioFardamento->excluido,
                    'rg'                            =>  $this->converterMilitarIdRg($militarAuxilioFardamento->militar_id),
                    'tipo'                          =>  $this->converterTipo($militarAuxilioFardamento->auxilio_fardamento_tipo_id),
                    'boletim'                       =>  $militarAuxilioFardamento->boletim,
                    'pagamento'                     =>  $militarAuxilioFardamento->pagamento,
                    'pagamento_ordenar'             =>  $militarAuxilioFardamento->pagamento_ordenar,
                    'observacao'                    =>  $militarAuxilioFardamento->observacao,
                    'referencia_processo_sei'       =>  $militarAuxilioFardamento->referencia_processo_sei
                ]
            );
    }

    private function salvarCbmerj(MilitarAuxilioFardamento $militarAuxilioFardamento)
    {
        DB::connection('cbmerj')
            ->table('dbu_auxilio_fardamento_teste')
            ->updateOrInsert(
                ['auxilio_fardamento_id'            => $militarAuxilioFardamento->id],
                [
                    'efetivo_id'                    =>  $militarAuxilioFardamento->militar_id,
                    'excluido'                      =>  $militarAuxilioFardamento->excluido,
                    'rg'                            =>  $this->converterMilitarIdRg($militarAuxilioFardamento->militar_id),
                    'tipo'                          =>  $this->converterTipo($militarAuxilioFardamento->auxilio_fardamento_tipo_id),
                    'boletim'                       =>  $militarAuxilioFardamento->boletim,
                    'pagamento'                     =>  $militarAuxilioFardamento->pagamento,
                    'pagamento_ordenar'             =>  $militarAuxilioFardamento->pagamento_ordenar,
                    'observacao'                    =>  $militarAuxilioFardamento->observacao,
                    'referencia_processo_sei'       =>  $militarAuxilioFardamento->referencia_processo_sei
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

    private function converterTipo(int $auxilio_fardamento_tipo_id)
    {
        $tipo = DB::table('auxilio_fardamento_tipos')
            ->where('id', $auxilio_fardamento_tipo_id)
            ->value('name');

        return getRemoverAcentos($tipo);
    }
}
