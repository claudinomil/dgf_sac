<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_acesso_sistema_saude_controle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('api_acesso_sistema_saude_usuario_id')->constrained('api_acesso_sistema_saude_usuarios', indexName: 'fk_aassc_aassu_id');
            $table->string('origem')->nullable();
            $table->foreignId('militar_id')->nullable()->constrained('militares');
            $table->date('data')->nullable();
            $table->time('hora')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_acesso_sistema_saude_controle');
    }
};
