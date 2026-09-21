<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class PasswordUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'profille_current_password' => ['required'],
            'profille_password_confirmation' => ['required'],
            'profille_password' => ['required', 'min:8', 'confirmed']
        ];
    }

    public function messages()
    {
        return [
            'profille_current_password.required' => 'A Senha atual é requerido.',
            'profille_password.required' => 'A Nova senha é requerido.',
            'profille_password.min' => 'A Nova senha precisa ter no mínimo 8 dígitos.',
            'profille_password.confirmed' => 'A Nova senha precisa ser igual a Confirmar senha.',
            'profille_password_confirmation.required' => 'A Confirmar senha é requerido.'
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
