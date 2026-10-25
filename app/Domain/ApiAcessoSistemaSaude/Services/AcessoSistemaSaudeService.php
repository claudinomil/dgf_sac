<?php

namespace App\Domain\ApiAcessoSistemaSaude\Services;

use App\Domain\ApiAcessoSistemaSaude\Repositories\AcessoSistemaSaudeRepository;

class AcessoSistemaSaudeService
{
    public function __construct(private readonly AcessoSistemaSaudeRepository $acessoSistemaSaudeRepository)
    {}

    public function consultar(string $cpf, int $api_acesso_sistema_saude_usuario_id): ?array
    {
        $militar = $this->acessoSistemaSaudeRepository->buscarMilitarPorCpf($cpf);

        if (!$militar) {
            return null;
        }

        // Gravar na tabela de Controle
        $this->acessoSistemaSaudeRepository->gravarControle($api_acesso_sistema_saude_usuario_id, $militar->militarId);

        // Dependentes do Militar
        $dependentes = $this->acessoSistemaSaudeRepository->buscarDependentesPorMilitar($cpf);

        // Acertos
        $militar_tipo_acesso = 'NEGADO';

        if ($militar->tipo_acesso == 0) {
            $militar_tipo_acesso = 'NEGADO';
        } else if ($militar->tipo_acesso == 1) {
            $militar_tipo_acesso = 'INTEGRAL';
        } else if ($militar->tipo_acesso == 2) {
            $militar_tipo_acesso = 'AMBULATORIAL';
        }

        $total_dependentes = count($dependentes);

        return [
            'militar' => [
                'nome' => $militar->nome,
                'cpf' => $militar->cpf,
                'acesso_sistema_saude' => [
                    'desconto_ativo' => (int) $militar->acesso_sistema_saude === 1,
                    'tipo_acesso' => $militar_tipo_acesso
                ]
            ],
            'dependentes' => $dependentes,
            'total_dependentes' => $total_dependentes,
        ];
    }

    public function retornar_controle()
    {
        return $this->acessoSistemaSaudeRepository->retornarControle();
    }
}