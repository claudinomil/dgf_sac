<?php

namespace App\Services;

use App\Models\MilitarPensao;
use Illuminate\Support\Facades\DB;

class MilitarPensaoSyncService
{
    public function insert(MilitarPensao $militarPensao)
    {
        $this->executar('INSERT', 'portaldgf', 'sac_pensoes_teste', $militarPensao->id, fn() => $this->salvarPortaldgf($militarPensao));
    }

    public function update(MilitarPensao $militarPensao)
    {
        $this->executar('UPDATE', 'portaldgf', 'sac_pensoes_teste', $militarPensao->id, fn() => $this->salvarPortaldgf($militarPensao));
    }

    public function delete(int $id)
    {
        $this->executar('DELETE', 'portaldgf', 'sac_pensoes_teste', $id, function () use ($id) {DB::connection('portaldgf')->table('sac_pensoes_teste')->where('codigo', $id)->delete();});
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

    private function salvarPortaldgf(MilitarPensao $militarPensao)
    {
        DB::connection('portaldgf')
            ->table('sac_pensoes_teste')
            ->updateOrInsert(
                ['codigo'                       => $militarPensao->id],
                [
                    'rg'                        =>  $this->converterMilitarIdRg($militarPensao->militar_id),
                    'tipo_pensao'               =>  $militarPensao->pensao_tipo_id,
                    'nome_militar'              =>  $militarPensao->nome_militar,
                    'beneficiario'              =>  $militarPensao->beneficiario,
                    'desconto'                  =>  $militarPensao->desconto,
                    'representante_legal'       =>  $militarPensao->representante_legal,
                    'logradouro'                =>  $militarPensao->logradouro,
                    'bairro'                    =>  $militarPensao->bairro,
                    'cidade'                    =>  $militarPensao->cidade,
                    'estado'                    =>  $militarPensao->estado,
                    'cep'                       =>  $militarPensao->cep,
                    'telefone'                  =>  $militarPensao->telefone,
                    'celular'                   =>  $militarPensao->celular,
                    'banco'                     =>  $militarPensao->banco,
                    'agencia'                   =>  $militarPensao->agencia,
                    'conta_corrente'            =>  $militarPensao->conta_corrente,
                    'cpf'                       =>  $militarPensao->cpf,
                    'documento'                 =>  $militarPensao->documento,
                    'data_documento'            =>  $militarPensao->data_documento,
                    'numero_processo'           =>  $militarPensao->numero_processo,
                    'vara_familia'              =>  $militarPensao->vara_familia,
                    'implantacao'               =>  $militarPensao->implantacao,
                    'nascimento'                =>  $militarPensao->nascimento,
                    'cancelar_em'               =>  $militarPensao->cancelar_em,
                    'alterar_em'                =>  $militarPensao->alterar_em,
                    'nascimento_beneficiario'   =>  $militarPensao->nascimento_beneficiario,
                    'cpf_beneficiario'          =>  $militarPensao->cpf_beneficiario,
                    'pasta_dip'                 =>  $militarPensao->pasta_dip,
                    'observacao'                =>  $militarPensao->observacao,
                    'referencia_processo_sei'   =>  $militarPensao->referencia_processo_sei
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