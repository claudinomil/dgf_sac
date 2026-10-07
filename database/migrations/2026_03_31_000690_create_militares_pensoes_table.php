<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('militares_pensoes', function (Blueprint $table) {
            $table->id();
            $table->integer('excluido')->default(0);
            $table->foreignId('militar_id')->constrained('militares');
            $table->foreignId('pensao_tipo_id')->nullable()->constrained('pensao_tipos');
            $table->string('nome_militar')->nullable();
            $table->string('beneficiario')->nullable();
            $table->string('desconto');
            $table->string('representante_legal')->nullable();
            $table->string('logradouro')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->string('cep')->nullable();
            $table->string('telefone')->nullable();
            $table->string('celular')->nullable();
            $table->string('banco')->nullable();
            $table->string('agencia')->nullable();
            $table->string('conta_corrente')->nullable();
            $table->string('cpf')->nullable();
            $table->string('documento')->nullable();
            $table->date('data_documento')->nullable();
            $table->string('numero_processo')->nullable();
            $table->string('vara_familia')->nullable();
            $table->date('implantacao')->nullable();
            $table->date('nascimento')->nullable();
            $table->string('cancelar_em')->nullable();
            $table->string('alterar_em')->nullable();
            $table->date('nascimento_beneficiario')->nullable();
            $table->string('cpf_beneficiario')->nullable();
            $table->text('observacao')->nullable();
            $table->integer('pasta_dip')->nullable();
            $table->string('referencia_processo_sei')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('militares_pensoes');
    }
};
