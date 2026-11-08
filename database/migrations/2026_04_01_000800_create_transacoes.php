<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transacoes', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('operacao_id')->constrained('operacoes');
            $table->foreignId('submodulo_id')->constrained('submodulos');
            $table->string('tabela_principal')->nullable();
            $table->integer('tabela_principal_registro_id')->nullable();
            $table->longText('dados');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transacoes');
    }
};
