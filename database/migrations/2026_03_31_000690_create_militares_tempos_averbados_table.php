<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('militares_tempos_averbados', function (Blueprint $table) {
            $table->id();
            $table->integer('excluido')->default(0);
            $table->foreignId('militar_id')->constrained('militares');
            $table->foreignId('tempo_averbado_local_id')->constrained('tempos_averbados_locais');
            $table->date('data_ingresso_local')->nullable();
            $table->date('data_termino_local')->nullable();
            $table->string('tempo_apurado_local')->nullable();
            $table->string('boletim')->nullable();
            $table->string('proderj_servico_publico', 20)->nullable();
            $table->string('proderj_servico_publico_rj', 20)->nullable();
            $table->string('proderj_servico_cargo', 20)->nullable();
            $table->string('proderj_controle')->nullable();
            $table->string('lancado_proderj')->nullable();
            $table->text('observacao')->nullable();
            $table->string('referencia_processo_sei')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('militares_tempos_averbados');
    }
};
