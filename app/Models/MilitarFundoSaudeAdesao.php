<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MilitarFundoSaudeAdesao extends Model
{
    use HasFactory;

    protected $table = 'militares_fundos_saude_adesao';

    protected $fillable = [
        'militar_id',
        'adesao',
        'documento_sei',
        'processo_sei',
        'formulario_adesao_nome',
        'ciente'
    ];
}
