<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class GraduacaoUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('graduacoes')->ignore($this->id)],
            'abreviacao' => ['required', Rule::unique('graduacoes')->ignore($this->id)]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O Nome é requerido.',
            'name.unique' => 'O Nome já existe.',
            'abreviacao.required' => 'A Abreviação é requerido.',
            'abreviacao.unique' => 'A Abreviação já existe.'
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
