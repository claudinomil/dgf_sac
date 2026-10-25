<?php

namespace App\Domain\ApiAcessoSistemaSaude\Repositories;

use App\Models\ApiAcessoSistemaSaudeControle;
use App\Models\Militar;

class AcessoSistemaSaudeRepository
{
    public function buscarMilitarPorCpf(string $cpf): ?object
    {
        return Militar::join('militares_fundos_saude', 'militares_fundos_saude.militar_id', 'militares.id')
        ->select([
                'militares.id as militarId',
                'militares.nome',
                'militares.cpf',
                'militares_fundos_saude.acesso_sistema_saude',
                'militares_fundos_saude.tipo_acesso',
            ])
            ->where('cpf', $cpf)
            ->first();
    }

    public function buscarDependentesPorMilitar(string $cpf): array
    {
        return Militar::join('militares_dependentes', 'militares_dependentes.militar_id', 'militares.id')
            ->where('militares.cpf', $cpf)
            ->select([
                'militares_dependentes.militar_id',
                'militares_dependentes.name',
                'militares_dependentes.acesso_sistema_saude_dependente',
                'militares_dependentes.tipo_acesso'
            ])
            ->get()
            ->map(function ($dependente) {
                // Acertos
                $dependente_tipo_acesso = 'NEGADO';

                if ($dependente->tipo_acesso == 0) {
                    $dependente_tipo_acesso = 'NEGADO';
                } else if ($dependente->tipo_acesso == 1) {
                    $dependente_tipo_acesso = 'INTEGRAL';
                } else if ($dependente->tipo_acesso == 2) {
                    $dependente_tipo_acesso = 'AMBULATORIAL';
                }

                return [
                    'dependente' => $dependente->name,
                    'acesso_sistema_saude' => [
                        'desconto_ativo' => (int) $dependente->acesso_sistema_saude_dependente === 1,
                        'tipo_acesso' => $dependente_tipo_acesso
                    ]
                ];
            })
            ->all();
    }

    public function gravarControle(int $api_acesso_sistema_saude_usuario_id, int $militar_id)
    {
        ApiAcessoSistemaSaudeControle::create([
            'api_acesso_sistema_saude_usuario_id' => $api_acesso_sistema_saude_usuario_id,
            'origem' => '',
            'militar_id' => $militar_id,
            'data' => date('Y-m-d'),
            'hora' => date('H:i:s')
        ]);

        return;
    }
    
    public function retornarControle()
    {
        return ApiAcessoSistemaSaudeControle::join('api_acesso_sistema_saude_usuarios', 'api_acesso_sistema_saude_usuarios.id', 'api_acesso_sistema_saude_controle.api_acesso_sistema_saude_usuario_id')
            ->join('militares', 'militares.id', 'api_acesso_sistema_saude_controle.militar_id')
            ->join('graduacoes', 'graduacoes.id', 'militares.graduacao_id')
            ->select(
                'api_acesso_sistema_saude_controle.*',
                'api_acesso_sistema_saude_usuarios.nome as usuarioName',
                'militares.nome as militarName',
                'militares.cpf as militarCpf',
                'graduacoes.name as militarGraduacaoName'
            )
            ->orderby('api_acesso_sistema_saude_controle.data', 'DESC')
            ->orderby('api_acesso_sistema_saude_controle.hora', 'DESC')
            ->get();
    }
}