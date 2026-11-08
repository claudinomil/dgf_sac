<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardTvIndicadorGrafico extends Model
{
    use HasFactory;

    protected $table = 'dashboards_tvs_indicadores_graficos';

    protected $fillable = [
        'tipo',
        'nome',
        'titulo',
        'colunas',
        'ordem'
    ];
}
