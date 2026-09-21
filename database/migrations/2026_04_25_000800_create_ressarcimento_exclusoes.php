<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ressarcimento_exclusoes', function (Blueprint $table) {
            $table->id();
            $table->string('referencia');
            $table->string('ano');
            $table->string('mes');
            $table->string('parte');
            $table->integer('militares');
            $table->date('data');
            $table->time('hora');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ressarcimento_exclusoes');
    }
};
