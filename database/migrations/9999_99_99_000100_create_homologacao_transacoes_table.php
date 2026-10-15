<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('homologacao_transacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submodulo_id')->constrained('submodulos');
            $table->foreignId('user_id')->constrained('users');
            $table->string('operacao');
            $table->date('data');
            $table->time('hora');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homologacao_transacoes');
    }
};
