<?php

namespace App\Domain\Genero;

use App\Models\Genero;

use Illuminate\Support\Facades\DB;

class GeneroRepository
{
    public function all()
    {
        return Genero::orderby('name')->get();
    }

    public function index(int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Return
        $query = Genero::orderBy('name')->limit($limit);

        return $query->get();
    }

    public function filter($array_dados, int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = Genero::where(function($query) use($filtros) {
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
        ->orderBy('name')
        ->limit($limit)
        ->get();

        return $registros;
    }

    public function find(int $id)
    {
        return Genero::find($id);
    }

    public function create(array $data)
    {
        // Criar
        $genero = Genero::create($data);

        return $genero;
    }

    public function update(int $id, array $data)
    {
        $genero = $this->find($id);
        $genero->update($data);

        return $genero;
    }

    public function delete(int $id)
    {
        // Registro
        $genero = $this->find($id);

        // Verificar relacionamentos
        $relacionamento = $this->relacionamento($id);
        if ($relacionamento['status'] === false) {
            throw new \Exception($relacionamento['message']);
        }

        // Deletar
        $genero->delete();

        return;
    }

    public function relacionamento(int $id)
    {
        $qtd = DB::table('militares')->where('genero_id', $id)->count();

        if ($qtd > 0) {
            return ['status' => false, 'message' => 'Operação não permitida.<br> Relacionamento com Militares.'];
        }

        return ['status' => true];
    }
}
