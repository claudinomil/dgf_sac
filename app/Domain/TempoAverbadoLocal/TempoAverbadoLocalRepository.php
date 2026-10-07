<?php

namespace App\Domain\TempoAverbadoLocal;

use App\Models\TempoAverbadoLocal;
use App\Services\TempoAverbadoLocalSyncService;

class TempoAverbadoLocalRepository
{
    public function index(int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Return
        $query = TempoAverbadoLocal::orderBy('name')->limit($limit);

        return $query->get();
    }

    public function filter($array_dados, int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = TempoAverbadoLocal::where(function($query) use($filtros) {
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
            ->orderBy('tempos_averbados.name')
            ->limit($limit)
            ->get();

        return $registros;
    }

    public function find(int $id)
    {
        return TempoAverbadoLocal::find($id);
    }

    public function create(array $data)
    {
        $tempo_averbado_local = TempoAverbadoLocal::create($data);

        app(TempoAverbadoLocalSyncService::class)->insert($tempo_averbado_local);

        return $tempo_averbado_local;
    }

    public function update(int $id, array $data)
    {
        $tempo_averbado_local = $this->find($id);
        $tempo_averbado_local->update($data);

        app(TempoAverbadoLocalSyncService::class)->update($tempo_averbado_local->fresh());

        return $tempo_averbado_local;
    }

    public function delete(int $id)
    {
        $tempo_averbado_local = $this->find($id);
        $tempo_averbado_local->delete();

        app(TempoAverbadoLocalSyncService::class)->delete($id);

        return;
    }
}