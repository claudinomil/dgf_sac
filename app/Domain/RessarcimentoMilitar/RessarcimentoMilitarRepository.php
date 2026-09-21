<?php

namespace App\Domain\RessarcimentoMilitar;

use App\Models\RessarcimentoMilitar;
use Illuminate\Support\Facades\DB;

class RessarcimentoMilitarRepository
{
    public function all()
    {
        return RessarcimentoMilitar::all();
    }

    public function index($limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        return RessarcimentoMilitar::orderby('referencia', 'desc')->limit($limit)->get();
    }

    public function filter($array_dados, $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = RessarcimentoMilitar::select(['ressarcimento_militares.*'])
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

    public function find($id)
    {
        return RessarcimentoMilitar::find($id);
    }

    public function militares_lotacao_referencia($lotacao_id, $referencia)
    {
        return RessarcimentoMilitar::where('lotacao_id', $lotacao_id)->where('referencia', $referencia)->get();
    }

    public function create(array $data)
    {
        return RessarcimentoMilitar::create($data);
    }

    public function update($id, array $data)
    {
        $ressarcimento_militar = $this->find($id);

        $ressarcimento_militar->update($data);

        return $ressarcimento_militar;
    }

    public function delete($id)
    {
        $ressarcimento_militar = $this->find($id);

        // Verificar relacionamentos
        $relacionamento = $this->relacionamento($id, $ressarcimento_militar->referencia);
        if ($relacionamento['status'] === false) {
            throw new \Exception($relacionamento['message']);
        }

        return $ressarcimento_militar->delete();
    }

    public function relacionamento($id, $referencia)
    {
        // Não deixar excluir se Cobrança da Referência estiver fechada
        $cobrancaFechada = DB::table('ressarcimento_cobrancas')->where('cobranca_encerrada', 1)->where('referencia', $referencia)->count();

        if ($cobrancaFechada == 1) {
            return ['status' => false, 'message' => 'Náo é possível excluir. Cobrança fechada para a referência: '.getReferencia(1, $referencia)];
        }

        // Tabela Pagamentos
        $qtd = DB::table('ressarcimento_pagamentos')->where('ressarcimento_militar_id', $id)->count();

        if ($qtd > 0) {return ['status' => false, 'message' => 'Operação não permitida.<br> Relacionamento com Ressarcimento Pagamentos.'];}

        return ['status' => true];
    }

    // Importar Militares - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    // Importar Militares - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    public function insertRegistro(array $dados) {
        return RessarcimentoMilitar::create($dados);
    }

    public function existe($referencia, $identidadeFuncional)
    {
        return RessarcimentoMilitar::where('referencia', $referencia)
            ->where('identidade_funcional', $identidadeFuncional)->exists();
    }
    // Importar Militares - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    // Importar Militares - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}
