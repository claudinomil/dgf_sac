<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quadros', function (Blueprint $table) {
            $table->id();
            $table->integer('excluido')->default(0);
            $table->string('codigo_quadro');
            $table->string('name');
            $table->string('especialidade');
            $table->string('quadro_especialidade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quadros');
    }
};
