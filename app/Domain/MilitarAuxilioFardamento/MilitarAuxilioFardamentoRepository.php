<?php

namespace App\Domain\MilitarAuxilioFardamento;

use App\Models\MilitarAuxilioFardamento;
use App\Services\MilitarAuxilioFardamentoSyncService;

class MilitarAuxilioFardamentoRepository
{
    public function index(int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Return
        $query = MilitarAuxilioFardamento
            ::join('militares', 'militares.id', 'militares_auxilios_fardamentos.militar_id')
            ->join('situacoes', 'situacoes.id', 'militares.situacao_id')
            ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->join('unidades', 'unidades.id', 'militares.unidade_id')
            ->join('quadros', 'quadros.id', 'militares.quadro_id')
            ->join('auxilio_fardamento_tipos', 'auxilio_fardamento_tipos.id', 'militares_auxilios_fardamentos.auxilio_fardamento_tipo_id')
            ->select(
                'militares_auxilios_fardamentos.*',
                'militares.nome as militarNome',
                'militares.id as militar_id',
                'militares.rg as militarRg',
                'militares.situacao_id as militarSituacaoId',
                'situacoes.name as militarSituacaoName',
                'graduacoes.name as militarGraduacaoName',
                'quadros.name as militarQuadroName',
                'quadros.especialidade as militarQuadroEspecialidadeName',
                'auxilio_fardamento_tipos.name as auxilioFardamentoTipoName'
            );

        // Permissão Situação do Militar
        $query->whereIn('militares.situacao_id', retornaArrayCampoGruposPermissoesSituacoes('militares_auxilios_fardamentos_permissoes_list_situacoes_ids'));

        $query->orderBy('auxilio_fardamento_tipos.name')->limit($limit);

        return $query->get();
    }

    public function filter($array_dados, int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = MilitarAuxilioFardamento
            ::join('militares', 'militares.id', 'militares_auxilios_fardamentos.militar_id')
            ->join('situacoes', 'situacoes.id', 'militares.situacao_id')
            ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->join('unidades', 'unidades.id', 'militares.unidade_id')
            ->join('quadros', 'quadros.id', 'militares.quadro_id')
            ->join('auxilio_fardamento_tipos', 'auxilio_fardamento_tipos.id', 'militares_auxilios_fardamentos.auxilio_fardamento_tipo_id')
            ->select(
                'militares_auxilios_fardamentos.*',
                'militares.nome as militarNome',
                'militares.id as militar_id',
                'militares.rg as militarRg',
                'militares.situacao_id as militarSituacaoId',
                'situacoes.name as militarSituacaoName',
                'graduacoes.name as militarGraduacaoName',
                'quadros.name as militarQuadroName',
                'quadros.especialidade as militarQuadroEspecialidadeName',
                'auxilio_fardamento_tipos.name as auxilioFardamentoTipoName'
            )
            ->where(function($query) use($filtros) {
                // Permissão Situação do Militar
                $query->whereIn('militares.situacao_id', retornaArrayCampoGruposPermissoesSituacoes('militares_auxilios_fardamentos_permissoes_list_situacoes_ids'));

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
            ->orderBy('auxilio_fardamento_tipos.name')
            ->limit($limit)
            ->get();

        return $registros;
    }

    public function find(int $id)
    {
        $query = MilitarAuxilioFardamento
            ::join('militares', 'militares.id', 'militares_auxilios_fardamentos.militar_id')
            ->join('situacoes', 'situacoes.id', 'militares.situacao_id')
            ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->join('unidades', 'unidades.id', 'militares.unidade_id')
            ->join('quadros', 'quadros.id', 'militares.quadro_id')
            ->join('auxilio_fardamento_tipos', 'auxilio_fardamento_tipos.id', 'militares_auxilios_fardamentos.auxilio_fardamento_tipo_id')
            ->select(
                'militares_auxilios_fardamentos.*',
                'militares.nome as militarNome',
                'militares.id as militar_id',
                'militares.rg as militarRg',
                'militares.identidade_funcional as militarIdentidadeFuncional',
                'militares.situacao_id as militarSituacaoId',
                'situacoes.name as militarSituacaoName',
                'graduacoes.name as militarGraduacaoName',
                'quadros.name as militarQuadroName',
                'quadros.especialidade as militarQuadroEspecialidadeName',
                'auxilio_fardamento_tipos.name as auxilioFardamentoTipoName'
            );



        // Permissão Situação do Militar
        // $query->whereIn('militares.situacao_id', retornaArrayCampoGruposPermissoesSituacoes('militares_permissoes_list_situacoes_ids'));


        return $query->find($id);
    }

    public function create(array $data)
    {
        // Excluído
        $data['excluido'] = 0;

        // Pagamento Ordenar
        if (!empty($data['pagamento'])) {
            [$mes, $ano] = explode('/', $data['pagamento']);
            $data['pagamento_ordenar'] = "{$ano}/{$mes}";
        }

        $militar_auxilio_fardamento = MilitarAuxilioFardamento::create($data);

        app(MilitarAuxilioFardamentoSyncService::class)->insert($militar_auxilio_fardamento);

        return $militar_auxilio_fardamento;
    }

    public function update(int $id, array $data)
    {
        // Pagamento Ordenar
        if (!empty($data['pagamento'])) {
            [$mes, $ano] = explode('/', $data['pagamento']);
            $data['pagamento_ordenar'] = "{$ano}/{$mes}";
        }

        $militar_auxilio_fardamento = $this->find($id);
        $militar_auxilio_fardamento->update($data);

        app(MilitarAuxilioFardamentoSyncService::class)->update($militar_auxilio_fardamento->fresh());

        return $militar_auxilio_fardamento;
    }

    public function delete(int $id)
    {
        $militar_auxilio_fardamento = $this->find($id);
        $militar_auxilio_fardamento->delete();

        app(MilitarAuxilioFardamentoSyncService::class)->delete($id);

        return;
    }
}
