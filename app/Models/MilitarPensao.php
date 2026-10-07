<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MilitarPensao extends Model
{
    use HasFactory;

    protected $table = 'militares_pensoes';

    protected $fillable = [
        'excluido',
        'militar_id',
        'pensao_tipo_id',
        'nome_militar',
        'beneficiario',
        'desconto',
        'representante_legal',
        'logradouro',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'telefone',
        'celular',
        'banco',
        'agencia',
        'conta_corrente',
        'cpf',
        'documento',
        'data_documento',
        'numero_processo',
        'vara_familia',
        'implantacao',
        'nascimento',
        'cancelar_em',
        'alterar_em',
        'nascimento_beneficiario',
        'cpf_beneficiario',
        'observacao',
        'pasta_dip',
        'referencia_processo_sei'
    ];

    protected $casts = [
        'data_documento',
        'implantacao',
        'nascimento',
        'nascimento_beneficiario'
    ];

    public function setDataDocumentoAttribute(?string $value)
    {
        if (blank($value)) {
            $this->attributes['data_documento'] = null;
            return;
        }

        $this->attributes['data_documento'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }

    public function setImplantacaoAttribute(?string $value)
    {
        if (blank($value)) {
            $this->attributes['implantacao'] = null;
            return;
        }

        $this->attributes['implantacao'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }

    public function setNascimentoAttribute(?string $value)
    {
        if (blank($value)) {
            $this->attributes['nascimento'] = null;
            return;
        }

        $this->attributes['nascimento'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }

    public function setNascimentoBeneficiarioAttribute(?string $value)
    {
        if (blank($value)) {
            $this->attributes['nascimento_beneficiario'] = null;
            return;
        }

        $this->attributes['nascimento_beneficiario'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }
}
