<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('militares_fundos_saude_adesao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('militar_id')->constrained('militares');
            $table->integer('adesao')->default(0);
            $table->string('documento_sei')->nullable();
            $table->string('processo_sei')->nullable();
            $table->string('formulario_adesao_nome')->nullable();
            $table->integer('ciente')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('militares_fundos_saude_adesao');
    }
};
