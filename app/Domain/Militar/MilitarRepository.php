<?php

namespace App\Domain\Militar;

use App\Models\Militar;
use App\Models\MilitarAjudaCusto;
use App\Models\MilitarAuxilioFardamento;
use App\Models\MilitarCurso;
use App\Models\MilitarDependente;
use App\Models\MilitarFundoSaude;
use App\Services\MilitarSyncService;
use Illuminate\Support\Facades\DB;

class MilitarRepository
{
    public function index(int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Return
        $query = Militar
            ::join('situacoes', 'situacoes.id', 'militares.situacao_id')
            ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->join('unidades', 'unidades.id', 'militares.unidade_id')
            ->join('quadros', 'quadros.id', 'militares.quadro_id')
            ->leftjoin('sexos_biologicos', 'sexos_biologicos.id', 'militares.sexo_biologico_id')
            ->leftjoin('generos', 'generos.id', 'militares.genero_id')
            ->leftjoin('unidades as prestando_servico', 'prestando_servico.id', 'militares.prestando_servico_id')
            ->leftjoin('funcoes', 'funcoes.id', 'militares.funcao_id')
            ->leftjoin('estados_civis', 'estados_civis.id', 'militares.estado_civil_id')
            ->leftjoin('comportamentos', 'comportamentos.id', 'militares.comportamento_id')
            ->leftjoin('tipos_sanguineos', 'tipos_sanguineos.id', 'militares.tipo_sanguineo_id')
            ->leftjoin('fatores_rh', 'fatores_rh.id', 'militares.fator_rh_id')
            ->leftjoin('nacionalidades', 'nacionalidades.id', 'militares.nacionalidade_id')
            ->leftjoin('naturalidades', 'naturalidades.id', 'militares.naturalidade_id')
            ->leftjoin('escolaridades', 'escolaridades.id', 'militares.escolaridade_id')
            ->select(
                'militares.*',
                'situacoes.id as militarSituacaoId',
                'situacoes.name as situacaoName',
                'graduacoes.name as graduacaoName',
                'unidades.name as unidadeName',
                'quadros.name as quadroName',
                'quadros.especialidade as quadroEspecialidadeName',
                'sexos_biologicos.name as sexoBiologicoName',
                'generos.name as generoName',
                'prestando_servico.name as prestandoServicoName',
                'funcoes.name as funcaoName',
                'estados_civis.name as estadoCivilName',
                'comportamentos.name as comportamentoName',
                'tipos_sanguineos.name as tipoSanguineoName',
                'fatores_rh.name as fatorRhName',
                'nacionalidades.name as nacionalidadeName',
                'naturalidades.name as naturalidadeName',
                'escolaridades.name as escolaridadeName'
            );

        // Permissão Situação do Militar
        $query->whereIn('militares.situacao_id', retornaArrayCampoGruposPermissoesSituacoes('militares_permissoes_list_situacoes_ids'));

        $query->orderBy('militares.nome')->limit($limit);

        return $query->get();
    }

    public function filter(string $array_dados, int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = Militar
            ::join('situacoes', 'situacoes.id', 'militares.situacao_id')
            ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->join('unidades', 'unidades.id', 'militares.unidade_id')
            ->join('quadros', 'quadros.id', 'militares.quadro_id')
            ->leftjoin('sexos_biologicos', 'sexos_biologicos.id', 'militares.sexo_biologico_id')
            ->leftjoin('generos', 'generos.id', 'militares.genero_id')
            ->leftjoin('unidades as prestando_servico', 'prestando_servico.id', 'militares.prestando_servico_id')
            ->leftjoin('funcoes', 'funcoes.id', 'militares.funcao_id')
            ->leftjoin('estados_civis', 'estados_civis.id', 'militares.estado_civil_id')
            ->leftjoin('comportamentos', 'comportamentos.id', 'militares.comportamento_id')
            ->leftjoin('tipos_sanguineos', 'tipos_sanguineos.id', 'militares.tipo_sanguineo_id')
            ->leftjoin('fatores_rh', 'fatores_rh.id', 'militares.fator_rh_id')
            ->leftjoin('nacionalidades', 'nacionalidades.id', 'militares.nacionalidade_id')
            ->leftjoin('naturalidades', 'naturalidades.id', 'militares.naturalidade_id')
            ->leftjoin('escolaridades', 'escolaridades.id', 'militares.escolaridade_id')
            ->select(
                'militares.*',
                'situacoes.id as militarSituacaoId',
                'situacoes.name as situacaoName',
                'graduacoes.name as graduacaoName',
                'unidades.name as unidadeName',
                'quadros.name as quadroName',
                'quadros.especialidade as quadroEspecialidadeName',
                'sexos_biologicos.name as sexoBiologicoName',
                'generos.name as generoName',
                'prestando_servico.name as prestandoServicoName',
                'funcoes.name as funcaoName',
                'estados_civis.name as estadoCivilName',
                'comportamentos.name as comportamentoName',
                'tipos_sanguineos.name as tipoSanguineoName',
                'fatores_rh.name as fatorRhName',
                'nacionalidades.name as nacionalidadeName',
                'naturalidades.name as naturalidadeName',
                'escolaridades.name as escolaridadeName'
            )
            ->where(function($query) use($filtros) {
                // Permissão Situação do Militar
                $query->whereIn('militares.situacao_id', retornaArrayCampoGruposPermissoesSituacoes('militares_permissoes_list_situacoes_ids'));

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
            ->orderBy('militares.nome')
            ->limit($limit)
            ->get();

        return $registros;
    }

    public function find(int $id)
    {
        $query = Militar::join('situacoes', 'situacoes.id', 'militares.situacao_id')
            ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->join('unidades', 'unidades.id', 'militares.unidade_id')
            ->join('quadros', 'quadros.id', 'militares.quadro_id')
            ->leftjoin('sexos_biologicos', 'sexos_biologicos.id', 'militares.sexo_biologico_id')
            ->leftjoin('generos', 'generos.id', 'militares.genero_id')
            ->leftjoin('unidades as prestando_servico', 'prestando_servico.id', 'militares.prestando_servico_id')
            ->leftjoin('funcoes', 'funcoes.id', 'militares.funcao_id')
            ->leftjoin('estados_civis', 'estados_civis.id', 'militares.estado_civil_id')
            ->leftjoin('comportamentos', 'comportamentos.id', 'militares.comportamento_id')
            ->leftjoin('tipos_sanguineos', 'tipos_sanguineos.id', 'militares.tipo_sanguineo_id')
            ->leftjoin('fatores_rh', 'fatores_rh.id', 'militares.fator_rh_id')
            ->leftjoin('nacionalidades', 'nacionalidades.id', 'militares.nacionalidade_id')
            ->leftjoin('naturalidades', 'naturalidades.id', 'militares.naturalidade_id')
            ->leftjoin('escolaridades', 'escolaridades.id', 'militares.escolaridade_id')
            ->select(
                'militares.*',
                'situacoes.id as militarSituacaoId',
                'situacoes.name as situacaoName',
                'graduacoes.name as graduacaoName',
                'unidades.name as unidadeName',
                'quadros.name as quadroName',
                'quadros.especialidade as quadroEspecialidadeName',
                'sexos_biologicos.name as sexoBiologicoName',
                'generos.name as generoName',
                'prestando_servico.name as prestandoServicoName',
                'funcoes.name as funcaoName',
                'estados_civis.name as estadoCivilName',
                'comportamentos.name as comportamentoName',
                'tipos_sanguineos.name as tipoSanguineoName',
                'fatores_rh.name as fatorRhName',
                'nacionalidades.name as nacionalidadeName',
                'naturalidades.name as naturalidadeName',
                'escolaridades.name as escolaridadeName'
            );

        // Permissão Situação do Militar
        $query->whereIn('militares.situacao_id', retornaArrayCampoGruposPermissoesSituacoes('militares_permissoes_list_situacoes_ids'));

        return $query->find($id);
    }

    public function create(array $data)
    {
        $militar = Militar::create($data);

        app(MilitarSyncService::class)->insert($militar);

        return $militar;
    }

    public function update(int $id, array $data)
    {
        $militar = $this->find($id);
        $militar->update($data);

        app(MilitarSyncService::class)->update($militar->fresh());

        return $militar;
    }

    public function update_fotografia(int $id, array $data)
    {
        $militar = $this->find($id);

        $militar->update($data);

        return $militar;
    }

    public function delete(int $id)
    {
        $militar = $this->find($id);

        // Verificar relacionamentos
        $relacionamento = $this->relacionamento($id);
        if ($relacionamento['status'] === false) {
            throw new \Exception($relacionamento['message']);
        }

        $militar->delete();

        app(MilitarSyncService::class)->delete($id);

        return;
    }

    public function relacionamento(int $id)
    {
        // Militares Cursos
        $qtd = DB::table('militares_cursos')->where('militar_id', $id)->count();

        if ($qtd > 0) {
            return ['status' => false, 'message' => 'Operação não permitida.<br> Relacionamento com Cursos.'];
        }

        // Militares Contatos
        $qtd = DB::table('militares_contatos')->where('militar_id', $id)->count();

        if ($qtd > 0) {
            return ['status' => false, 'message' => 'Operação não permitida.<br> Relacionamento com Contatos.'];
        }

        // Militares Ajudas Custos
        $qtd = DB::table('militares_ajudas_custos')->where('militar_id', $id)->count();

        if ($qtd > 0) {
            return ['status' => false, 'message' => 'Operação não permitida.<br> Relacionamento com Ajudas Custos.'];
        }

        // Militares Auxílios Fardamentos
        $qtd = DB::table('militares_auxilios_fardamentos')->where('militar_id', $id)->count();

        if ($qtd > 0) {
            return ['status' => false, 'message' => 'Operação não permitida.<br> Relacionamento com Auxílios Fardamentos.'];
        }

        // Militares Fundos Saúde
        $qtd = DB::table('militares_fundos_saude')->where('militar_id', $id)->count();

        if ($qtd > 0) {
            return ['status' => false, 'message' => 'Operação não permitida.<br> Relacionamento com Fundos Saúde.'];
        }

        // Militares Dependentes
        $qtd = DB::table('militares_dependentes')->where('militar_id', $id)->count();

        if ($qtd > 0) {
            return ['status' => false, 'message' => 'Operação não permitida.<br> Relacionamento com Dependentes.'];
        }

        // Users
        $qtd = DB::table('users')->where('militar_id', $id)->count();

        if ($qtd > 0) {
            return ['status' => false, 'message' => 'Operação não permitida.<br> Relacionamento com Usuários.'];
        }

        return ['status' => true];
    }

    public function informacoes_geral(int $militar_id)
    {
        // Array
        $data = array();

        $data['militar'] = Militar::join('situacoes', 'situacoes.id', 'militares.situacao_id')
            ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->join('unidades', 'unidades.id', 'militares.unidade_id')
            ->join('quadros', 'quadros.id', 'militares.quadro_id')
            ->leftjoin('sexos_biologicos', 'sexos_biologicos.id', 'militares.sexo_biologico_id')
            ->leftjoin('generos', 'generos.id', 'militares.genero_id')
            ->leftjoin('unidades as prestando_servico', 'prestando_servico.id', 'militares.prestando_servico_id')
            ->leftjoin('funcoes', 'funcoes.id', 'militares.funcao_id')
            ->leftjoin('estados_civis', 'estados_civis.id', 'militares.estado_civil_id')
            ->leftjoin('comportamentos', 'comportamentos.id', 'militares.comportamento_id')
            ->leftjoin('tipos_sanguineos', 'tipos_sanguineos.id', 'militares.tipo_sanguineo_id')
            ->leftjoin('fatores_rh', 'fatores_rh.id', 'militares.fator_rh_id')
            ->leftjoin('nacionalidades', 'nacionalidades.id', 'militares.nacionalidade_id')
            ->leftjoin('naturalidades', 'naturalidades.id', 'militares.naturalidade_id')
            ->leftjoin('escolaridades', 'escolaridades.id', 'militares.escolaridade_id')
            ->select(
                'militares.*',
                'situacoes.id as militarSituacaoId',
                'situacoes.name as situacaoName',
                'graduacoes.name as graduacaoName',
                'unidades.name as unidadeName',
                'quadros.name as quadroName',
                'quadros.especialidade as quadroEspecialidadeName',
                'sexos_biologicos.name as sexoBiologicoName',
                'generos.name as generoName',
                'prestando_servico.name as prestandoServicoName',
                'funcoes.name as funcaoName',
                'estados_civis.name as estadoCivilName',
                'comportamentos.name as comportamentoName',
                'tipos_sanguineos.name as tipoSanguineoName',
                'fatores_rh.name as fatorRhName',
                'nacionalidades.name as nacionalidadeName',
                'naturalidades.name as naturalidadeName',
                'escolaridades.name as escolaridadeName'
            )->find($militar_id);

        $data['militar_ajudas_custos'] = MilitarAjudaCusto::join('ajuda_custo_tipos', 'ajuda_custo_tipos.id', 'militares_ajudas_custos.ajuda_custo_tipo_id')
                                            ->select('militares_ajudas_custos.*', 'ajuda_custo_tipos.name as ajudaCustoTipoName')
                                            ->where('militares_ajudas_custos.excluido', 0)
                                            ->where('militares_ajudas_custos.militar_id', $militar_id)
                                            ->orderby('pagamento_ordenar')
                                            ->get();

        $data['militar_auxilios_fardamentos'] = MilitarAuxilioFardamento::join('auxilio_fardamento_tipos', 'auxilio_fardamento_tipos.id', 'militares_auxilios_fardamentos.auxilio_fardamento_tipo_id')
                                            ->select('militares_auxilios_fardamentos.*', 'auxilio_fardamento_tipos.name as auxilioFardamentoTipoName')
                                            ->where('militares_auxilios_fardamentos.excluido', 0)
                                            ->where('militar_id', $militar_id)
                                            ->orderby('pagamento_ordenar')
                                            ->get();

        $data['militar_cursos'] = MilitarCurso::join('cursos', 'cursos.id', 'militares_cursos.curso_id')
                                            ->select('militares_cursos.*', 'cursos.name as cursoName')
                                            ->where('militares_cursos.excluido', 0)
                                            ->where('militares_cursos.militar_id', $militar_id)
                                            ->orderby('data_termino')
                                            ->get();

        $data['militar_dependentes'] = MilitarDependente::join('parentescos', 'parentescos.id', 'militares_dependentes.parentesco_id')
                                            ->select('militares_dependentes.*', 'parentescos.name as parentescoName')
                                            ->where('militares_dependentes.excluido', 0)
                                            ->where('militares_dependentes.militar_id', $militar_id)
                                            ->orderby('parentescos.name')
                                            ->orderby('militares_dependentes.name')
                                            ->get();

        $data['militar_fundos_saude'] = MilitarFundoSaude::select('militares_fundos_saude.*')
                                            ->where('militares_fundos_saude.militar_id', $militar_id)
                                            ->get();

        return $data;
    }

    public function totais(int $op)
    {
        // Total Ativos
        if ($op == 2) {
            return Militar::whereIn('militares.situacao_id', [1, 10])
                ->whereIn('militares.graduacao_id', [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18])
                ->count();
        }

        // Total Oficiais Ativos
        if ($op == 3) {
            return Militar::whereIn('militares.situacao_id', [1, 10])
                ->whereIn('militares.graduacao_id', [2, 3, 4, 5, 6, 7])
                ->count();
        }

        // Total Aspirantes
        if ($op == 4) {
            return Militar::whereIn('militares.situacao_id', [1, 10])
                ->whereIn('militares.graduacao_id', [8])
                ->count();
        }

        // Total Alunos CFO
        if ($op == 5) {
            return Militar::whereIn('militares.situacao_id', [1, 10])
                ->whereIn('militares.graduacao_id', [9, 10, 11])
                ->count();
        }

        // Total Praças Ativos
        if ($op == 6) {
            return Militar::whereIn('militares.situacao_id', [1, 10])
                ->whereIn('militares.graduacao_id', [12, 13, 14, 15, 16, 17, 18])
                ->count();
        }
    }

    public function autocompleteMilitar(int $limit, string $pesquisa, string $submodulo, string $acao)
    {
        // Limit
        $limit = $limit ? $limit : 50;

        // Return
        $query = Militar
            ::join('situacoes', 'situacoes.id', 'militares.situacao_id')
            ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->join('unidades', 'unidades.id', 'militares.unidade_id')
            ->join('quadros', 'quadros.id', 'militares.quadro_id')
            ->leftjoin('sexos_biologicos', 'sexos_biologicos.id', 'militares.sexo_biologico_id')
            ->leftjoin('generos', 'generos.id', 'militares.genero_id')
            ->leftjoin('unidades as prestando_servico', 'prestando_servico.id', 'militares.prestando_servico_id')
            ->leftjoin('funcoes', 'funcoes.id', 'militares.funcao_id')
            ->leftjoin('estados_civis', 'estados_civis.id', 'militares.estado_civil_id')
            ->leftjoin('comportamentos', 'comportamentos.id', 'militares.comportamento_id')
            ->leftjoin('tipos_sanguineos', 'tipos_sanguineos.id', 'militares.tipo_sanguineo_id')
            ->leftjoin('fatores_rh', 'fatores_rh.id', 'militares.fator_rh_id')
            ->leftjoin('nacionalidades', 'nacionalidades.id', 'militares.nacionalidade_id')
            ->leftjoin('naturalidades', 'naturalidades.id', 'militares.naturalidade_id')
            ->leftjoin('escolaridades', 'escolaridades.id', 'militares.escolaridade_id')
            ->select(
                'militares.id as militar_id',
                'militares.nome as militarNome',
                'militares.rg',
                'militares.rg as militarRg',
                'militares.identidade_funcional as militarIdentidadeFuncional',
                'situacoes.id as militarSituacaoId',
                'situacoes.name as militarSituacaoName',
                'graduacoes.name as militarGraduacaoName',
                'quadros.name as quadroName',
                'quadros.especialidade as militarQuadroEspecialidadeName'
            )
            ->where(function ($query) use ($pesquisa) {
                $query->where('militares.nome', 'LIKE', "%{$pesquisa}%")->orWhere('militares.rg', 'LIKE', "%{$pesquisa}%")->orWhere('militares.identidade_funcional', 'LIKE', "%{$pesquisa}%");
            });

        // Permissão Situação do Militar (Create)
        if ($submodulo != 'xxxyyyzzz') {
            if ($acao != 'xyz') {
                $query->whereIn('militares.situacao_id', retornaArrayCampoGruposPermissoesSituacoes($submodulo.'_permissoes_'.$acao.'_situacoes_ids'));
            } else {
                $query->whereIn('militares.situacao_id', retornaArrayCampoGruposPermissoesSituacoes($submodulo.'_permissoes_list_situacoes_ids'));
            }
        }

        return $query->orderBy('militares.nome')->limit($limit)->get();
    }
}
