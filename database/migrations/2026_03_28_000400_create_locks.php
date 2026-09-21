<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('locks', function (Blueprint $table) {
            $table->id();
            $table->string('tabela', 40);
            $table->unsignedBigInteger('registro_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // UNIQUE COMPOSTO
            $table->unique(['tabela', 'registro_id'], 'unique_lock');

            // INDEX
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('locks');
    }
};
