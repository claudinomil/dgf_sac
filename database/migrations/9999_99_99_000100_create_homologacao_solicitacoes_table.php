<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('homologacao_solicitacoes', function (Blueprint $table) {
            $table->id();

            // Solicitação
            $table->foreignId('submodulo_id')->nullable()->constrained('submodulos');
            $table->foreignId('user_id')->constrained('users');
            $table->text('solicitacao');
            $table->enum('solicitacao_tipo', ['Correção', 'Ajuste', 'Melhoria', 'Nova Funcionalidade', 'Dúvida', 'Sugestão']);
            $table->enum('solicitacao_prioridade', ['Baixa', 'Normal', 'Alta', 'Urgente'])->default('Normal');
            $table->date('data_solicitacao');
            $table->time('hora_solicitacao');

            // Resposta
            $table->text('resposta')->nullable();
            $table->enum('solicitacao_status', ['Em Análise', 'Em Desenvolvimento', 'Aguardando Validação', 'Concluído', 'Não Realizado'])->nullable()->default('Em Análise');
            $table->date('data_resposta')->nullable();
            $table->time('hora_resposta')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homologacao_solicitacoes');
    }
};
