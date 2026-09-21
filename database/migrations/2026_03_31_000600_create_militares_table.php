<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('militares', function (Blueprint $table) {
            $table->id();
            $table->integer('excluido')->default(0);
            $table->string('rg', 11)->nullable();
            $table->string('nome')->nullable();
            $table->string('fotografia')->nullable()->default('assets/images/militares/fotografia-0.png');
            $table->foreignId('situacao_id')->nullable()->constrained('situacoes');
            $table->string('boletim_situacao', 20)->nullable();
            $table->foreignId('graduacao_id')->nullable()->constrained('graduacoes');
            $table->string('boletim_graduacao', 20)->nullable();
            $table->foreignId('unidade_id')->nullable()->constrained('unidades');
            $table->string('boletim_movimentacao', 20)->nullable();
            $table->foreignId('quadro_id')->nullable()->constrained('quadros');
            $table->string('boletim_quadro', 20)->nullable();
            $table->foreignId('sexo_biologico_id')->nullable()->constrained('sexos_biologicos');
            $table->foreignId('genero_id')->nullable()->constrained('generos');
            $table->date('data_ingresso')->nullable();
            $table->string('boletim_ingresso', 20)->nullable();
            $table->date('data_segunda_praca')->nullable();
            $table->string('boletim_segunda_praca', 20)->nullable();
            $table->string('nome_guerra', 200)->nullable();
            $table->foreignId('prestando_servico_id')->nullable()->constrained('unidades');
            $table->string('boletim_prestando_servico', 20)->nullable();
            $table->foreignId('funcao_id')->nullable()->constrained('funcoes');
            $table->string('boletim_funcao', 20)->nullable();
            $table->foreignId('banco_id')->nullable()->constrained('bancos');
            $table->string('agencia', 4)->nullable();
            $table->string('conta_corrente', 15)->nullable();
            $table->string('cpf', 11)->nullable();
            $table->string('pasep', 12)->nullable();
            $table->string('pai')->nullable();
            $table->foreignId('estado_civil_id')->nullable()->constrained('estados_civis');
            $table->string('mae')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('aniversario', 4)->nullable();
            $table->foreignId('comportamento_id')->nullable()->constrained('comportamentos');
            $table->string('boletim_comportamento', 20)->nullable();
            $table->string('altura', 50)->nullable();
            $table->foreignId('tipo_sanguineo_id')->nullable()->constrained('tipos_sanguineos');
            $table->foreignId('fator_rh_id')->nullable()->constrained('fatores_rh');
            $table->string('titulo_eleitoral', 50)->nullable();
            $table->string('titulo_eleitoral_zona', 5)->nullable();
            $table->string('titulo_eleitoral_secao', 5)->nullable();
            $table->string('titulo_eleitoral_uf', 2)->nullable();
            $table->string('certificado_reservista', 50)->nullable();
            $table->string('certificado_reservista_serie', 50)->nullable();
            $table->string('certificado_reservista_categoria', 50)->nullable();
            $table->string('identidade_funcional', 15)->nullable();
            $table->string('vinculo', 2)->nullable();
            $table->tinyInteger('temporario')->nullable()->default(0);
            $table->foreignId('nacionalidade_id')->nullable()->constrained('nacionalidades');
            $table->foreignId('naturalidade_id')->nullable()->constrained('naturalidades');
            $table->foreignId('escolaridade_id')->nullable()->constrained('escolaridades');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('militares');
    }
};
