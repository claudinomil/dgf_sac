<?php

namespace App\Domain\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function all()
    {
        return User::all();
    }

    public function index($limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        return User::orderBy('name')->limit($limit)->get();
    }

    public function filter($array_dados, $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = User::select(['users.*'])
            ->where(function($query) use($filtros) {
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
            }
            )->limit($limit)
            ->get();

        return $registros;
    }

    public function find(int $id)
    {
        return User::join('grupos', 'grupos.id', 'users.grupo_id')
            ->join('user_situacoes', 'user_situacoes.id', 'users.user_situacao_id')
            ->join('user_tipos', 'user_tipos.id', 'users.user_tipo_id')
            ->leftjoin('militares', 'militares.id', 'users.militar_id')
            ->leftjoin('situacoes', 'situacoes.id', 'militares.situacao_id')
            ->leftjoin('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->leftjoin('quadros', 'quadros.id', 'militares.quadro_id')
            ->select(
                'users.*',
                'grupos.name as grupoName',
                'user_situacoes.name as situacaoName',
                'user_tipos.name as userTipoName',
                'militares.nome as militarNome',
                'militares.rg as militarRg',
                'militares.identidade_funcional as militarIdentidadeFuncional',
                'situacoes.name as militarSituacaoName',
                'graduacoes.name as militarGraduacaoName',
                'quadros.quadro_especialidade as militarQuadroEspecialidadeName'
            )
            ->find($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(int $id, array $data)
    {
        $user = $this->find($id);
        $user->update($data);

        return $user;
    }

    public function delete($id)
    {
        $user = $this->find($id);

        // Verificar relacionamentos
        $relacionamento = $this->relacionamento($id);
        if ($relacionamento['status'] === false) {
            throw new \Exception($relacionamento['message']);
        }

        return $user->delete();
    }

    public function relacionamento(int $id)
    {
        $qtd = DB::table('transacoes')->where('user_id', $id)->count();

        if ($qtd > 0) {
            return ['status' => false, 'message' => 'Operação não permitida.<br> Relacionamento com Transações.'];
        }

        return ['status' => true];
    }

    public function totais($op)
    {
        // Total Geral
        if ($op == 1) {
            return User::count();
        }

        // Total Liberados
        if ($op == 2) {
            return User::where('user_situacao_id', 1)->count();
        }

        // Total Bloqueados
        if ($op == 3) {
            return User::where('user_situacao_id', 2)->count();
        }

        // Total Militares
        if ($op == 4) {
            return User::where('user_tipo_id', 1)->count();
        }

        // Total Civis
        if ($op == 5) {
            return User::where('user_tipo_id', 2)->count();
        }
    }
}
