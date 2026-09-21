<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('militares_dependentes', function (Blueprint $table) {
            $table->id();
            $table->integer('excluido')->default(0);
            $table->foreignId('militar_id')->constrained('militares');
            $table->foreignId('parentesco_id')->constrained('parentescos');
            $table->string('name');
            $table->string('cpf');
            $table->string('decisao_judicial');
            $table->string('decisao_judicial_documento')->nullable();
            $table->date('decisao_judicial_a_contar_de')->nullable();
            $table->date('data_casamento')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->date('data_inicio_dependencia')->nullable();
            $table->date('data_termino_dependencia')->nullable();
            $table->string('numero_processo_validacao')->nullable();
            $table->date('data_inicio_contagem')->nullable();
            $table->date('data_fim_contagem')->nullable();
            $table->foreignId('sexo_biologico_id')->constrained('sexos_biologicos');
            $table->integer('vinculo_permanente')->default(0);
            $table->string('boletim')->nullable();
            $table->string('unidade')->nullable();
            $table->string('numero_requerimento')->nullable();
            $table->date('data_requerimento')->nullable();
            $table->string('numero_processo')->nullable();
            $table->date('data_processo')->nullable();
            $table->text('observacao')->nullable();
            $table->integer('imposto_renda')->default(0);
            $table->integer('fundo_saude')->default(0);
            $table->integer('acesso_sistema_saude_dependente')->default(1); // 0(nao)  1(sim)
            $table->integer('tipo_acesso')->default(1); // 1(INTEGRAL)  2(AMBULATORIAL)
            $table->string('referencia_processo_sei')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('militares_dependentes');
    }
};
