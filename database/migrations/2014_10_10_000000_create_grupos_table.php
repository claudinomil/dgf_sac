<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // Campos para guardar permissões a Militares por situações''''''''''''''''''''''''''''''''''''''''''''
            $table->string('militares_permissoes_list_situacoes_ids', 100)->default(0);
            $table->string('militares_permissoes_show_situacoes_ids', 100)->default(0);
            $table->string('militares_permissoes_create_situacoes_ids', 100)->default(0);
            $table->string('militares_permissoes_edit_situacoes_ids', 100)->default(0);
            $table->string('militares_permissoes_destroy_situacoes_ids', 100)->default(0);

            $table->string('militares_ajudas_custos_permissoes_list_situacoes_ids', 100)->default(0);
            $table->string('militares_ajudas_custos_permissoes_show_situacoes_ids', 100)->default(0);
            $table->string('militares_ajudas_custos_permissoes_create_situacoes_ids', 100)->default(0);
            $table->string('militares_ajudas_custos_permissoes_edit_situacoes_ids', 100)->default(0);
            $table->string('militares_ajudas_custos_permissoes_destroy_situacoes_ids', 100)->default(0);

            $table->string('militares_auxilios_fardamentos_permissoes_list_situacoes_ids', 100)->default(0);
            $table->string('militares_auxilios_fardamentos_permissoes_show_situacoes_ids', 100)->default(0);
            $table->string('militares_auxilios_fardamentos_permissoes_create_situacoes_ids', 100)->default(0);
            $table->string('militares_auxilios_fardamentos_permissoes_edit_situacoes_ids', 100)->default(0);
            $table->string('militares_auxilios_fardamentos_permissoes_destroy_situacoes_ids', 100)->default(0);

            $table->string('militares_cursos_permissoes_list_situacoes_ids', 100)->default(0);
            $table->string('militares_cursos_permissoes_show_situacoes_ids', 100)->default(0);
            $table->string('militares_cursos_permissoes_create_situacoes_ids', 100)->default(0);
            $table->string('militares_cursos_permissoes_edit_situacoes_ids', 100)->default(0);
            $table->string('militares_cursos_permissoes_destroy_situacoes_ids', 100)->default(0);

            $table->string('militares_contatos_permissoes_list_situacoes_ids', 100)->default(0);
            $table->string('militares_contatos_permissoes_show_situacoes_ids', 100)->default(0);
            $table->string('militares_contatos_permissoes_create_situacoes_ids', 100)->default(0);
            $table->string('militares_contatos_permissoes_edit_situacoes_ids', 100)->default(0);
            $table->string('militares_contatos_permissoes_destroy_situacoes_ids', 100)->default(0);

            $table->string('militares_dependentes_permissoes_list_situacoes_ids', 100)->default(0);
            $table->string('militares_dependentes_permissoes_show_situacoes_ids', 100)->default(0);
            $table->string('militares_dependentes_permissoes_create_situacoes_ids', 100)->default(0);
            $table->string('militares_dependentes_permissoes_edit_situacoes_ids', 100)->default(0);
            $table->string('militares_dependentes_permissoes_destroy_situacoes_ids', 100)->default(0);

            $table->string('militares_fundos_saude_permissoes_list_situacoes_ids', 100)->default(0);
            $table->string('militares_fundos_saude_permissoes_show_situacoes_ids', 100)->default(0);
            $table->string('militares_fundos_saude_permissoes_create_situacoes_ids', 100)->default(0);
            $table->string('militares_fundos_saude_permissoes_edit_situacoes_ids', 100)->default(0);
            $table->string('militares_fundos_saude_permissoes_destroy_situacoes_ids', 100)->default(0);

            $table->string('militares_ferias_permissoes_list_situacoes_ids', 100)->default(0);
            $table->string('militares_ferias_permissoes_show_situacoes_ids', 100)->default(0);
            $table->string('militares_ferias_permissoes_create_situacoes_ids', 100)->default(0);
            $table->string('militares_ferias_permissoes_edit_situacoes_ids', 100)->default(0);
            $table->string('militares_ferias_permissoes_destroy_situacoes_ids', 100)->default(0);

            $table->string('militares_pensoes_permissoes_list_situacoes_ids', 100)->default(0);
            $table->string('militares_pensoes_permissoes_show_situacoes_ids', 100)->default(0);
            $table->string('militares_pensoes_permissoes_create_situacoes_ids', 100)->default(0);
            $table->string('militares_pensoes_permissoes_edit_situacoes_ids', 100)->default(0);
            $table->string('militares_pensoes_permissoes_destroy_situacoes_ids', 100)->default(0);

            $table->string('militares_tempo_averbado_permissoes_list_situacoes_ids', 100)->default(0);
            $table->string('militares_tempo_averbado_permissoes_show_situacoes_ids', 100)->default(0);
            $table->string('militares_tempo_averbado_permissoes_create_situacoes_ids', 100)->default(0);
            $table->string('militares_tempo_averbado_permissoes_edit_situacoes_ids', 100)->default(0);
            $table->string('militares_tempo_averbado_permissoes_destroy_situacoes_ids', 100)->default(0);
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grupos');
    }
}
