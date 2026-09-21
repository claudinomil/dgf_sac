<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Graduacao extends Model
{
    use HasFactory;

    protected $table = 'graduacoes';

    protected $fillable = [
        'excluido',
        'name',
        'codigo_graduacao',
        'abreviacao'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
