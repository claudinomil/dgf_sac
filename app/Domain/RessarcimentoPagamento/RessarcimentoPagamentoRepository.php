<?php

namespace App\Domain\RessarcimentoPagamento;

use App\Models\RessarcimentoMilitar;
use App\Models\RessarcimentoPagamento;
use Illuminate\Support\Facades\DB;

class RessarcimentoPagamentoRepository
{
    public function all()
    {
        return RessarcimentoPagamento::all();
    }

    public function index($limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        return RessarcimentoPagamento
            ::leftJoin('ressarcimento_militares', function ($join) {
                $join->on('ressarcimento_pagamentos.referencia', '=', 'ressarcimento_militares.referencia')
                    ->on('ressarcimento_pagamentos.rg', '=', 'ressarcimento_militares.rg');
            })
            ->select('ressarcimento_pagamentos.*', 'ressarcimento_militares.lotacao')
            ->orderby('referencia', 'desc')
            ->limit($limit)
            ->get();
    }

    public function filter($array_dados, $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = RessarcimentoPagamento::select(['ressarcimento_pagamentos.*'])
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
        return RessarcimentoPagamento::find($id);
    }

    public function pagamento_idfunc_referencia($identidade_funcional, $referencia)
    {
        return RessarcimentoPagamento::where('identidade_funcional', $identidade_funcional)->where('referencia', $referencia)->get();
    }

    public function create(array $data)
    {
        return RessarcimentoPagamento::create($data);
    }

    public function update($id, array $data)
    {
        $ressarcimento_pagamento = $this->find($id);

        $ressarcimento_pagamento->update($data);

        return $ressarcimento_pagamento;
    }

    public function delete($id)
    {
        $ressarcimento_pagamento = $this->find($id);

        // Verificar relacionamentos
        $relacionamento = $this->relacionamento($id, $ressarcimento_pagamento->referencia);
        if ($relacionamento['status'] === false) {
            throw new \Exception($relacionamento['message']);
        }

        return $ressarcimento_pagamento->delete();
    }

    public function relacionamento($id, $referencia)
    {
        // Tabela Ressarcimento Cobrança Dados
        $qtd = DB::table('ressarcimento_cobrancas_dados')->where('ressarcimento_pagamento_id', $id)->count();

        if ($qtd > 0) {return ['status' => false, 'message' => 'Operação não permitida.<br> Relacionamento com Ressarcimento Cobranças.'];}

        return ['status' => true];
    }

    // Importar Pagamentos - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    // Importar Pagamentos - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    public function buscarMilitaresPorReferencia($referencia)
    {
        return RessarcimentoMilitar::where('referencia', $referencia)->get();
    }

    public function registroExiste($referencia, $identidadeFuncional)
    {
        return RessarcimentoPagamento::where('referencia', $referencia)->where('identidade_funcional', $identidadeFuncional)->exists();
    }

    public function insertRegistro(array $dados)
    {
        return RessarcimentoPagamento::create($dados);
    }
    // Importar Pagamentos - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    // Importar Pagamentos - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}
