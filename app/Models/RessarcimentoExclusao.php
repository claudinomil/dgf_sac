<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RessarcimentoExclusao extends Model
{
    use HasFactory;

    protected $table = 'ressarcimento_exclusoes';

    protected $fillable = [
        'referencia',
        'ano',
        'mes',
        'parte',
        'militares',
        'data',
        'hora'
    ];
}
