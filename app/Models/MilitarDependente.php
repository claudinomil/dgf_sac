<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MilitarDependente extends Model
{
    use HasFactory;

    protected $table = 'militares_dependentes';

    protected $fillable = [
        'excluido',
        'militar_id',
        'parentesco_id',
        'name',
        'cpf',
        'decisao_judicial',
        'decisao_judicial_documento',
        'decisao_judicial_a_contar_de',
        'data_casamento',
        'data_nascimento',
        'data_inicio_dependencia',
        'data_termino_dependencia',
        'numero_processo_validacao',
        'data_inicio_contagem',
        'data_fim_contagem',
        'sexo_biologico_id',
        'vinculo_permanente',
        'boletim',
        'unidade',
        'numero_requerimento',
        'data_requerimento',
        'numero_processo',
        'data_processo',
        'observacao',
        'imposto_renda',
        'fundo_saude',
        'acesso_sistema_saude_dependente',
        'tipo_acesso',
        'referencia_processo_sei'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'data_casamento' => 'date',
        'data_inicio_dependencia' => 'date',
        'data_termino_dependencia' => 'date',
        'data_inicio_contagem' => 'date',
        'data_fim_contagem' => 'date',
        'data_requerimento' => 'date',
        'data_processo' => 'date',
        'decisao_judicial_a_contar_de' => 'date'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}

    public function setUnidadeAttribute($value) {$this->attributes['unidade'] = mb_strtoupper($value);}

    public function setDataNascimentoAttribute(?string $value)
    {
        if (blank($value)) {
            $this->attributes['data_nascimento'] = null;
            return;
        }

        $this->attributes['data_nascimento'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }

    public function setDataCasamentoAttribute(?string $value)
    {
        if (blank($value)) {
            $this->attributes['data_casamento'] = null;
            return;
        }

        $this->attributes['data_casamento'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }

    public function setDataInicioDependenciaAttribute(?string $value)
    {
        if (blank($value)) {
            $this->attributes['data_inicio_dependencia'] = null;
            return;
        }

        $this->attributes['data_inicio_dependencia'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }

    public function setDataTerminoDependenciaAttribute(?string $value)
    {
        if (blank($value)) {
            $this->attributes['data_termino_dependencia'] = null;
            return;
        }

        $this->attributes['data_termino_dependencia'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }

    public function setDataInicioContagemAttribute(?string $value)
    {
        if (blank($value)) {
            $this->attributes['data_inicio_contagem'] = null;
            return;
        }

        $this->attributes['data_inicio_contagem'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }

    public function setDataFimContagemAttribute(?string $value)
    {
        if (blank($value)) {
            $this->attributes['data_fim_contagem'] = null;
            return;
        }

        $this->attributes['data_fim_contagem'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }

    public function setDataRequerimentoAttribute(?string $value)
    {
        if (blank($value)) {
            $this->attributes['data_requerimento'] = null;
            return;
        }

        $this->attributes['data_requerimento'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }

    public function setDataProcessoAttribute(?string $value)
    {
        if (blank($value)) {
            $this->attributes['data_processo'] = null;
            return;
        }

        $this->attributes['data_processo'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }

    public function setDecisaoJudicialAContarDeAttribute(?string $value)
    {
        if (blank($value)) {
            $this->attributes['decisao_judicial_a_contar_de'] = null;
            return;
        }

        $this->attributes['decisao_judicial_a_contar_de'] = Carbon::createFromFormat('d/m/Y', trim($value))->format('Y-m-d');
    }
}
