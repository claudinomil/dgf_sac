<?php

namespace Database\Seeders;

use App\Models\Grupo;
use Illuminate\Database\Seeder;

class GruposSeeder extends Seeder
{
    public function run()
    {
        Grupo::create(['id' => 1, 'name' => 'Administrador Geral',
            'militares_permissoes_list_situacoes_ids' => 1,
            'militares_permissoes_show_situacoes_ids' => 1,
            'militares_permissoes_create_situacoes_ids' => 1,
            'militares_permissoes_edit_situacoes_ids' => 1,
            'militares_permissoes_destroy_situacoes_ids' => 1,
            'militares_ajudas_custos_permissoes_list_situacoes_ids' => 1,
            'militares_ajudas_custos_permissoes_show_situacoes_ids' => 1,
            'militares_ajudas_custos_permissoes_create_situacoes_ids' => 1,
            'militares_ajudas_custos_permissoes_edit_situacoes_ids' => 1,
            'militares_ajudas_custos_permissoes_destroy_situacoes_ids' => 1,
            'militares_auxilios_fardamentos_permissoes_list_situacoes_ids' => 1,
            'militares_auxilios_fardamentos_permissoes_show_situacoes_ids' => 1,
            'militares_auxilios_fardamentos_permissoes_create_situacoes_ids' => 1,
            'militares_auxilios_fardamentos_permissoes_edit_situacoes_ids' => 1,
            'militares_auxilios_fardamentos_permissoes_destroy_situacoes_ids' => 1,
            'militares_cursos_permissoes_list_situacoes_ids' => 1,
            'militares_cursos_permissoes_show_situacoes_ids' => 1,
            'militares_cursos_permissoes_create_situacoes_ids' => 1,
            'militares_cursos_permissoes_edit_situacoes_ids' => 1,
            'militares_cursos_permissoes_destroy_situacoes_ids' => 1,
            'militares_contatos_permissoes_list_situacoes_ids' => 1,
            'militares_contatos_permissoes_show_situacoes_ids' => 1,
            'militares_contatos_permissoes_create_situacoes_ids' => 1,
            'militares_contatos_permissoes_edit_situacoes_ids' => 1,
            'militares_contatos_permissoes_destroy_situacoes_ids' => 1,
            'militares_dependentes_permissoes_list_situacoes_ids' => 1,
            'militares_dependentes_permissoes_show_situacoes_ids' => 1,
            'militares_dependentes_permissoes_create_situacoes_ids' => 1,
            'militares_dependentes_permissoes_edit_situacoes_ids' => 1,
            'militares_dependentes_permissoes_destroy_situacoes_ids' => 1,
            'militares_fundos_saude_permissoes_list_situacoes_ids' => 1,
            'militares_fundos_saude_permissoes_show_situacoes_ids' => 1,
            'militares_fundos_saude_permissoes_create_situacoes_ids' => 1,
            'militares_fundos_saude_permissoes_edit_situacoes_ids' => 1,
            'militares_fundos_saude_permissoes_destroy_situacoes_ids' => 1,
            'militares_ferias_permissoes_list_situacoes_ids' => 1,
            'militares_ferias_permissoes_show_situacoes_ids' => 1,
            'militares_ferias_permissoes_create_situacoes_ids' => 1,
            'militares_ferias_permissoes_edit_situacoes_ids' => 1,
            'militares_ferias_permissoes_destroy_situacoes_ids' => 1,
            'militares_pensoes_permissoes_list_situacoes_ids' => 1,
            'militares_pensoes_permissoes_show_situacoes_ids' => 1,
            'militares_pensoes_permissoes_create_situacoes_ids' => 1,
            'militares_pensoes_permissoes_edit_situacoes_ids' => 1,
            'militares_pensoes_permissoes_destroy_situacoes_ids' => 1,
            'militares_tempos_averbados_permissoes_list_situacoes_ids' => 1,
            'militares_tempos_averbados_permissoes_show_situacoes_ids' => 1,
            'militares_tempos_averbados_permissoes_create_situacoes_ids' => 1,
            'militares_tempos_averbados_permissoes_edit_situacoes_ids' => 1,
            'militares_tempos_averbados_permissoes_destroy_situacoes_ids' => 1]);
            
        Grupo::create(['id' => 2, 'name' => 'Administrador DGF 1']);
        Grupo::create(['id' => 3, 'name' => 'Administrador DGF 2']);
        Grupo::create(['id' => 4, 'name' => 'Administrador DGF 3']);
        Grupo::create(['id' => 5, 'name' => 'Administrador DGF 4']);
        Grupo::create(['id' => 6, 'name' => 'Administrador Pagadoria']);
    }
}
