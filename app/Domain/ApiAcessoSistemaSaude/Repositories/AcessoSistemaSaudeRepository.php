<?php

namespace App\Domain\ApiAcessoSistemaSaude\Repositories;

use App\Models\Militar;

class AcessoSistemaSaudeRepository
{
    public function buscarMilitarPorCpf(string $cpf): ?object
    {
        return Militar::join('militares_fundos_saude', 'militares_fundos_saude.militar_id', 'militares.id')
        ->select([
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
}
