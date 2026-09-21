<?php

namespace App\Services;

use App\Models\MilitarCurso;
use Illuminate\Support\Facades\DB;

class MilitarCursoSyncService
{
    public function insert(MilitarCurso $militarCurso)
    {
        $this->executar('INSERT', 'portaldgf', 'sac_cursos_concluidos_teste', $militarCurso->id, fn() => $this->salvarPortaldgf($militarCurso));
        $this->executar('INSERT', 'cbmerj', 'dbu_cursos_concluidos_teste', $militarCurso->id, fn() => $this->salvarCbmerj($militarCurso));
    }

    public function update(MilitarCurso $militarCurso)
    {
        $this->executar('UPDATE', 'portaldgf', 'sac_cursos_concluidos_teste', $militarCurso->id, fn() => $this->salvarPortaldgf($militarCurso));
        $this->executar('UPDATE', 'cbmerj', 'dbu_cursos_concluidos_teste', $militarCurso->id, fn() => $this->salvarCbmerj($militarCurso));
    }

    public function delete(int $id)
    {
        $this->executar('DELETE', 'portaldgf', 'sac_cursos_concluidos_teste', $id, function () use ($id) {DB::connection('portaldgf')->table('sac_cursos_concluidos_teste')->where('codigo', $id)->delete();});
        $this->executar('DELETE', 'cbmerj', 'dbu_cursos_concluidos_teste', $id, function () use ($id) {DB::connection('cbmerj')->table('dbu_cursos_concluidos_teste')->where('curso_concluido_id', $id)->delete();});
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

    private function salvarPortaldgf(MilitarCurso $militarCurso)
    {
        DB::connection('portaldgf')
            ->table('sac_cursos_concluidos_teste')
            ->updateOrInsert(
                ['codigo' => $militarCurso->id],
                [
                    'rg'                                =>  $this->converterMilitarIdRg($militarCurso->militar_id),
                    'codigo_curso'                      =>  $militarCurso->curso_id,
                    'data_inicio'                       =>  $militarCurso->data_inicio,
                    'data_termino'                      =>  $militarCurso->data_termino,
                    'boletim'                           =>  $militarCurso->boletim,
                    'conceito'                          =>  $militarCurso->conceito,
                    'classificacao'                     =>  $militarCurso->classificacao
                ]
            );
    }

    private function salvarCbmerj(MilitarCurso $militarCurso)
    {
        DB::connection('cbmerj')
            ->table('dbu_cursos_concluidos_teste')
            ->updateOrInsert(
                ['curso_concluido_id'                   => $militarCurso->id],
                [
                    'efetivo_id'                        =>  $militarCurso->militar_id,
                    'rg'                                =>  $this->converterMilitarIdRg($militarCurso->militar_id),
                    'curso_id'                          =>  $militarCurso->curso_id,
                    'data_inicio'                       =>  $militarCurso->data_inicio,
                    'data_termino'                      =>  $militarCurso->data_termino,
                    'boletim'                           =>  $militarCurso->boletim,
                    'conceito'                          =>  $militarCurso->conceito,
                    'classificacao'                     =>  $militarCurso->classificacao
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
