<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dashboards_tvs_controles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unidade_id')->nullable()->constrained('unidades');
            $table->string('ano')->default('0000');
            $table->integer('indicador_1')->default(0);
            $table->integer('indicador_2')->default(0);
            $table->integer('indicador_3')->default(0);
            $table->integer('indicador_4')->default(0);
            $table->integer('indicador_5')->default(0);
            $table->integer('indicador_6')->default(0);
            $table->integer('indicador_7')->default(0);
            $table->integer('indicador_8')->default(0);
            $table->integer('indicador_9')->default(0);
            $table->integer('indicador_10')->default(0);
            $table->integer('indicador_11')->default(0);
            $table->integer('indicador_12')->default(0);
            $table->integer('grafico_1')->default(0);
            $table->integer('grafico_2')->default(0);
            $table->integer('grafico_3')->default(0);
            $table->integer('grafico_4')->default(0);
            $table->integer('grafico_5')->default(0);
            $table->integer('grafico_6')->default(0);
            $table->integer('grafico_7')->default(0);
            $table->integer('grafico_8')->default(0);
            $table->integer('grafico_9')->default(0);
            $table->integer('grafico_10')->default(0);
            $table->integer('grafico_11')->default(0);
            $table->integer('grafico_12')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dashboards_tvs_controles');
    }
};
