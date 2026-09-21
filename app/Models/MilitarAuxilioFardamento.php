<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MilitarAuxilioFardamento extends Model
{
    use HasFactory;

    protected $table = 'militares_auxilios_fardamentos';

    protected $fillable = [
        'excluido',
        'militar_id',
        'auxilio_fardamento_tipo_id',
        'boletim',
        'pagamento',
        'pagamento_ordenar',
        'observacao',
        'referencia_processo_sei',
        'requerimento_numero',
        'requerimento_data',
        'requerimento_unidade',
        'documento',
        'unidade',
        'mes_pagamento',
        'ano_pagamento',
        'mes_recebimento',
        'ano_recebimento',
        'data_requerimento',
        'controle_sistema_cadastramento_fardamentos'
    ];

    protected $casts = [
        'requerimento_data' => 'date',
        'data_requerimento' => 'date'
    ];

    public function setRequerimentoDataAttribute($value)
    {
        if (blank($value)) {
            $this->attributes['requerimento_data'] = null;
            return;
        }

        $this->attributes['requerimento_data'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }

    public function setDataRequerimentoAttribute($value)
    {
        if (blank($value)) {
            $this->attributes['data_requerimento'] = null;
            return;
        }

        $this->attributes['data_requerimento'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }
}
