<?php

namespace App\Domain\Graduacao;

use App\Models\Graduacao;

use App\Services\GraduacaoSyncService;
use Illuminate\Support\Facades\DB;

class GraduacaoRepository
{
    public function all()
    {
        return Graduacao::orderby('name')->get();
    }

    public function index(int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Return
        $query = Graduacao::orderBy('name')->limit($limit);

        return $query->get();
    }

    public function filter($array_dados, int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = Graduacao::where(function($query) use($filtros) {
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
        return Graduacao::find($id);
    }

    public function create(array $data)
    {
        // Último registro pelo maior ID
        $ultimo = Graduacao::latest('id')->first();
        $codigoGraduacao = (int) ($ultimo['codigo_graduacao'] ?? 0);
        $codigoGraduacao++;
        $data['codigo_graduacao'] = $codigoGraduacao < 10 ? '0' . $codigoGraduacao : (string) $codigoGraduacao;

        // Criar
        $graduacao = Graduacao::create($data);

        app(GraduacaoSyncService::class)->insert($graduacao);

        return $graduacao;
    }

    public function update(int $id, array $data)
    {
        $graduacao = $this->find($id);

        $graduacao->update($data);

        app(GraduacaoSyncService::class)->update($graduacao->fresh());

        return $graduacao;
    }

    public function delete(int $id)
    {
        // Registro
        $graduacao = $this->find($id);

        // Verificar relacionamentos
        $relacionamento = $this->relacionamento($id);
        if ($relacionamento['status'] === false) {
            throw new \Exception($relacionamento['message']);
        }

        // Pegar codigo_graduacao
        $codigo_graduacao = $graduacao->codigo_graduacao;

        // Deletar
        $graduacao->delete();

        app(GraduacaoSyncService::class)->delete($id, $codigo_graduacao);

        return;
    }

    public function relacionamento(int $id)
    {
        $qtd = DB::table('militares')->where('graduacao_id', $id)->count();

        if ($qtd > 0) {
            return ['status' => false, 'message' => 'Operação não permitida.<br> Relacionamento com Militares.'];
        }

        return ['status' => true];
    }
}
