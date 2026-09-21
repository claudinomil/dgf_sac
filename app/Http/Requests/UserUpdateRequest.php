<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Verificando se email é vazio e colocando null
        $this->merge(['email' => isset($this->email) && trim($this->email) !== '' ? $this->email : null]);
    }

    public function rules()
    {
        return [
            'user' => [
                'required',
                Rule::unique('users')->ignore($this->id)
            ],
            'name' => ['required'],
            'email' => [
                'nullable',
                Rule::unique('users')->ignore($this->id),
                'email'
            ],
            'user_tipo_id' => ['required'],
            'grupo_id' => ['required'],
            'user_situacao_id' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'user.required' => 'O Usuário é requerido.',
            'user.unique' => 'O Usuário já existe.',
            'name.required' => 'O Nome é requerido.',
            'email.unique' => 'O E-mail já existe.',
            'email.email' => 'O E-mail deve ser um endereço válido.',
            'user_tipo_id.required' => 'O Usuário Tipo é requerido.',
            'grupo_id.required' => 'O Grupo é requerido.',
            'user_situacao_id.required' => 'A Situação é requerido.'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = User::find($this->id);

            if ($user && $this->user_tipo_id != $user->user_tipo_id) {
                $validator->errors()->add('user_tipo_id', 'O Usuário Tipo não pode ser alterado.');
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
