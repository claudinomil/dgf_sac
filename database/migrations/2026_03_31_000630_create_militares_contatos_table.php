<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('militares_contatos', function (Blueprint $table) {
            $table->id();
            $table->integer('excluido')->default(0);
            $table->foreignId('militar_id')->unique()->constrained('militares');
            $table->string('cep', 8)->nullable();
            $table->string('numero', 50)->nullable();
            $table->string('complemento', 100)->nullable();
            $table->string('logradouro')->nullable();
            $table->string('bairro')->nullable();
            $table->string('localidade')->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('celular_1', 11)->nullable();
            $table->string('celular_2', 11)->nullable();
            $table->string('telefone_1', 10)->nullable();
            $table->string('telefone_2', 10)->nullable();
            $table->string('email', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('militares_contatos');
    }
};
