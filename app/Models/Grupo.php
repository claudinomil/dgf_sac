<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupos';

    protected $fillable = [
        'name',
        'militares_permissoes_list_situacoes_ids',
        'militares_permissoes_show_situacoes_ids',
        'militares_permissoes_create_situacoes_ids',
        'militares_permissoes_edit_situacoes_ids',
        'militares_permissoes_destroy_situacoes_ids',
        'militares_ajudas_custos_permissoes_list_situacoes_ids',
        'militares_ajudas_custos_permissoes_show_situacoes_ids',
        'militares_ajudas_custos_permissoes_create_situacoes_ids',
        'militares_ajudas_custos_permissoes_edit_situacoes_ids',
        'militares_ajudas_custos_permissoes_destroy_situacoes_ids',
        'militares_auxilios_fardamentos_permissoes_list_situacoes_ids',
        'militares_auxilios_fardamentos_permissoes_show_situacoes_ids',
        'militares_auxilios_fardamentos_permissoes_create_situacoes_ids',
        'militares_auxilios_fardamentos_permissoes_edit_situacoes_ids',
        'militares_auxilios_fardamentos_permissoes_destroy_situacoes_ids',
        'militares_cursos_permissoes_list_situacoes_ids',
        'militares_cursos_permissoes_show_situacoes_ids',
        'militares_cursos_permissoes_create_situacoes_ids',
        'militares_cursos_permissoes_edit_situacoes_ids',
        'militares_cursos_permissoes_destroy_situacoes_ids',
        'militares_contatos_permissoes_list_situacoes_ids',
        'militares_contatos_permissoes_show_situacoes_ids',
        'militares_contatos_permissoes_create_situacoes_ids',
        'militares_contatos_permissoes_edit_situacoes_ids',
        'militares_contatos_permissoes_destroy_situacoes_ids',
        'militares_dependentes_permissoes_list_situacoes_ids',
        'militares_dependentes_permissoes_show_situacoes_ids',
        'militares_dependentes_permissoes_create_situacoes_ids',
        'militares_dependentes_permissoes_edit_situacoes_ids',
        'militares_dependentes_permissoes_destroy_situacoes_ids',
        'militares_fundos_saude_permissoes_list_situacoes_ids',
        'militares_fundos_saude_permissoes_show_situacoes_ids',
        'militares_fundos_saude_permissoes_create_situacoes_ids',
        'militares_fundos_saude_permissoes_edit_situacoes_ids',
        'militares_fundos_saude_permissoes_destroy_situacoes_ids',
        'militares_ferias_permissoes_list_situacoes_ids',
        'militares_ferias_permissoes_show_situacoes_ids',
        'militares_ferias_permissoes_create_situacoes_ids',
        'militares_ferias_permissoes_edit_situacoes_ids',
        'militares_ferias_permissoes_destroy_situacoes_ids',
        'militares_pensoes_permissoes_list_situacoes_ids',
        'militares_pensoes_permissoes_show_situacoes_ids',
        'militares_pensoes_permissoes_create_situacoes_ids',
        'militares_pensoes_permissoes_edit_situacoes_ids',
        'militares_pensoes_permissoes_destroy_situacoes_ids',
        'militares_tempo_averbado_permissoes_list_situacoes_ids',
        'militares_tempo_averbado_permissoes_show_situacoes_ids',
        'militares_tempo_averbado_permissoes_create_situacoes_ids',
        'militares_tempo_averbado_permissoes_edit_situacoes_ids',
        'militares_tempo_averbado_permissoes_destroy_situacoes_ids'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
