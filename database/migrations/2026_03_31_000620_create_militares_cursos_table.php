<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('militares_cursos', function (Blueprint $table) {
            $table->id();
            $table->integer('excluido')->default(0);
            $table->foreignId('militar_id')->constrained('militares');
            $table->foreignId('curso_id')->constrained('cursos');
            $table->date('data_inicio')->nullable();
            $table->date('data_termino')->nullable();
            $table->string('boletim')->nullable();
            $table->string('conceito', 5)->nullable();
            $table->string('classificacao', 5)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('militares_cursos');
    }
};
