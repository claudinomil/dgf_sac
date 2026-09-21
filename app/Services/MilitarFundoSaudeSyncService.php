<?php

namespace App\Services;

use App\Models\MilitarFundoSaude;
use Illuminate\Support\Facades\DB;

class MilitarFundoSaudeSyncService
{
    public function insert(MilitarFundoSaude $militarFundoSaude)
    {
        $this->executar('INSERT', 'portaldgf', 'sac_fundo_saude_teste', $militarFundoSaude->id, fn() => $this->salvarPortaldgf($militarFundoSaude));
        $this->executar('INSERT', 'cbmerj', 'dbu_fundo_saude_teste', $militarFundoSaude->id, fn() => $this->salvarCbmerj($militarFundoSaude));
    }

    public function update(MilitarFundoSaude $militarFundoSaude)
    {
        $this->executar('UPDATE', 'portaldgf', 'sac_fundo_saude_teste', $militarFundoSaude->id, fn() => $this->salvarPortaldgf($militarFundoSaude));
        $this->executar('UPDATE', 'cbmerj', 'dbu_fundo_saude_teste', $militarFundoSaude->id, fn() => $this->salvarCbmerj($militarFundoSaude));
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

    private function salvarPortaldgf(MilitarFundoSaude $militarFundoSaude)
    {
        DB::connection('portaldgf')
            ->table('sac_fundo_saude_teste')
            ->updateOrInsert(
                ['codigo'                               => $militarFundoSaude->id],
                [
                    'rg'                                => $this->converterMilitarIdRg($militarFundoSaude->militar_id),
                    'cancelar_desconto'                 => $militarFundoSaude->cancelar_desconto,
                    'acesso_sistema_saude'              => $militarFundoSaude->acesso_sistema_saude,
                    'acesso_sistema_saude_documento'    => $militarFundoSaude->acesso_sistema_saude_documento,
                    'data_documento'                    => $militarFundoSaude->data_documento,
                    'tipo_acesso'                       => $militarFundoSaude->tipo_acesso,
                    'tipo_acesso_motivo'                => $militarFundoSaude->tipo_acesso_motivo
                ]
            );
    }

    private function salvarCbmerj(MilitarFundoSaude $militarFundoSaude)
    {
        DB::connection('cbmerj')
            ->table('dbu_fundo_saude_teste')
            ->updateOrInsert(
                ['fundo_saude_id'                       => $militarFundoSaude->id],
                [
                    'efetivo_id'                        => $militarFundoSaude->militar_id,
                    'rg'                                => $this->converterMilitarIdRg($militarFundoSaude->militar_id),
                    'cancelar_desconto'                 => $militarFundoSaude->cancelar_desconto,
                    'acesso_sistema_saude'              => $militarFundoSaude->acesso_sistema_saude,
                    'acesso_sistema_saude_documento'    => $militarFundoSaude->acesso_sistema_saude_documento,
                    'data_documento'                    => $militarFundoSaude->data_documento,
                    'tipo_acesso'                       => $militarFundoSaude->tipo_acesso,
                    'tipo_acesso_motivo'                => $militarFundoSaude->tipo_acesso_motivo
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
