<?php

namespace App\Services;

use App\Models\Curso;
use Illuminate\Support\Facades\DB;

class CursoSyncService
{
    public function insert(Curso $curso)
    {
        $this->executar('INSERT', 'portaldgf', 'sac_cursos_teste', $curso->id, fn() => $this->salvarPortaldgf($curso));
        $this->executar('INSERT', 'cbmerj', 'dbu_cursos_teste', $curso->id, fn() => $this->salvarCbmerj($curso));
    }

    public function update(Curso $curso)
    {
        $this->executar('UPDATE', 'portaldgf', 'sac_cursos_teste', $curso->id, fn() => $this->salvarPortaldgf($curso));
        $this->executar('UPDATE', 'cbmerj', 'dbu_cursos_teste', $curso->id, fn() => $this->salvarCbmerj($curso));
    }

    public function delete(int $id)
    {
        $this->executar('DELETE', 'portaldgf', 'sac_cursos_teste', $id, function () use ($id) {DB::connection('portaldgf')->table('sac_cursos_teste')->where('codigo', $id)->delete();});
        $this->executar('DELETE', 'cbmerj', 'dbu_cursos_teste', $id, function () use ($id) {DB::connection('cbmerj')->table('dbu_cursos_teste')->where('curso_id', $id)->delete();});
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

    private function salvarPortaldgf(Curso $curso)
    {
        DB::connection('portaldgf')
            ->table('sac_cursos_teste')
            ->updateOrInsert(
                ['codigo'           => $curso->id],
                [
                    'curso'         => $curso->name,
                    'tipo'          => $this->converterTipo($curso->tipo),
                    'abreviacao'    => $curso->abreviacao,
                    'oficial_praca' => $this->converterOficialPraca($curso->oficial_praca),
                    'percentual'    => $curso->percentual
                ]
            );
    }

    private function salvarCbmerj(Curso $curso)
    {
        DB::connection('cbmerj')
            ->table('dbu_cursos_teste')
            ->updateOrInsert(
                ['curso_id'          => $curso->id],
                [
                    'curso'         => $curso->name,
                    'tipo'          => $curso->tipo,
                    'abreviacao'    => $curso->abreviacao,
                    'oficial_praca' => $curso->oficial_praca,
                    'percentual'    => $curso->percentual
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

    private function converterTipo($valor)
    {
        if ($valor == 1) {return 'ESPECIAL';}
        if ($valor == 2) {return 'ESPECIALIZAÇÃO';}
        if ($valor == 3) {return 'REGULAR';}

        return null;
    }

    private function converterOficialPraca($valor)
    {
        if ($valor == 1) {return 'OFICIAL';}
        if ($valor == 2) {return 'PRAÇA';}
        if ($valor == 3) {return 'OFICIAL/PRAÇA';}

        return null;
    }
}
