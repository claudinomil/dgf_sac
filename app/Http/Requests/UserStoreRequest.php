<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class UserStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Verificando se user_tipo_id=2 (USUÁRIO CIVIL)
        if ($this->user_tipo_id == 2) {
            // Busca o maior valor numérico do campo user
            $maxUser = DB::table('users')
                ->selectRaw('MAX(CAST(user AS UNSIGNED)) as max_user')
                ->value('max_user');

            // Incrementa +1 (ou começa em 1 se não houver registros)
            $nextUser = $maxUser ? $maxUser + 1 : 1;

            // Se valor encontrado for menor que 7700000 então significa que é primeiro usuário civil
            if ($nextUser < 7700000) {$nextUser = 7700000;}

            // Sobrescreve o campo user na request
            $this->merge(['user' => (string) $nextUser]);
        }

        // Verificando se email é vazio e colocando null
        $this->merge(['email' => isset($this->email) && trim($this->email) !== '' ? $this->email : null]);
    }

    public function rules()
    {
        return [
            'user' => ['required', 'unique:users'],
            'name' => ['required'],
            'email' => ['nullable', 'unique:users', 'email'],
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
            'user_situacao_id.required' => 'A Situação é requerida.'
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
