<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class MilitarFotografiaUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'informacoes_militar_fotografia' => ['required', 'image']
        ];
    }

    public function messages()
    {
        return [
            'informacoes_militar_fotografia.required' => 'A Fotografia é requerida.',
            'informacoes_militar_fotografia.image' => 'A Fotografia é inválida.'
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
