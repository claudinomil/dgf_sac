<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('militares_ajudas_custos', function (Blueprint $table) {
            $table->id();
            $table->integer('excluido')->default(0);
            $table->foreignId('militar_id')->constrained('militares');
            $table->foreignId('ajuda_custo_tipo_id')->constrained('ajuda_custo_tipos', indexName: 'fk_mil_aju_cus_tipo');
            $table->string('boletim', 20)->nullable();
            $table->string('pagamento', 15)->nullable();
            $table->string('pagamento_ordenar', 200)->nullable();
            $table->text('observacao')->nullable();
            $table->string('referencia_processo_sei', 200)->nullable();

            // AjudaCustoTipo 1 : POR MOVIMENTAÇÃO & AjudaCustoTipo 2 : POR CURSO
            $table->string('requerimento_numero', 10)->nullable();
            $table->date('requerimento_data')->nullable();

            // AjudaCustoTipo 1 : POR MOVIMENTAÇÃO
            $table->string('unidade_origem')->nullable();
            $table->string('unidade_destino')->nullable();

            // AjudaCustoTipo 2 : POR CURSO
            $table->string('curso')->nullable();
            $table->string('boletim_movimentacao_curso')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('militares_ajudas_custos');
    }
};
