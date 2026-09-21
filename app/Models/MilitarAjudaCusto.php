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
        'curso',
        'boletim',
        'pagamento',
        'pagamento_ordenar',
        'observacao',
        'referencia_processo_sei'
    ];
}
