<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    use HasFactory;

    protected $table = 'transacoes';

    protected $fillable = [
        'date',
        'time',
        'user_id',
        'operacao_id',
        'submodulo_id',
        'dados'
    ];

    protected $casts = [
        'dados' => 'array'
    ];

    public function setDadosAttribute($value) {$this->attributes['dados'] = json_encode($value, JSON_UNESCAPED_UNICODE);}
}
