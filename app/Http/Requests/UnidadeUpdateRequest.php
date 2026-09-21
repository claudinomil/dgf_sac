<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UnidadeUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('unidades')->ignore($this->id)],
            'sigla' => ['required', Rule::unique('unidades')->ignore($this->id)],
            'codigo_unidade' => ['required'],
            'situacao' => ['required'],
            'tipo' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O Nome é requerido.',
            'name.unique' => 'O Nome já existe.',
            'sigla.required' => 'A Sigla é requerido.',
            'sigla.unique' => 'A Sigla já existe.',
            'codigo_unidade.required' => 'O Código Unidade é requerido.',
            'situacao.required' => 'A Situação é requerido.',
            'tipo.required' => 'O Tipo é requerido.',
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
