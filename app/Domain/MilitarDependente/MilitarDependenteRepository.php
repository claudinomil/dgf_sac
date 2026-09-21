<?php

namespace App\Domain\MilitarDependente;

use App\Models\MilitarDependente;
use App\Services\MilitarDependenteSyncService;

class MilitarDependenteRepository
{
    public function index(int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Return
        $query = MilitarDependente
            ::join('militares', 'militares.id', 'militares_dependentes.militar_id')
            ->join('situacoes', 'situacoes.id', 'militares.situacao_id')
            ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->join('unidades', 'unidades.id', 'militares.unidade_id')
            ->join('quadros', 'quadros.id', 'militares.quadro_id')
            ->join('parentescos', 'parentescos.id', 'militares_dependentes.parentesco_id')
            ->join('sexos_biologicos', 'sexos_biologicos.id', 'militares_dependentes.sexo_biologico_id')
            ->select(
                'militares_dependentes.*',
                'militares.nome as militarNome',
                'militares.id as militar_id',
                'militares.rg as militarRg',
                'militares.situacao_id as militarSituacaoId',
                'situacoes.name as militarSituacaoName',
                'graduacoes.name as militarGraduacaoName',
                'quadros.name as militarQuadroName',
                'quadros.especialidade as militarQuadroEspecialidadeName',
                'parentescos.name as parentescoName',
                'sexos_biologicos.name as sexosBiologicoName'
            );

        // Permissão Situação do Militar
        $query->whereIn('militares.situacao_id', retornaArrayCampoGruposPermissoesSituacoes('militares_dependentes_permissoes_list_situacoes_ids'));

        $query->orderBy('militares_dependentes.name')->limit($limit);

        return $query->get();
    }

    public function filter($array_dados, int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = MilitarDependente
            ::join('militares', 'militares.id', 'militares_dependentes.militar_id')
            ->join('situacoes', 'situacoes.id', 'militares.situacao_id')
            ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->join('unidades', 'unidades.id', 'militares.unidade_id')
            ->join('quadros', 'quadros.id', 'militares.quadro_id')
            ->join('parentescos', 'parentescos.id', 'militares_dependentes.parentesco_id')
            ->join('sexos_biologicos', 'sexos_biologicos.id', 'militares_dependentes.sexo_biologico_id')
            ->select(
                'militares_dependentes.*',
                'militares.nome as militarNome',
                'militares.id as militar_id',
                'militares.rg as militarRg',
                'militares.situacao_id as militarSituacaoId',
                'situacoes.name as militarSituacaoName',
                'graduacoes.name as militarGraduacaoName',
                'quadros.name as militarQuadroName',
                'quadros.especialidade as militarQuadroEspecialidadeName',
                'parentescos.name as parentescoName',
                'sexos_biologicos.name as sexosBiologicoName'
            )
            ->where(function($query) use($filtros) {
                // Permissão Situação do Militar
                $query->whereIn('militares.situacao_id', retornaArrayCampoGruposPermissoesSituacoes('militares_dependentes_permissoes_list_situacoes_ids'));

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
            ->orderBy('militares_dependentes.name')
            ->limit($limit)
            ->get();

        return $registros;
    }

    public function find(int $id)
    {
        $query = MilitarDependente
            ::join('militares', 'militares.id', 'militares_dependentes.militar_id')
            ->join('situacoes', 'situacoes.id', 'militares.situacao_id')
            ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->join('unidades', 'unidades.id', 'militares.unidade_id')
            ->join('quadros', 'quadros.id', 'militares.quadro_id')
            ->join('parentescos', 'parentescos.id', 'militares_dependentes.parentesco_id')
            ->join('sexos_biologicos', 'sexos_biologicos.id', 'militares_dependentes.sexo_biologico_id')
            ->select(
                'militares_dependentes.*',
                'militares.nome as militarNome',
                'militares.id as militar_id',
                'militares.rg as militarRg',
                'militares.identidade_funcional as militarIdentidadeFuncional',
                'militares.situacao_id as militarSituacaoId',
                'situacoes.name as militarSituacaoName',
                'graduacoes.name as militarGraduacaoName',
                'quadros.name as militarQuadroName',
                'quadros.especialidade as militarQuadroEspecialidadeName',
                'parentescos.name as parentescoName',
                'sexos_biologicos.name as sexosBiologicoName'
            );

        // Permissão Situação do Militar
        $query->whereIn('militares.situacao_id', retornaArrayCampoGruposPermissoesSituacoes('militares_dependentes_permissoes_list_situacoes_ids'));


        return $query->find($id);
    }

    public function create(array $data)
    {
        // Campos
        $data['excluido'] = 0;
        $data['acesso_sistema_saude_dependente'] = 1;
        $data['tipo_acesso'] = 1;

        // Criar
        $militar_dependente = MilitarDependente::create($data);

        app(MilitarDependenteSyncService::class)->insert($militar_dependente);

        return $militar_dependente;
    }

    public function update(int $id, array $data)
    {
        $militar_dependente = $this->find($id);
        $militar_dependente->update($data);

        app(MilitarDependenteSyncService::class)->update($militar_dependente->fresh());

        return $militar_dependente;
    }

    public function delete(int $id)
    {
        $militar_dependente = $this->find($id);
        $militar_dependente->delete();

        app(MilitarDependenteSyncService::class)->delete($id);

        return;
    }
}
