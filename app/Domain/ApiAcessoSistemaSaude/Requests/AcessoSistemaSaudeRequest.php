<?php

namespace App\Domain\ApiAcessoSistemaSaude\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AcessoSistemaSaudeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $cpf = $this->input('cpf');

        if (is_string($cpf)) {
            $this->merge([
                'cpf' => preg_replace('/\D/', '', $cpf),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'cpf' => [
                'required',
                'string',
                'regex:/^\d{11}$/',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.string' => 'O CPF deve ser informado como texto.',
            'cpf.regex' => 'O CPF deve conter 11 dígitos.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $erros = $validator->errors();

        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'error' => $erros->toArray()
                    ? collect($erros->toArray())
                        ->map(fn (array $mensagens) => $mensagens[0])
                        ->all()
                    : [],
            ], 422)
        );
    }
}
