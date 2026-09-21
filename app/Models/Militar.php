<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Militar extends Model
{
    use HasFactory;

    protected $table = 'militares';

    protected $fillable = [
        'excluido',
        'fotografia',
        'situacao_id',
        'boletim_situacao',
        'graduacao_id',
        'boletim_graduacao',
        'unidade_id',
        'boletim_movimentacao',
        'quadro_id',
        'boletim_quadro',
        'rg',
        'nome',
        'sexo_biologico_id',
        'genero_id',
        'data_ingresso',
        'boletim_ingresso',
        'data_segunda_praca',
        'boletim_segunda_praca',
        'nome_guerra',
        'prestando_servico_id',
        'boletim_prestando_servico',
        'funcao_id',
        'boletim_funcao',
        'banco_id',
        'agencia',
        'conta_corrente',
        'cpf',
        'pasep',
        'pai',
        'estado_civil_id',
        'mae',
        'data_nascimento',
        'aniversario',
        'comportamento_id',
        'boletim_comportamento',
        'altura',
        'tipo_sanguineo_id',
        'fator_rh_id',
        'titulo_eleitoral',
        'titulo_eleitoral_zona',
        'titulo_eleitoral_secao',
        'titulo_eleitoral_uf',
        'certificado_reservista',
        'certificado_reservista_serie',
        'certificado_reservista_categoria',
        'identidade_funcional',
        'vinculo',
        'temporario',
        'nacionalidade_id',
        'naturalidade_id',
        'escolaridade_id'
    ];

    protected $casts = [
        'data_ingresso' => 'date',
        'data_segunda_praca' => 'date',
        'data_nascimento' => 'date'
    ];

    public function setNomeAttribute($value) {$this->attributes['nome'] = mb_strtoupper($value);}

    public function setNomeGuerraAttribute($value) {$this->attributes['nome_guerra'] = mb_strtoupper($value);}

    public function setDataIngressoAttribute($value)
    {
        if (blank($value)) {
            $this->attributes['data_ingresso'] = null;
            return;
        }

        $this->attributes['data_ingresso'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }

    public function setDataSegundaPracaAttribute($value)
    {
        if (blank($value)) {
            $this->attributes['data_segunda_praca'] = null;
            return;
        }

        $this->attributes['data_segunda_praca'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }

    public function setDataNascimentoAttribute($value)
    {
        if (blank($value)) {
            $this->attributes['data_nascimento'] = null;
            return;
        }

        $this->attributes['data_nascimento'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }
}
