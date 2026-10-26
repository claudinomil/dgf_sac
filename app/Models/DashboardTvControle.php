<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardTvControle extends Model
{
    use HasFactory;

    protected $table = 'dashboards_tvs_controles';

    protected $fillable = [
        'unidade_id',
        'ano',
        'indicador_1',
        'indicador_2',
        'indicador_3',
        'indicador_4',
        'indicador_5',
        'indicador_6',
        'indicador_7',
        'indicador_8',
        'indicador_9',
        'indicador_10',
        'indicador_11',
        'indicador_12',
        'grafico_1',
        'grafico_2',
        'grafico_3',
        'grafico_4',
        'grafico_5',
        'grafico_6',
        'grafico_7',
        'grafico_8',
        'grafico_9',
        'grafico_10',
        'grafico_11',
        'grafico_12'
    ];
}