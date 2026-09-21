<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permissao;

class PermissoesSeeder extends Seeder
{
    public function run()
    {
        // Users
        Permissao::create(['id' => 1, 'submodulo_id' => 1, 'name' => 'users_list']);
        Permissao::create(['id' => 2, 'submodulo_id' => 1, 'name' => 'users_create']);
        Permissao::create(['id' => 3, 'submodulo_id' => 1, 'name' => 'users_show']);
        Permissao::create(['id' => 4, 'submodulo_id' => 1, 'name' => 'users_edit']);
        Permissao::create(['id' => 5, 'submodulo_id' => 1, 'name' => 'users_destroy']);

        // Grupos
        Permissao::create(['id' => 6, 'submodulo_id' => 2, 'name' => 'grupos_list']);
        Permissao::create(['id' => 7, 'submodulo_id' => 2, 'name' => 'grupos_create']);
        Permissao::create(['id' => 8, 'submodulo_id' => 2, 'name' => 'grupos_show']);
        Permissao::create(['id' => 9, 'submodulo_id' => 2, 'name' => 'grupos_edit']);
        Permissao::create(['id' => 10, 'submodulo_id' => 2, 'name' => 'grupos_destroy']);

        // SAD Militares Informações
        Permissao::create(['id' => 11, 'submodulo_id' => 24, 'name' => 'sad_militares_informacoes_list']);
        Permissao::create(['id' => 12, 'submodulo_id' => 24, 'name' => 'sad_militares_informacoes_create']);
        Permissao::create(['id' => 13, 'submodulo_id' => 24, 'name' => 'sad_militares_informacoes_show']);
        Permissao::create(['id' => 14, 'submodulo_id' => 24, 'name' => 'sad_militares_informacoes_edit']);
        Permissao::create(['id' => 15, 'submodulo_id' => 24, 'name' => 'sad_militares_informacoes_destroy']);

        // Transações
        Permissao::create(['id' => 16, 'submodulo_id' => 4, 'name' => 'transacoes_list']);
        Permissao::create(['id' => 17, 'submodulo_id' => 4, 'name' => 'transacoes_create']);
        Permissao::create(['id' => 18, 'submodulo_id' => 4, 'name' => 'transacoes_show']);
        Permissao::create(['id' => 19, 'submodulo_id' => 4, 'name' => 'transacoes_edit']);
        Permissao::create(['id' => 20, 'submodulo_id' => 4, 'name' => 'transacoes_destroy']);

        // Dashboards
        Permissao::create(['id' => 26, 'submodulo_id' => 8, 'name' => 'dashboards_list']);

        // Users Perfil
        Permissao::create(['id' => 31, 'submodulo_id' => 9, 'name' => 'users_perfil_show']);
        Permissao::create(['id' => 32, 'submodulo_id' => 9, 'name' => 'users_perfil_edit']);

        // Ressarcimento Órgãos
        Permissao::create(['id' => 33, 'submodulo_id' => 10, 'name' => 'ressarcimento_orgaos_list']);
        Permissao::create(['id' => 35, 'submodulo_id' => 10, 'name' => 'ressarcimento_orgaos_show']);
        Permissao::create(['id' => 36, 'submodulo_id' => 10, 'name' => 'ressarcimento_orgaos_edit']);

        // Ressarcimento Pagamentos
        Permissao::create(['id' => 38, 'submodulo_id' => 11, 'name' => 'ressarcimento_pagamentos_list']);
        Permissao::create(['id' => 39, 'submodulo_id' => 11, 'name' => 'ressarcimento_pagamentos_create']);
        Permissao::create(['id' => 40, 'submodulo_id' => 11, 'name' => 'ressarcimento_pagamentos_show']);
        Permissao::create(['id' => 41, 'submodulo_id' => 11, 'name' => 'ressarcimento_pagamentos_edit']);
        Permissao::create(['id' => 42, 'submodulo_id' => 11, 'name' => 'ressarcimento_pagamentos_destroy']);

        // Ressarcimento Militares
        Permissao::create(['id' => 43, 'submodulo_id' => 12, 'name' => 'ressarcimento_militares_list']);
        Permissao::create(['id' => 44, 'submodulo_id' => 12, 'name' => 'ressarcimento_militares_create']);
        Permissao::create(['id' => 45, 'submodulo_id' => 12, 'name' => 'ressarcimento_militares_show']);
        // Permissao::create(['id' => 46, 'submodulo_id' => 12, 'name' => 'ressarcimento_militares_edit']);
        Permissao::create(['id' => 47, 'submodulo_id' => 12, 'name' => 'ressarcimento_militares_destroy']);

        // Ressarcimento Cobranças
        Permissao::create(['id' => 48, 'submodulo_id' => 13, 'name' => 'ressarcimento_cobrancas_list']);
        // Permissao::create(['id' => 49, 'submodulo_id' => 13, 'name' => 'ressarcimento_cobrancas_create']);
        // Permissao::create(['id' => 50, 'submodulo_id' => 13, 'name' => 'ressarcimento_cobrancas_show']);
        // Permissao::create(['id' => 51, 'submodulo_id' => 13, 'name' => 'ressarcimento_cobrancas_edit']);
        // Permissao::create(['id' => 52, 'submodulo_id' => 13, 'name' => 'ressarcimento_cobrancas_destroy']);

        // Ressarcimento Configurações
        Permissao::create(['id' => 53, 'submodulo_id' => 6, 'name' => 'ressarcimento_configuracoes_list']);
        // Permissao::create(['id' => 54, 'submodulo_id' => 6, 'name' => 'ressarcimento_configuracoes_create']);
        Permissao::create(['id' => 55, 'submodulo_id' => 6, 'name' => 'ressarcimento_configuracoes_show']);
        Permissao::create(['id' => 56, 'submodulo_id' => 6, 'name' => 'ressarcimento_configuracoes_edit']);
        // Permissao::create(['id' => 57, 'submodulo_id' => 6, 'name' => 'ressarcimento_configuracoes_destroy']);

        // Ressarcimento Referências
        Permissao::create(['id' => 58, 'submodulo_id' => 7, 'name' => 'ressarcimento_referencias_list']);
        Permissao::create(['id' => 59, 'submodulo_id' => 7, 'name' => 'ressarcimento_referencias_create']);
        Permissao::create(['id' => 60, 'submodulo_id' => 7, 'name' => 'ressarcimento_referencias_show']);
        Permissao::create(['id' => 61, 'submodulo_id' => 7, 'name' => 'ressarcimento_referencias_edit']);
        Permissao::create(['id' => 62, 'submodulo_id' => 7, 'name' => 'ressarcimento_referencias_destroy']);

        // Ressarcimento Recebimentos
        Permissao::create(['id' => 63, 'submodulo_id' => 14, 'name' => 'ressarcimento_recebimentos_list']);
        // Permissao::create(['id' => 64, 'submodulo_id' => 14, 'name' => 'ressarcimento_recebimentos_create']);
        Permissao::create(['id' => 65, 'submodulo_id' => 14, 'name' => 'ressarcimento_recebimentos_show']);
        Permissao::create(['id' => 66, 'submodulo_id' => 14, 'name' => 'ressarcimento_recebimentos_edit']);
        // Permissao::create(['id' => 67, 'submodulo_id' => 14, 'name' => 'ressarcimento_recebimentos_destroy']);

        // Ressarcimento Exclusões
        Permissao::create(['id' => 21, 'submodulo_id' => 25, 'name' => 'ressarcimento_exclusoes_list']);
        Permissao::create(['id' => 22, 'submodulo_id' => 25, 'name' => 'ressarcimento_exclusoes_create']);

        // Relatórios
        Permissao::create(['id' => 78, 'submodulo_id' => 17, 'name' => 'relatorios_list']);
        // Permissao::create(['id' => 79, 'submodulo_id' => 17, 'name' => 'relatorios_create']);
        // Permissao::create(['id' => 80, 'submodulo_id' => 17, 'name' => 'relatorios_show']);
        // Permissao::create(['id' => 81, 'submodulo_id' => 17, 'name' => 'relatorios_edit']);
        // Permissao::create(['id' => 82, 'submodulo_id' => 17, 'name' => 'relatorios_destroy']);

        // Militares
        Permissao::create(['id' => 83, 'submodulo_id' => 18, 'name' => 'militares_list']);
        Permissao::create(['id' => 84, 'submodulo_id' => 18, 'name' => 'militares_create']);
        Permissao::create(['id' => 85, 'submodulo_id' => 18, 'name' => 'militares_show']);
        Permissao::create(['id' => 86, 'submodulo_id' => 18, 'name' => 'militares_edit']);
        Permissao::create(['id' => 87, 'submodulo_id' => 18, 'name' => 'militares_destroy']);

        // Cursos
        Permissao::create(['id' => 88, 'submodulo_id' => 15, 'name' => 'militares_cursos_list']);
        Permissao::create(['id' => 89, 'submodulo_id' => 15, 'name' => 'militares_cursos_create']);
        Permissao::create(['id' => 90, 'submodulo_id' => 15, 'name' => 'militares_cursos_show']);
        Permissao::create(['id' => 91, 'submodulo_id' => 15, 'name' => 'militares_cursos_edit']);
        Permissao::create(['id' => 92, 'submodulo_id' => 15, 'name' => 'militares_cursos_destroy']);

        // Contatos
        Permissao::create(['id' => 93, 'submodulo_id' => 23, 'name' => 'militares_contatos_list']);
        Permissao::create(['id' => 94, 'submodulo_id' => 23, 'name' => 'militares_contatos_create']);
        Permissao::create(['id' => 95, 'submodulo_id' => 23, 'name' => 'militares_contatos_show']);
        Permissao::create(['id' => 96, 'submodulo_id' => 23, 'name' => 'militares_contatos_edit']);
        Permissao::create(['id' => 97, 'submodulo_id' => 23, 'name' => 'militares_contatos_destroy']);

        // Ajudas de Custos
        Permissao::create(['id' => 98, 'submodulo_id' => 3, 'name' => 'militares_ajudas_custos_list']);
        Permissao::create(['id' => 99, 'submodulo_id' => 3, 'name' => 'militares_ajudas_custos_create']);
        Permissao::create(['id' => 100, 'submodulo_id' => 3, 'name' => 'militares_ajudas_custos_show']);
        Permissao::create(['id' => 101, 'submodulo_id' => 3, 'name' => 'militares_ajudas_custos_edit']);
        Permissao::create(['id' => 102, 'submodulo_id' => 3, 'name' => 'militares_ajudas_custos_destroy']);

        // Auxílios Fardamentos
        Permissao::create(['id' => 103, 'submodulo_id' => 5, 'name' => 'militares_auxilios_fardamentos_list']);
        Permissao::create(['id' => 104, 'submodulo_id' => 5, 'name' => 'militares_auxilios_fardamentos_create']);
        Permissao::create(['id' => 105, 'submodulo_id' => 5, 'name' => 'militares_auxilios_fardamentos_show']);
        Permissao::create(['id' => 106, 'submodulo_id' => 5, 'name' => 'militares_auxilios_fardamentos_edit']);
        Permissao::create(['id' => 107, 'submodulo_id' => 5, 'name' => 'militares_auxilios_fardamentos_destroy']);

        // Dependentes
        Permissao::create(['id' => 108, 'submodulo_id' => 16, 'name' => 'militares_dependentes_list']);
        Permissao::create(['id' => 109, 'submodulo_id' => 16, 'name' => 'militares_dependentes_create']);
        Permissao::create(['id' => 110, 'submodulo_id' => 16, 'name' => 'militares_dependentes_show']);
        Permissao::create(['id' => 111, 'submodulo_id' => 16, 'name' => 'militares_dependentes_edit']);
        Permissao::create(['id' => 112, 'submodulo_id' => 16, 'name' => 'militares_dependentes_destroy']);

        // Fundos de Saúde
        Permissao::create(['id' => 113, 'submodulo_id' => 19, 'name' => 'militares_fundos_saude_list']);
        Permissao::create(['id' => 114, 'submodulo_id' => 19, 'name' => 'militares_fundos_saude_create']);
        Permissao::create(['id' => 115, 'submodulo_id' => 19, 'name' => 'militares_fundos_saude_show']);
        Permissao::create(['id' => 116, 'submodulo_id' => 19, 'name' => 'militares_fundos_saude_edit']);
        Permissao::create(['id' => 117, 'submodulo_id' => 19, 'name' => 'militares_fundos_saude_destroy']);

        // Situações
        Permissao::create(['id' => 118, 'submodulo_id' => 26, 'name' => 'situacoes_list']);
        Permissao::create(['id' => 119, 'submodulo_id' => 26, 'name' => 'situacoes_create']);
        Permissao::create(['id' => 120, 'submodulo_id' => 26, 'name' => 'situacoes_show']);
        Permissao::create(['id' => 121, 'submodulo_id' => 26, 'name' => 'situacoes_edit']);
        Permissao::create(['id' => 122, 'submodulo_id' => 26, 'name' => 'situacoes_destroy']);

        // Graduações
        Permissao::create(['id' => 123, 'submodulo_id' => 27, 'name' => 'graduacoes_list']);
        Permissao::create(['id' => 124, 'submodulo_id' => 27, 'name' => 'graduacoes_create']);
        Permissao::create(['id' => 125, 'submodulo_id' => 27, 'name' => 'graduacoes_show']);
        Permissao::create(['id' => 126, 'submodulo_id' => 27, 'name' => 'graduacoes_edit']);
        Permissao::create(['id' => 127, 'submodulo_id' => 27, 'name' => 'graduacoes_destroy']);

        // Quadros
        Permissao::create(['id' => 128, 'submodulo_id' => 28, 'name' => 'quadros_list']);
        Permissao::create(['id' => 129, 'submodulo_id' => 28, 'name' => 'quadros_create']);
        Permissao::create(['id' => 130, 'submodulo_id' => 28, 'name' => 'quadros_show']);
        Permissao::create(['id' => 131, 'submodulo_id' => 28, 'name' => 'quadros_edit']);
        Permissao::create(['id' => 132, 'submodulo_id' => 28, 'name' => 'quadros_destroy']);

        // Comportamentos
        Permissao::create(['id' => 133, 'submodulo_id' => 29, 'name' => 'comportamentos_list']);
        Permissao::create(['id' => 134, 'submodulo_id' => 29, 'name' => 'comportamentos_create']);
        Permissao::create(['id' => 135, 'submodulo_id' => 29, 'name' => 'comportamentos_show']);
        Permissao::create(['id' => 136, 'submodulo_id' => 29, 'name' => 'comportamentos_edit']);
        Permissao::create(['id' => 137, 'submodulo_id' => 29, 'name' => 'comportamentos_destroy']);

        // Unidades
        Permissao::create(['id' => 138, 'submodulo_id' => 30, 'name' => 'unidades_list']);
        Permissao::create(['id' => 139, 'submodulo_id' => 30, 'name' => 'unidades_create']);
        Permissao::create(['id' => 140, 'submodulo_id' => 30, 'name' => 'unidades_show']);
        Permissao::create(['id' => 141, 'submodulo_id' => 30, 'name' => 'unidades_edit']);
        Permissao::create(['id' => 142, 'submodulo_id' => 30, 'name' => 'unidades_destroy']);

        // Funções
        Permissao::create(['id' => 143, 'submodulo_id' => 31, 'name' => 'funcoes_list']);
        Permissao::create(['id' => 144, 'submodulo_id' => 31, 'name' => 'funcoes_create']);
        Permissao::create(['id' => 145, 'submodulo_id' => 31, 'name' => 'funcoes_show']);
        Permissao::create(['id' => 146, 'submodulo_id' => 31, 'name' => 'funcoes_edit']);
        Permissao::create(['id' => 147, 'submodulo_id' => 31, 'name' => 'funcoes_destroy']);

        // Gêneros
        Permissao::create(['id' => 148, 'submodulo_id' => 32, 'name' => 'generos_list']);
        Permissao::create(['id' => 149, 'submodulo_id' => 32, 'name' => 'generos_create']);
        Permissao::create(['id' => 150, 'submodulo_id' => 32, 'name' => 'generos_show']);
        Permissao::create(['id' => 151, 'submodulo_id' => 32, 'name' => 'generos_edit']);
        Permissao::create(['id' => 152, 'submodulo_id' => 32, 'name' => 'generos_destroy']);

        // Parentescos
        Permissao::create(['id' => 153, 'submodulo_id' => 33, 'name' => 'parentescos_list']);
        Permissao::create(['id' => 154, 'submodulo_id' => 33, 'name' => 'parentescos_create']);
        Permissao::create(['id' => 155, 'submodulo_id' => 33, 'name' => 'parentescos_show']);
        Permissao::create(['id' => 156, 'submodulo_id' => 33, 'name' => 'parentescos_edit']);
        Permissao::create(['id' => 157, 'submodulo_id' => 33, 'name' => 'parentescos_destroy']);

        // Cursos
        Permissao::create(['id' => 158, 'submodulo_id' => 34, 'name' => 'cursos_list']);
        Permissao::create(['id' => 159, 'submodulo_id' => 34, 'name' => 'cursos_create']);
        Permissao::create(['id' => 160, 'submodulo_id' => 34, 'name' => 'cursos_show']);
        Permissao::create(['id' => 161, 'submodulo_id' => 34, 'name' => 'cursos_edit']);
        Permissao::create(['id' => 162, 'submodulo_id' => 34, 'name' => 'cursos_destroy']);
    }
}
