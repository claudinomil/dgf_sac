<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('militares_auxilios_fardamentos', function (Blueprint $table) {
            $table->id();
            $table->integer('excluido')->default(0);
            $table->foreignId('militar_id')->constrained('militares');
            $table->foreignId('auxilio_fardamento_tipo_id')->constrained('auxilio_fardamento_tipos', indexName: 'fk_mil_aux_fard_tipo');
            $table->string('boletim', 20)->nullable();
            $table->string('pagamento', 15)->nullable();
            $table->string('pagamento_ordenar', 200)->nullable();
            $table->text('observacao')->nullable();
            $table->string('referencia_processo_sei', 200)->nullable();
            $table->string('requerimento_numero', 30)->nullable();
            $table->date('requerimento_data')->nullable();
            $table->string('requerimento_unidade')->nullable();
            $table->string('documento')->nullable();
            $table->string('unidade')->nullable();
            $table->string('mes_pagamento', 2)->nullable();
            $table->string('ano_pagamento', 4)->nullable();
            $table->string('mes_recebimento', 2)->nullable();
            $table->string('ano_recebimento', 4)->nullable();
            $table->date('data_requerimento')->nullable();
            $table->integer('controle_sistema_cadastramento_fardamentos')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('militares_auxilios_fardamentos');
    }
};
