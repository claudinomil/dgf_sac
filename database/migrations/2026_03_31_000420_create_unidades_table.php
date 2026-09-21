<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();
            $table->integer('excluido')->default(0);
            $table->string('codigo_unidade')->index('codigo_unidade');
            $table->string('situacao')->index('situacao')->comment('1(Ativa - recebe efetivo) 2(Inativa - extinta-desativada - nao recebe efetivo)');
            $table->integer('tipo')->default(0)->index('tipo')->comment('1 (SEDEC) 2 (CBMERJ) 3 (ORGAO EXTERNO)  4(SAUDE)');
            $table->string('name');
            $table->string('sigla', 50)->nullable();
            $table->string('ordem_estrutura')->nullable();
            $table->string('ua', 8)->nullable();
            $table->string('cba', 50)->nullable();
            $table->integer('agregado')->nullable()->default(0)->comment('o militar que estiver lotado em uma unidade agregada, ele fica como agregado, nao conta vaga para promocao     0 (nao agregado)   1 (agregado)');
            $table->string('controle', 20)->nullable();
            $table->string('esfera', 100)->nullable();
            $table->string('poder', 100)->nullable();
            $table->string('vocativo', 100)->nullable();
            $table->integer('funcao_id')->nullable();
            $table->string('responsavel', 200)->nullable();
            $table->string('cep', 8)->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('complemento', 30)->nullable();
            $table->string('telefone', 15)->nullable();
            $table->string('fax', 15)->nullable();
            $table->string('cnpj', 50)->nullable();
            $table->integer('subordinacao_unidade_id')->nullable();
            $table->integer('subordinacao_ordem')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('unidades');
    }
};
