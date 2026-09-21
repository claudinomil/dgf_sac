<?php

namespace App\Domain\MilitarCurso;

use App\Models\MilitarCurso;
use App\Services\MilitarCursoSyncService;

class MilitarCursoRepository
{
    public function index(int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Return
        $query = MilitarCurso
            ::join('militares', 'militares.id', 'militares_cursos.militar_id')
            ->join('situacoes', 'situacoes.id', 'militares.situacao_id')
            ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->join('unidades', 'unidades.id', 'militares.unidade_id')
            ->join('quadros', 'quadros.id', 'militares.quadro_id')
            ->join('cursos', 'cursos.id', 'militares_cursos.curso_id')
            ->select(
                'militares_cursos.*',
                'militares.nome as militarNome',
                'militares.id as militar_id',
                'militares.rg as militarRg',
                'militares.situacao_id as militarSituacaoId',
                'situacoes.name as militarSituacaoName',
                'graduacoes.name as militarGraduacaoName',
                'quadros.name as militarQuadroName',
                'quadros.especialidade as militarQuadroEspecialidadeName',
                'cursos.name as cursoName'
            );

        // Permissão Situação do Militar
        $query->whereIn('militares.situacao_id', retornaArrayCampoGruposPermissoesSituacoes('militares_cursos_permissoes_list_situacoes_ids'));

        $query->orderBy('cursos.name')->limit($limit);

        return $query->get();
    }

    public function filter($array_dados, int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = MilitarCurso
            ::join('militares', 'militares.id', 'militares_cursos.militar_id')
            ->join('situacoes', 'situacoes.id', 'militares.situacao_id')
            ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->join('unidades', 'unidades.id', 'militares.unidade_id')
            ->join('quadros', 'quadros.id', 'militares.quadro_id')
            ->join('cursos', 'cursos.id', 'militares_cursos.curso_id')
            ->select(
                'militares_cursos.*',
                'militares.nome as militarNome',
                'militares.id as militar_id',
                'militares.rg as militarRg',
                'militares.situacao_id as militarSituacaoId',
                'situacoes.name as militarSituacaoName',
                'graduacoes.name as militarGraduacaoName',
                'quadros.name as militarQuadroName',
                'quadros.especialidade as militarQuadroEspecialidadeName',
                'cursos.name as cursoName'
            )
            ->where(function($query) use($filtros) {
                // Permissão Situação do Militar
                $query->whereIn('militares.situacao_id', retornaArrayCampoGruposPermissoesSituacoes('militares_cursos_permissoes_list_situacoes_ids'));

                // Variavel para controle
                $qtdFiltros = count($filtros) / 4;
                $indexCampo = 0;

                for($i=1; $i<=$qtdFiltros; $i++) {
                    // Valores do Filtro
                    $condicao = $filtros[$indexCampo];
                    $campo = $filtros[$indexCampo+1];
                    $operacao = $filtros[$indexCampo+2];
                    $dado = $filtros[$indexCampo+3];

                    // Operações
                    if ($operacao == 1) {
                        if ($condicao == 1) {$query->where($campo, 'like', '%'.$dado.'%');} else {$query->orwhere($campo, 'like', '%'.$dado.'%');}
                    }

                    if ($operacao == 2) {
                        if ($condicao == 1) {$query->where($campo, '=', $dado);} else {$query->orwhere($campo, '=', $dado);}
                    }

                    if ($operacao == 3) {
                        if ($condicao == 1) {$query->where($campo, '>', $dado);} else {$query->orwhere($campo, '>', $dado);}
                    }

                    if ($operacao == 4) {
                        if ($condicao == 1) {$query->where($campo, '>=', $dado);} else {$query->orwhere($campo, '>=', $dado);}
                    }

                    if ($operacao == 5) {
                        if ($condicao == 1) {$query->where($campo, '<', $dado);} else {$query->orwhere($campo, '<', $dado);}
                    }

                    if ($operacao == 6) {
                        if ($condicao == 1) {$query->where($campo, '<=', $dado);} else {$query->orwhere($campo, '<=', $dado);}
                    }

                    if ($operacao == 7) {
                        if ($condicao == 1) {$query->where($campo, 'like', $dado.'%');} else {$query->orwhere($campo, 'like', $dado.'%');}
                    }

                    if ($operacao == 8) {
                        if ($condicao == 1) {$query->where($campo, 'like', '%'.$dado);} else {$query->orwhere($campo, 'like', '%'.$dado);}
                    }

                    // Atualizar indexCampo
                    $indexCampo = $indexCampo + 4;
                }
            })
            ->orderBy('cursos.name')
            ->limit($limit)
            ->get();

        return $registros;
    }

    public function find(int $id)
    {
        $query = MilitarCurso
            ::join('militares', 'militares.id', 'militares_cursos.militar_id')
            ->join('situacoes', 'situacoes.id', 'militares.situacao_id')
            ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->join('unidades', 'unidades.id', 'militares.unidade_id')
            ->join('quadros', 'quadros.id', 'militares.quadro_id')
            ->join('cursos', 'cursos.id', 'militares_cursos.curso_id')
            ->select(
                'militares_cursos.*',
                'militares.nome as militarNome',
                'militares.id as militar_id',
                'militares.rg as militarRg',
                'militares.identidade_funcional as militarIdentidadeFuncional',
                'militares.situacao_id as militarSituacaoId',
                'situacoes.name as militarSituacaoName',
                'graduacoes.name as militarGraduacaoName',
                'quadros.name as militarQuadroName',
                'quadros.especialidade as militarQuadroEspecialidadeName',
                'cursos.name as cursoName'
            );



        // Permissão Situação do Militar
        // $query->whereIn('militares.situacao_id', retornaArrayCampoGruposPermissoesSituacoes('militares_permissoes_list_situacoes_ids'));


        return $query->find($id);
    }

    public function create(array $data)
    {
        $militar_curso = MilitarCurso::create($data);

        app(MilitarCursoSyncService::class)->insert($militar_curso);

        return $militar_curso;
    }

    public function update(int $id, array $data)
    {
        $militar_curso = $this->find($id);
        $militar_curso->update($data);

        app(MilitarCursoSyncService::class)->update($militar_curso->fresh());

        return $militar_curso;
    }

    public function delete(int $id)
    {
        $militar_curso = $this->find($id);
        $militar_curso->delete();

        app(MilitarCursoSyncService::class)->delete($id);

        return;
    }
}
