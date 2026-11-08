<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dashboards_tvs_indicadores_graficos', function (Blueprint $table) {
            $table->id();
            $table->integer('tipo');
            $table->string('identificador')->unique();
            $table->string('titulo');
            $table->integer('colunas');
            $table->integer('ordem');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dashboards_tvs_indicadores_graficos');
    }
};
