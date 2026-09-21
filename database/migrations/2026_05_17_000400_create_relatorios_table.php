<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('relatorios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('relatorio_grupo_id')->constrained('relatorio_grupos');
            $table->string('name');
            $table->integer('ordem')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('relatorios');
    }
};
