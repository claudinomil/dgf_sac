<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('militares_ferias', function (Blueprint $table) {
            $table->id();
            $table->integer('excluido')->default(0);
            $table->foreignId('militar_id')->constrained('militares');
            $table->string('mes', 2);
            $table->string('ano', 4);
            $table->string('referencia', 4);
            $table->string('documento_origem')->nullable();
            $table->string('boletim', 25)->nullable();
            $table->integer('ciente')->default(0);
            $table->string('documento')->nullable();
            $table->string('unidade')->nullable();
            $table->integer('excecao_id')->nullable();
            $table->string('controle_sistema_cadastramento_ferias')->nullable();
            $table->text('observacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('militares_ferias');
    }
};
