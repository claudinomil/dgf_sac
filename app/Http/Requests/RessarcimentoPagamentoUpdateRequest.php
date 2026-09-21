<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class RessarcimentoPagamentoUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'identidade_funcional' => ['required'],
            'vinculo' => ['required'],
            'rg' => ['required'],
            'codigo_cargo' => ['required'],
            'nome_cargo' => ['required'],
            'posto_graduacao' => ['required'],
            'nome' => ['required'],
            'situacao_pagamento' => ['required'],
            'data_ingresso' => ['required'],
            'data_nascimento' => ['required'],
            'genero' => ['required'],
            'codigo_ua' => ['required'],
            'ua' => ['required'],
            'cpf' => ['required'],
            'pasep' => ['required'],
            'banco_id' => ['required'],
            'agencia' => ['required'],
            'conta_corrente' => ['required'],
            'numero_dependentes' => ['required'],
            'ir_dependente' => ['required'],
            'cotista' => ['required'],
            'bruto' => ['required'],
            'desconto' => ['required'],
            'liquido' => ['required'],
            'soldo' => ['required'],
            'hospital10' => ['required'],
            'rioprevidencia22' => ['required'],
            'etapa_ferias' => ['required'],
            'etapa_destacado' => ['required'],
            'ajuda_fardamento' => ['required'],
            'habilitacao_profissional' => ['required'],
            'gret' => ['required'],
            'auxilio_moradia' => ['required'],
            'gpe' => ['required'],
            'gee_capacitacao' => ['required'],
            'decreto14407' => ['required'],
            'ferias' => ['required'],
            'raio_x' => ['required'],
            'trienio' => ['required'],
            'auxilio_invalidez' => ['required'],
            'tempo_certo' => ['required'],
            'fundo_saude' => ['required'],
            'abono_permanencia' => ['required'],
            'deducao_ir' => ['required'],
            'ir_valor' => ['required'],
            'auxilio_transporte' => ['required'],
            'gram' => ['required'],
            'auxilio_fardamento' => ['required'],
            'cidade' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'identidade_funcional.required' => 'A Identidade Funcional é requerido.',
            'vinculo.required' => 'O Vínculo é requerido.',
            'rg.required' => 'O RG é requerido.',
            'codigo_cargo.required' => 'O Código Cargo é requerido.',
            'nome_cargo.required' => 'O Nome Cargo é requerido.',
            'posto_graduacao.required' => 'O Posto/Graduação é requerido.',
            'nome.required' => 'O Nome é requerido.',
            'situacao_pagamento.required' => 'A Situação Pagamento é requerido.',
            'data_ingresso.required' => 'A Data Ingresso é requerido.',
            'data_nascimento.required' => 'A Data Nascimento é requerido.',
            'genero.required' => 'O Gênero é requerido.',
            'codigo_ua.required' => 'O Código UA é requerido.',
            'ua.required' => 'A UA é requerido.',
            'cpf.required' => 'O CPF é requerido.',
            'pasep.required' => 'O PASEP é requerido.',
            'banco_id.required' => 'O Banco é requerido.',
            'agencia.required' => 'A Agência é requerido.',
            'conta_corrente.required' => 'A Conta Corrente é requerido.',
            'numero_dependentes.required' => 'O Número Dependentes é requerido.',
            'ir_dependente.required' => 'O IR Dependente é requerido.',
            'cotista.required' => 'A Cotista é requerido.',
            'bruto.required' => 'O Bruto é requerido.',
            'desconto.required' => 'O Desconto é requerido.',
            'liquido.required' => 'O Líquido é requerido.',
            'soldo.required' => 'O Soldo é requerido.',
            'hospital10.required' => 'O Hospital 10 é requerido.',
            'rioprevidencia22.required' => 'O Rioprevidência 22 é requerido.',
            'etapa_ferias.required' => 'A Etapa Férias é requerido.',
            'etapa_destacado.required' => 'A Etapa Destacado é requerido.',
            'ajuda_fardamento.required' => 'A Ajuda Fardamento é requerido.',
            'habilitacao_profissional.required' => 'A Habilitação Profissional é requerido.',
            'gret.required' => 'A GRET é requerido.',
            'auxilio_moradia.required' => 'O Auxílio Moradia é requerido.',
            'gpe.required' => 'O GPE é requerido.',
            'gee_capacitacao.required' => 'O GEE Capacitação é requerido.',
            'decreto14407.required' => 'O Decreto 14407 é requerido.',
            'ferias.required' => 'A Férias é requerido.',
            'raio_x.required' => 'O Raio X é requerido.',
            'trienio.required' => 'O Triênio é requerido.',
            'auxilio_invalidez.required' => 'O Auxilio Invalidez é requerido.',
            'tempo_certo.required' => 'O Tempo Certo é requerido.',
            'fundo_saude.required' => 'O Fundo Saúde é requerido.',
            'abono_permanencia.required' => 'O Abono Permanência é requerido.',
            'deducao_ir.required' => 'A Dedução IR é requerido.',
            'ir_valor.required' => 'O IR Valor é requerido.',
            'auxilio_transporte.required' => 'O Auxílio Transporte é requerido.',
            'gram.required' => 'A GRAM é requerido.',
            'auxilio_fardamento.required' => 'O Auxílio Fardamento é requerido.',
            'cidade.required' => 'A Cidade é requerido.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException(
            $validator,
            response()->json([
                'error_validation' => $validator->errors()
            ], 200)
        );
    }
}
