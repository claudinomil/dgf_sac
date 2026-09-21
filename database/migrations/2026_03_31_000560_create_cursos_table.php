<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->integer('excluido')->default(0);
            $table->string('name');
            $table->integer('tipo')->comment('1(Especial), 2(Especialização) ou 3(Regular)');
            $table->string('abreviacao', 30);
            $table->integer('oficial_praca')->comment('1(Oficial), 2(Praça) ou 3(Oficial/Praça)');
            $table->integer('percentual');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
