<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('militares_fundos_saude_controle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('militar_id')->constrained('militares');
            $table->date('data')->nullable();
            $table->string('documento');
            $table->string('acao');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('militares_fundos_saude_controle');
    }
};
