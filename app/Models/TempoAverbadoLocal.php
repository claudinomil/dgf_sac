<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempoAverbadoLocal extends Model
{
    use HasFactory;

    protected $table = 'tempos_averbados_locais';

    protected $fillable = [
        'excluido',
        'tipo',
        'name'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
