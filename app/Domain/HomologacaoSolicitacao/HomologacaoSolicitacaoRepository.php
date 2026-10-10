<?php

namespace App\Domain\HomologacaoSolicitacao;

use App\Models\HomologacaoSolicitacao;

class HomologacaoSolicitacaoRepository
{
    public function index(int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Return
        return HomologacaoSolicitacao::leftjoin('submodulos', 'submodulos.id', 'homologacao_solicitacoes.submodulo_id')
            ->select(
                'homologacao_solicitacoes.*',
                'submodulos.name as submoduloName'
            )
            ->where(function ($query) {
                $query->where('homologacao_solicitacoes.resposta', '')
                    ->orWhereNull('homologacao_solicitacoes.resposta');
            })
            ->orderby('homologacao_solicitacoes.solicitacao_data')
            ->orderby('homologacao_solicitacoes.solicitacao_hora')
            ->limit($limit)
            ->get();
    }

    public function filter(string $array_dados, int $limit)
    {
        // Limit
        $limit = $limit ? $limit : 1000;

        // Filtros enviados pelo Client
        $filtros = explode(',', $array_dados);

        // Registros
        $registros = HomologacaoSolicitacao::leftjoin('submodulos', 'submodulos.id', 'homologacao_solicitacoes.submodulo_id')
            ->select(
                'homologacao_solicitacoes.*',
                'submodulos.name as submoduloName'
            )
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
            })
            ->limit($limit)
            ->get();

        return $registros;
    }

    public function find(int $id)
    {
        $query = HomologacaoSolicitacao::leftjoin('submodulos', 'submodulos.id', 'homologacao_solicitacoes.submodulo_id')
            ->select(
                'homologacao_solicitacoes.*',
                'submodulos.name as submoduloName'
            );

        return $query->find($id);
    }

    public function create(array $data)
    {
        // Acertos
        $data['solicitacao_data'] = date('Y-m-d');
        $data['solicitacao_hora'] = date('H:i:s');
        $data['user_id'] = session('userContext.user.id');

        // Criar
        $homologacao_solicitacao = HomologacaoSolicitacao::create($data);

        // Solicitação Imagem
        if ($data['solicitacao_imagem_file']) {
            $file = $data['solicitacao_imagem_file'];
            $ext = $file->getClientOriginalExtension();
            $fileName = 'imagem-' . $homologacao_solicitacao->id . '.' . $ext;
            $destination = public_path('/assets/images/homologacao_solicitacoes');
            $file->move($destination, $fileName);
            $solicitacao_imagem = 'assets/images/homologacao_solicitacoes/' . $fileName;
            
            $this->update_solicitacao_imagem($homologacao_solicitacao->id, $solicitacao_imagem);
        }

        return $homologacao_solicitacao;
    }
    
    public function update_solicitacao_imagem(int $id, string $solicitacao_imagem)
    {
        $homologacao_solicitacao = $this->find($id);
        $homologacao_solicitacao->update(['solicitacao_imagem' => $solicitacao_imagem]);
        
        return;
    }
    
    public function update(int $id, array $data)
    {
        // Acertos
        $data['resposta_data'] = date('Y-m-d');
        $data['resposta_hora'] = date('H:i:s');

        $homologacao_solicitacao = $this->find($id);
        $homologacao_solicitacao->update($data);

        return $homologacao_solicitacao;
    }

    public function delete(int $id)
    {
        $homologacao_solicitacao = $this->find($id);
        $homologacao_solicitacao->delete();

        return;
    }
}
