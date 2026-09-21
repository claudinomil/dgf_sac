<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use App\Models\RessarcimentoReferencia;
use App\Models\RessarcimentoMilitar;

class RessarcimentoReferenciaUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'referencia' => [
                'required',
                Rule::unique('ressarcimento_referencias')->ignore($this->id)
            ],
            'ano' => ['required', 'date_format:Y'],
            'mes' => ['required', 'date_format:m']
        ];
    }

    public function messages()
    {
        return [
            'referencia.required' => 'A Referência é requerida.',
            'referencia.unique' => 'A Referência já existe.',
            'ano.required' => 'O Ano é requerido.',
            'ano.date_format' => 'O Ano não é válido.',
            'mes.required' => 'O Mês é requerido.',
            'mes.date_format' => 'O Mês não é válido.'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $id = $this->route('id'); // id da rota

            $registro = RessarcimentoReferencia::where('id', $id)->first();

            if (!$registro) {return;}

            $novaReferencia = $this->referencia;

            if ($novaReferencia != $registro->referencia) {
                $qtd = RessarcimentoMilitar::where('referencia', $registro->referencia)->count();

                if ($qtd > 0) {
                    $validator->errors()->add('referencia', 'Não é possível alterar a referência. Existem militares vinculados.');
                }
            }
        });
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
