<?php

namespace App\Domain\MilitarPensao;

use App\Models\HomologacaoTransacao;
use App\Models\MilitarPensao;
use App\Services\MilitarPensaoSyncService;

class MilitarPensaoRepository
{
    public function index(int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Return
        $query = MilitarPensao
            ::join('militares', 'militares.id', 'militares_pensoes.militar_id')
            ->join('situacoes', 'situacoes.id', 'militares.situacao_id')
            ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->join('unidades', 'unidades.id', 'militares.unidade_id')
            ->join('quadros', 'quadros.id', 'militares.quadro_id')
            ->join('pensao_tipos', 'pensao_tipos.id', 'militares_pensoes.pensao_tipo_id')
            ->select(
                'militares_pensoes.*',
                'militares.nome as militarNome',
                'militares.id as militar_id',
                'militares.rg as militarRg',
                'militares.situacao_id as militarSituacaoId',
                'situacoes.name as militarSituacaoName',
                'graduacoes.name as militarGraduacaoName',
                'quadros.name as militarQuadroName',
                'quadros.especialidade as militarQuadroEspecialidadeName',
                'pensao_tipos.name as pensaoTipoName'
            );

        // Permissão Situação do Militar
        $query->whereIn('militares.situacao_id', retornaArrayCampoGruposPermissoesSituacoes('militares_pensoes_permissoes_list_situacoes_ids'));

        $query->orderBy('militares.situacao_id');
        $query->orderBy('militares.graduacao_id');
        $query->orderBy('militares.rg');

        return $query->limit($limit)->get();
    }

    public function filter($array_dados, int $limit)
    {
        // Homologação Transação
        HomologacaoTransacao::create(['submodulo_id' => 21, 'user_id' => session('userContext.user.id'), 'operacao' => 'Consulta', 'data' => date('Y-m-d'), 'hora' => date('H:i:s')]);

        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = MilitarPensao
            ::join('militares', 'militares.id', 'militares_pensoes.militar_id')
            ->join('situacoes', 'situacoes.id', 'militares.situacao_id')
            ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->join('unidades', 'unidades.id', 'militares.unidade_id')
            ->join('quadros', 'quadros.id', 'militares.quadro_id')
            ->join('pensao_tipos', 'pensao_tipos.id', 'militares_pensoes.pensao_tipo_id')
            ->select(
                'militares_pensoes.*',
                'militares.nome as militarNome',
                'militares.id as militar_id',
                'militares.rg as militarRg',
                'militares.situacao_id as militarSituacaoId',
                'situacoes.name as militarSituacaoName',
                'graduacoes.name as militarGraduacaoName',
                'quadros.name as militarQuadroName',
                'quadros.especialidade as militarQuadroEspecialidadeName',
                'pensao_tipos.name as pensaoTipoName'
            )
            ->where(function($query) use($filtros) {
                // Permissão Situação do Militar
                $query->whereIn('militares.situacao_id', retornaArrayCampoGruposPermissoesSituacoes('militares_pensoes_permissoes_list_situacoes_ids'));

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
            ->orderBy('militares.situacao_id')
            ->orderBy('militares.graduacao_id')
            ->orderBy('militares.rg')
            ->limit($limit)
            ->get();

        return $registros;
    }

    public function find(int $id)
    {
        $query = MilitarPensao
            ::join('militares', 'militares.id', 'militares_pensoes.militar_id')
            ->join('situacoes', 'situacoes.id', 'militares.situacao_id')
            ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->join('unidades', 'unidades.id', 'militares.unidade_id')
            ->join('quadros', 'quadros.id', 'militares.quadro_id')
            ->join('pensao_tipos', 'pensao_tipos.id', 'militares_pensoes.pensao_tipo_id')
            ->select(
                'militares_pensoes.*',
                'militares.nome as militarNome',
                'militares.id as militar_id',
                'militares.rg as militarRg',
                'militares.identidade_funcional as militarIdentidadeFuncional',
                'militares.situacao_id as militarSituacaoId',
                'situacoes.name as militarSituacaoName',
                'graduacoes.name as militarGraduacaoName',
                'quadros.name as militarQuadroName',
                'quadros.especialidade as militarQuadroEspecialidadeName',
                'pensao_tipos.name as pensaoTipoName'
            );

        // Permissão Situação do Militar
        $query->whereIn('militares.situacao_id', retornaArrayCampoGruposPermissoesSituacoes('militares_pensoes_permissoes_list_situacoes_ids'));

        return $query->find($id);
    }

    public function create(array $data)
    {
        // Homologação Transação
        HomologacaoTransacao::create(['submodulo_id' => 21, 'user_id' => session('userContext.user.id'), 'operacao' => 'Inclusão', 'data' => date('Y-m-d'), 'hora' => date('H:i:s')]);

        // Excluído
        $data['excluido'] = 0;

        // Pagamento Ordenar
        if (!empty($data['pagamento'])) {
            [$mes, $ano] = explode('/', $data['pagamento']);
            $data['pagamento_ordenar'] = "{$ano}/{$mes}";
        }

        $militar_pensao = MilitarPensao::create($data);

        app(MilitarPensaoSyncService::class)->insert($militar_pensao);

        return $militar_pensao;
    }

    public function update(int $id, array $data)
    {
        // Homologação Transação
        HomologacaoTransacao::create(['submodulo_id' => 21, 'user_id' => session('userContext.user.id'), 'operacao' => 'Alteração', 'data' => date('Y-m-d'), 'hora' => date('H:i:s')]);

        // Pagamento Ordenar
        if (!empty($data['pagamento'])) {
            [$mes, $ano] = explode('/', $data['pagamento']);
            $data['pagamento_ordenar'] = "{$ano}/{$mes}";
        }

        $militar_pensao = $this->find($id);
        $militar_pensao->update($data);

        app(MilitarPensaoSyncService::class)->update($militar_pensao->fresh());

        return $militar_pensao;
    }

    public function delete(int $id)
    {
        // Homologação Transação
        HomologacaoTransacao::create(['submodulo_id' => 21, 'user_id' => session('userContext.user.id'), 'operacao' => 'Exclusão', 'data' => date('Y-m-d'), 'hora' => date('H:i:s')]);

        // Deletar''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $deletarTipo = (int) session('userContext.configuracoes.deletar_tipo');

        if ($deletarTipo === 1) {
            // Registro
            $militar_pensao = $this->find($id);

            // Deletar fisicamente
            $militar_pensao->delete();

            app(MilitarPensaoSyncService::class)->delete($id);
        } elseif ($deletarTipo === 2) {
            // Deletar virtualmente
            $this->update($id, ['excluido' => 1]);
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        return;
    }
}
