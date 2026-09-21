<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sincronizacoes', function (Blueprint $table) {
            $table->id();
            $table->string('operacao', 10);
            $table->string('banco', 10);
            $table->string('tabela_nome', 50);
            $table->integer('registro_id');
            $table->integer('sucesso');
            $table->text('erro')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sincronizacoes');
    }
};
