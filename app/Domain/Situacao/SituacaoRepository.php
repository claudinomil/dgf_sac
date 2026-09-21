<?php

namespace App\Domain\Situacao;

use App\Models\Situacao;

use App\Services\SituacaoSyncService;
use Illuminate\Support\Facades\DB;

class SituacaoRepository
{
    public function all()
    {
        return Situacao::orderby('name')->get();
    }

    public function index(int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Return
        $query = Situacao::orderBy('name')->limit($limit);

        return $query->get();
    }

    public function filter($array_dados, int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = Situacao::where(function($query) use($filtros) {
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
        return Situacao::find($id);
    }

    public function create(array $data)
    {
        // Último registro pelo maior ID
        $ultimo = Situacao::latest('id')->first();
        $codigoSituacao = (int) ($ultimo['codigo_situacao'] ?? 0);
        $codigoSituacao++;
        $data['codigo_situacao'] = $codigoSituacao < 10 ? '0' . $codigoSituacao : (string) $codigoSituacao;

        // Criar
        $situacao = Situacao::create($data);

        app(SituacaoSyncService::class)->insert($situacao);

        return $situacao;
    }

    public function update(int $id, array $data)
    {
        $situacao = $this->find($id);
        $situacao->update($data);

        app(SituacaoSyncService::class)->update($situacao->fresh());

        return $situacao;
    }

    public function delete(int $id)
    {
        // Registro
        $situacao = $this->find($id);

        // Verificar relacionamentos
        $relacionamento = $this->relacionamento($id);
        if ($relacionamento['status'] === false) {
            throw new \Exception($relacionamento['message']);
        }

        // Deletar
        $situacao->delete();

        app(SituacaoSyncService::class)->delete($id);

        return;
    }

    public function relacionamento(int $id)
    {
        $qtd = DB::table('militares')->where('situacao_id', $id)->count();

        if ($qtd > 0) {
            return ['status' => false, 'message' => 'Operação não permitida.<br> Relacionamento com Militares.'];
        }

        return ['status' => true];
    }
}
