<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MilitarFundoSaudeControle extends Model
{
    use HasFactory;

    protected $table = 'militares_fundos_saude_controle';

    protected $fillable = [
        'militar_id',
        'data',
        'documento',
        'acao'
    ];

    protected $casts = [
        'data' => 'date'
    ];

    public function setDataAttribute($value)
    {
        if (blank($value)) {
            $this->attributes['data'] = null;
            return;
        }

        $this->attributes['data'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }
}
