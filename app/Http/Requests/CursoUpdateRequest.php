<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CursoUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('cursos')->ignore($this->id)],
            'tipo' => ['required'],
            'abreviacao' => ['required', Rule::unique('cursos')->ignore($this->id)],
            'oficial_praca' => ['required'],
            'percentual' => ['required']
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'O Nome é requerido.',
            'name.unique' => 'O Nome já existe.',
            'tipo.required' => 'O Tipo é requerido.',
            'abreviacao.required' => 'A Abreviação é requerido.',
            'abreviacao.unique' => 'A Abreviação já existe.',
            'oficial_praca.required' => 'O Oficial/Praça é requerido.',
            'percentual.required' => 'O Percentual é requerido.',
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
