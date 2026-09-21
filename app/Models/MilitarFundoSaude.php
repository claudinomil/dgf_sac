<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MilitarFundoSaude extends Model
{
    use HasFactory;

    protected $table = 'militares_fundos_saude';

    protected $fillable = [
        'excluido',
        'militar_id',
        'cancelar_desconto',
        'acesso_sistema_saude',
        'acesso_sistema_saude_documento',
        'data_documento',
        'tipo_acesso',
        'tipo_acesso_motivo'
    ];

    protected $casts = [
        'data_documento' => 'date'
    ];

    public function setDataDocumentoAttribute($value)
    {
        if (blank($value)) {
            $this->attributes['data_documento'] = null;
            return;
        }

        $this->attributes['data_documento'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }
}
