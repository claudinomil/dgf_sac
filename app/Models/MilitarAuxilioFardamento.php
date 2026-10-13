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
        'documento',
        'unidade',
        'mes_pagamento',
        'ano_pagamento',
        'mes_recebimento',
        'ano_recebimento',
        'controle_sistema_cadastramento_fardamentos',
        'requerimento_numero',
        'requerimento_data',
        'requerimento_unidade',
        'data_requerimento',
        'data_ultima_promocao'
    ];

    protected $casts = [
        'requerimento_data' => 'date',
        'data_requerimento' => 'date',
        'data_ultima_promocao' => 'date'
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

    public function setDataUltimaPromocaoAttribute($value)
    {
        if (blank($value)) {
            $this->attributes['data_ultima_promocao'] = null;
            return;
        }

        $this->attributes['data_ultima_promocao'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }
}
