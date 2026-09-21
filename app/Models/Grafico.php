<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grafico extends Model
{
    use HasFactory;

    protected $table = 'graficos';

    protected $fillable = [
        'grafico_grupo_id',
        'name',
        'tipo',
        'ordem'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
