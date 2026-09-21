<?php

namespace App\Domain\Grupo;

use App\Domain\Transacao\TransacaoRepository;
use App\Models\Grafico;
use App\Models\Grupo;
use App\Models\GrupoGrafico;
use App\Models\GrupoPermissao;
use App\Models\GrupoRelatorio;
use App\Models\Permissao;
use App\Models\Relatorio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GrupoRepository
{
    public function all()
    {
        return Grupo::all();
    }

    public function index(int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        return Grupo::orderBy('name')->limit($limit)->get();
    }

    public function filter(string $array_dados, int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = Grupo::select(['grupos.*'])
            ->where(
                function ($query) use ($filtros) {
                    // Variavel para controle
                    $qtdFiltros = count($filtros) / 4;
                    $indexCampo = 0;

                    for ($i = 1; $i <= $qtdFiltros; $i++) {
                        // Valores do Filtro
                        $condicao = $filtros[$indexCampo];
                        $campo = $filtros[$indexCampo + 1];
                        $operacao = $filtros[$indexCampo + 2];
                        $dado = $filtros[$indexCampo + 3];

                        // Operações
                        if ($operacao == 1) {
                            if ($condicao == 1) {
                                $query->where($campo, 'like', '%' . $dado . '%');
                            } else {
                                $query->orwhere($campo, 'like', '%' . $dado . '%');
                            }
                        }

                        if ($operacao == 2) {
                            if ($condicao == 1) {
                                $query->where($campo, '=', $dado);
                            } else {
                                $query->orwhere($campo, '=', $dado);
                            }
                        }

                        if ($operacao == 3) {
                            if ($condicao == 1) {
                                $query->where($campo, '>', $dado);
                            } else {
                                $query->orwhere($campo, '>', $dado);
                            }
                        }

                        if ($operacao == 4) {
                            if ($condicao == 1) {
                                $query->where($campo, '>=', $dado);
                            } else {
                                $query->orwhere($campo, '>=', $dado);
                            }
                        }

                        if ($operacao == 5) {
                            if ($condicao == 1) {
                                $query->where($campo, '<', $dado);
                            } else {
                                $query->orwhere($campo, '<', $dado);
                            }
                        }

                        if ($operacao == 6) {
                            if ($condicao == 1) {
                                $query->where($campo, '<=', $dado);
                            } else {
                                $query->orwhere($campo, '<=', $dado);
                            }
                        }

                        if ($operacao == 7) {
                            if ($condicao == 1) {
                                $query->where($campo, 'like', $dado . '%');
                            } else {
                                $query->orwhere($campo, 'like', $dado . '%');
                            }
                        }

                        if ($operacao == 8) {
                            if ($condicao == 1) {
                                $query->where($campo, 'like', '%' . $dado);
                            } else {
                                $query->orwhere($campo, 'like', '%' . $dado);
                            }
                        }

                        // Atualizar indexCampo
                        $indexCampo = $indexCampo + 4;
                    }
                }
            )->limit($limit)
            ->get();

        return $registros;
    }

    public function find(int $id)
    {
        return Grupo::find($id);
    }

    public function create(array $data)
    {
        // Gravar Transações - Dados Anterior
        $permissoes_anterior = [];
        $relatorios_anterior = [];
        $graficos_anterior = [];

        // Create
        $grupo = Grupo::create($data);

        $this->grupos_permissoes_save($grupo->id, $data);
        $this->relatorios_save($grupo->id, $data);
        $this->graficos_save($grupo->id, $data);

        // Gravar Transações - Dados Atual
        $permissoes_atual = $data['permissoes'] ?? [];
        $relatorios_atual = $data['relatorios'] ?? [];
        $graficos_atual = $data['graficos'] ?? [];

        // Gravar Transações
        $this->gravarTransacao(1, $grupo, $grupo, $permissoes_anterior, $permissoes_atual, $relatorios_anterior, $relatorios_atual, $graficos_anterior, $graficos_atual);

        // Retorno
        return;
    }

    public function update(int $id, array $data)
    {
        // Gravar Transações - Dados Anterior
        $grupo_anterior = $this->find($id);
        $permissoes_anterior = GrupoPermissao::where('grupo_id', $id)->pluck('permissao_id')->toArray();
        $relatorios_anterior = GrupoRelatorio::where('grupo_id', $id)->pluck('relatorio_id')->toArray();
        $graficos_anterior = GrupoGrafico::where('grupo_id', $id)->pluck('grafico_id')->toArray();

        // Update
        $grupo = $this->find($id);
        $grupo->update($data);

        $this->grupos_permissoes_save($id, $data);
        $this->relatorios_save($id, $data);
        $this->graficos_save($id, $data);

        // Gravar Transações - Dados Atual
        $permissoes_atual = $data['permissoes'] ?? [];
        $relatorios_atual = $data['relatorios'] ?? [];
        $graficos_atual = $data['graficos'] ?? [];

        // Gravar Transações
        $this->gravarTransacao(2, $grupo_anterior, $grupo, $permissoes_anterior, $permissoes_atual, $relatorios_anterior, $relatorios_atual, $graficos_anterior, $graficos_atual);

        // Retorno
        return;
    }

    public function delete(int $id)
    {
        // Gravar Transações - Dados Anterior
        $permissoes_anterior = GrupoPermissao::where('grupo_id', $id)->pluck('permissao_id')->toArray();
        $relatorios_anterior = GrupoRelatorio::where('grupo_id', $id)->pluck('relatorio_id')->toArray();
        $graficos_anterior = GrupoGrafico::where('grupo_id', $id)->pluck('grafico_id')->toArray();

        // Delete
        $grupo = $this->find($id);

        // Verificar relacionamentos
        $relacionamento = $this->relacionamento($id);
        if ($relacionamento['status'] === false) {
            throw new \Exception($relacionamento['message']);
        }

        $this->grupos_permissoes_save($id, []);
        $this->relatorios_save($grupo->id, []);
        $this->graficos_save($grupo->id, []);

        // Gravar Transações - Dados Atual
        $permissoes_atual = $permissoes_anterior;
        $relatorios_atual = $relatorios_anterior;
        $graficos_atual = $graficos_anterior;

        // Gravar Transações
        $this->gravarTransacao(3, $grupo, $grupo, $permissoes_anterior, $permissoes_atual, $relatorios_anterior, $relatorios_atual, $graficos_anterior, $graficos_atual);

        // Retorno
        return $grupo->delete();
    }

    public function relacionamento(int $id)
    {
        $qtd = DB::table('users')->where('grupo_id', $id)->count();

        if ($qtd > 0) {
            return ['status' => false, 'message' => 'Operação não permitida.<br> Relacionamento com Usuários.'];
        }

        return ['status' => true];
    }

    public function gravarTransacao(int $operacao_id, Grupo $grupo_anterior, Grupo $grupo_atual, array $permissoes_anterior, array $permissoes_atual, array $relatorios_anterior, array $relatorios_atual, array $graficos_anterior, array $graficos_atual)
    {
        // Permissões
        $transacoes_permissoes_anterior = $this->listaNomes($permissoes_anterior, Permissao::class);
        $transacoes_permissoes_atual    = $this->listaNomes($permissoes_atual, Permissao::class);

        // Relatórios
        $transacoes_relatorios_anterior = $this->listaNomes($relatorios_anterior, Relatorio::class);
        $transacoes_relatorios_atual    = $this->listaNomes($relatorios_atual, Relatorio::class);

        // Gráficos
        $transacoes_graficos_anterior   = $this->listaNomes($graficos_anterior, Grafico::class);
        $transacoes_graficos_atual      = $this->listaNomes($graficos_atual, Grafico::class);

        // Dados
        $dados = [
            'campos' => [
                ['campo' => 'id', 'etiqueta' => 'ID', 'anterior' => null, 'atual' => $grupo_atual['id'], 'anterior_view' => null, 'atual_view' => $grupo_atual['id']],
                ['campo' => 'name', 'etiqueta' => 'Nome', 'anterior' => $grupo_anterior['name'], 'atual' => $grupo_atual['name'], 'anterior_view' => $grupo_anterior['name'], 'atual_view' => $grupo_atual['name']],
                ['campo' => 'permissoes', 'etiqueta' => 'Permissões', 'anterior' => $transacoes_permissoes_anterior, 'atual' => $transacoes_permissoes_atual, 'anterior_view' => $transacoes_permissoes_anterior, 'atual_view' => $transacoes_permissoes_atual],
                ['campo' => 'relatorios', 'etiqueta' => 'Relatórios', 'anterior' => $transacoes_relatorios_anterior, 'atual' => $transacoes_relatorios_atual, 'anterior_view' => $transacoes_relatorios_anterior, 'atual_view' => $transacoes_relatorios_atual],
                ['campo' => 'graficos', 'etiqueta' => 'Gráficos', 'anterior' => $transacoes_graficos_anterior, 'atual' => $transacoes_graficos_atual, 'anterior_view' => $transacoes_graficos_anterior, 'atual_view' => $transacoes_graficos_atual]
            ]
        ];

        // Gravando
        $transacaoData = [
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
            'user_id' => Auth::user()->id,
            'operacao_id' => $operacao_id,
            'submodulo_id' => 2,
            'dados' => $dados
        ];

        $transacaoRepository = new TransacaoRepository;
        $transacaoRepository->create($transacaoData);

        return;
    }

    private function listaNomes(array $ids, string $model): string
    {
        if (empty($ids)) {return '';}

        return $model::whereIn('id', $ids)->pluck('name')->map(fn ($nome) => primeiraMaiuscula($nome))->implode(', ');
    }

    public function grupos_permissoes_save(int $grupo_id, array $data)
    {
        // IDs vindos do form
        $novasPermissoes = $data['permissoes'] ?? [];

        // Permissões atuais no banco
        $atuais = GrupoPermissao::where('grupo_id', $grupo_id)
            ->pluck('permissao_id')
            ->toArray();

        // O que inserir
        $inserir = array_diff($novasPermissoes, $atuais);

        // O que remover
        $remover = array_diff($atuais, $novasPermissoes);

        // INSERT
        foreach ($inserir as $permissao_id) {
            GrupoPermissao::create([
                'grupo_id' => $grupo_id,
                'permissao_id' => $permissao_id
            ]);
        }

        // DELETE
        if (!empty($remover)) {
            GrupoPermissao::where('grupo_id', $grupo_id)
                ->whereIn('permissao_id', $remover)
                ->delete();
        }

        return;
    }

    public function relatorios_save(int $grupo_id, array $data)
    {
        // relatorios enviados pelo form
        $relatoriosNovos = $data['relatorios'] ?? [];

        // relatorio atuais do banco
        $relatoriosAtuais = DB::table('grupos_relatorios')->where('grupo_id', $grupo_id)->pluck('relatorio_id')->toArray();

        // relatorio Inserir
        $inserir = array_diff($relatoriosNovos, $relatoriosAtuais);

        // relatorio Remover
        $remover = array_diff($relatoriosAtuais, $relatoriosNovos);

        // Inserts
        foreach ($inserir as $relatorioId) {
            DB::table('grupos_relatorios')->insert(['grupo_id' => $grupo_id, 'relatorio_id' => $relatorioId]);
        }

        // Deletes
        if (!empty($remover)) {
            DB::table('grupos_relatorios')->where('grupo_id', $grupo_id)->whereIn('relatorio_id', $remover)->delete();
        }
    }

    public function graficos_save(int $grupo_id, array $data)
    {
        // gráficos enviados pelo form
        $graficosNovos = $data['graficos'] ?? [];

        // Gráficos atuais do banco
        $graficosAtuais = DB::table('grupos_graficos')->where('grupo_id', $grupo_id)->pluck('grafico_id')->toArray();

        // Gráficos Inserir
        $inserir = array_diff($graficosNovos, $graficosAtuais);

        // Gráficos Remover
        $remover = array_diff($graficosAtuais, $graficosNovos);

        // Inserts
        foreach ($inserir as $graficoId) {
            DB::table('grupos_graficos')->insert(['grupo_id' => $grupo_id, 'grafico_id' => $graficoId]);
        }

        // Deletes
        if (!empty($remover)) {
            DB::table('grupos_graficos')->where('grupo_id', $grupo_id)->whereIn('grafico_id', $remover)->delete();
        }
    }

    public function grupo_permissoes(int $grupo_id)
    {
        return GrupoPermissao::join('permissoes', 'permissoes.id', 'grupos_permissoes.permissao_id')
            ->select('grupos_permissoes.*', 'permissoes.name as permissaoName')
            ->where('grupo_id', $grupo_id)
            ->get();
    }

    public function grupo_relatorios(int $grupo_id)
    {
        return GrupoRelatorio::join('relatorios', 'relatorios.id', 'grupos_relatorios.relatorio_id')
            ->select('grupos_relatorios.*', 'relatorios.id as relatorioId', 'relatorios.name as relatorioName')
            ->where('grupo_id', $grupo_id)
            ->get();
    }

    public function grupo_graficos(int $grupo_id)
    {
        return GrupoGrafico::join('graficos', 'graficos.id', 'grupos_graficos.grafico_id')
            ->select('grupos_graficos.*', 'graficos.id as graficoId', 'graficos.name as graficoName')
            ->where('grupo_id', $grupo_id)
            ->get();
    }

    public function totais(int $op)
    {
        // Total Geral
        if ($op == 1) {
            return Grupo::count();
        }
    }

    public function relatorios()
    {
        return Relatorio::join('relatorio_grupos', 'relatorio_grupos.id', 'relatorios.relatorio_grupo_id')
            ->select(
                'relatorio_grupos.id as relatorioGrupoId',
                'relatorio_grupos.name as relatorioGrupoName',
                'relatorios.id as relatorioId',
                'relatorios.name as relatorioName'
            )
            ->orderby('relatorio_grupos.ordem')
            ->orderby('relatorios.ordem')
            ->get();
    }

    public function graficos()
    {
        return Grafico::join('grafico_grupos', 'grafico_grupos.id', 'graficos.grafico_grupo_id')
            ->select(
                'grafico_grupos.id as graficoGrupoId',
                'grafico_grupos.name as graficoGrupoName',
                'graficos.id as graficoId',
                'graficos.name as graficoName'
            )
            ->orderby('grafico_grupos.ordem')
            ->orderby('graficos.ordem')
            ->get();
    }
}
