<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RessarcimentoRecebimento extends Model
{
    use HasFactory;

    protected $table = 'ressarcimento_recebimentos';

    protected $fillable = [
        'ressarcimento_cobranca_dado_id',
        'data_recebimento',
        'valor_recebido',
        'saldo_restante',
        'guia_recolhimento',
        'documento'
    ];

    protected $dates = [
        'data_recebimento'
    ];

    protected function setDataRecebimentoAttribute($value) {
        $value = getDataFormatada(4, $value);
        $this->attributes['data_recebimento'] = $value;
    }

    protected function setValorRecebidoAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['valor_recebido'] = $value;
    }

    protected function setSaldoRestanteAttribute($value)
    {
        if ($value == '') {$value = 0.00;} else {$value = getValorFormatado(1, $value);}
        $this->attributes['saldo_restante'] = $value;
    }
}
