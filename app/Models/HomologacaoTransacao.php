<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomologacaoTransacao extends Model
{
    use HasFactory;

    protected $table = 'homologacao_transacoes';

    protected $fillable = [
        'submodulo_id',
        'user_id',
        'operacao',
        'data',
        'hora'
    ];

    protected $casts = [
        'data' => 'date'
    ];
}
