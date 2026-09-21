<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('militares_fundos_saude', function (Blueprint $table) {
            $table->id();
            $table->integer('excluido')->default(0);
            $table->foreignId('militar_id')->unique()->constrained('militares');
            $table->integer('cancelar_desconto');
            $table->integer('acesso_sistema_saude');
            $table->integer('tipo_acesso'); // 0(NEGADO) 1(INTEGRAL) 2(AMBULATORIAL)
            $table->text('tipo_acesso_motivo')->nullable();
            $table->string('acesso_sistema_saude_documento')->nullable();
            $table->date('data_documento')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('militares_fundos_saude');
    }
};
