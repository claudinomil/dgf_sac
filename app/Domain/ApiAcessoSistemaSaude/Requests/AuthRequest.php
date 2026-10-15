<?php

namespace App\Domain\ApiAcessoSistemaSaude\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $erros = collect($validator->errors()->toArray())
            ->map(fn (array $mensagens) => $mensagens[0])
            ->all();

        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'error' => $erros,
            ], 422)
        );
    }
}
