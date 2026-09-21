<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('graficos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grafico_grupo_id')->constrained('grafico_grupos');
            $table->string('name');
            $table->integer('tipo'); // 1(Gráfico de Pizza)  2(Gráfico de Bar)
            $table->integer('ordem')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('graficos');
    }
};
