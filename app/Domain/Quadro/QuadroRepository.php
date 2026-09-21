<?php

namespace App\Domain\Quadro;

use App\Models\Quadro;

use App\Services\QuadroSyncService;
use Illuminate\Support\Facades\DB;

class QuadroRepository
{
    public function all()
    {
        return Quadro::orderby('name')->get();
    }

    public function index(int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Return
        $query = Quadro::orderBy('name')->limit($limit);

        return $query->get();
    }

    public function filter($array_dados, int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = Quadro::where(function($query) use($filtros) {
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
        return Quadro::find($id);
    }

    public function create(array $data)
    {
        // Último registro pelo maior ID
        $ultimo = Quadro::latest('id')->first();
        $codigoQuadro = (int) ($ultimo['codigo_quadro'] ?? 0);
        $codigoQuadro++;
        $data['codigo_quadro'] = $codigoQuadro < 10 ? '0' . $codigoQuadro : (string) $codigoQuadro;

        // Quadro Especialidade
        $data['quadro_especialidade'] = $data['name'].' - '.$data['especialidade'];

        // Criar
        $quadro = Quadro::create($data);

        app(QuadroSyncService::class)->insert($quadro);

        return $quadro;
    }

    public function update(int $id, array $data)
    {
        // Quadro Especialidade
        $data['quadro_especialidade'] = $data['name'].' - '.$data['especialidade'];

        $quadro = $this->find($id);

        $quadro->update($data);

        app(QuadroSyncService::class)->update($quadro->fresh());

        return $quadro;
    }

    public function delete(int $id)
    {
        // Registro
        $quadro = $this->find($id);

        // Verificar relacionamentos
        $relacionamento = $this->relacionamento($id);
        if ($relacionamento['status'] === false) {
            throw new \Exception($relacionamento['message']);
        }

        // Pegar codigo_quadro
        $codigo_quadro = $quadro->codigo_quadro;

        // Deletar
        $quadro->delete();

        app(QuadroSyncService::class)->delete($id, $codigo_quadro);

        return;
    }

    public function relacionamento(int $id)
    {
        $qtd = DB::table('militares')->where('quadro_id', $id)->count();

        if ($qtd > 0) {
            return ['status' => false, 'message' => 'Operação não permitida.<br> Relacionamento com Militares.'];
        }

        return ['status' => true];
    }
}
