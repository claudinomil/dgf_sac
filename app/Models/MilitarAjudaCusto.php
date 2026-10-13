<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MilitarAjudaCusto extends Model
{
    use HasFactory;

    protected $table = 'militares_ajudas_custos';

    protected $fillable = [
        'excluido',
        'militar_id',
        'ajuda_custo_tipo_id',
        'boletim',
        'pagamento',
        'pagamento_ordenar',
        'observacao',
        'referencia_processo_sei',
        'requerimento_numero',
        'requerimento_data',
        'unidade_origem',
        'unidade_destino',
        'curso',
        'boletim_movimentacao'
    ];

    protected $casts = [
        'requerimento_data' => 'date'
    ];

    public function setRequerimentoDataAttribute($value)
    {
        if (blank($value)) {
            $this->attributes['requerimento_data'] = null;
            return;
        }

        $this->attributes['requerimento_data'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }
}
