<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('user')->unique();
            $table->string('email')->nullable()->unique();
            $table->foreignId('grupo_id')->nullable()->constrained('grupos');
            $table->foreignId('user_situacao_id')->nullable()->constrained('user_situacoes');
            $table->text('avatar');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('user_tipo_id')->constrained('user_tipos');
            $table->integer('layout_menu')->default(1);

            // Militar de referência para o Usuário
            $table->foreignId('militar_id')->nullable()->constrained('militares');

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
