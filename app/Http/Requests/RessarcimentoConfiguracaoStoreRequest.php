<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class RessarcimentoConfiguracaoStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'referencia' => ['required'],
            'data_vencimento' => ['required', 'date_format:d/m/Y']
        ];
    }

    public function messages()
    {
        return [
            'referencia.required' => 'A Referência é requerida.',
            'data_vencimento.required' => 'O Vencimento é requerido.',
            'data_vencimento.date_format' => 'O Vencimento não é uma data válida.'
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
