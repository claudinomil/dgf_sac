<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_situacoes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('bg_badge');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_situacoes');
    }
};
