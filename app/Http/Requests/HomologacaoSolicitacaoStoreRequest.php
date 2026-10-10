<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Traits\ValidacoesCustomizadas;

class HomologacaoSolicitacaoStoreRequest extends FormRequest
{
    use ValidacoesCustomizadas;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'solicitacao' => ['required'],
            'solicitacao_imagem_file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120']
        ];
    }

    public function messages()
    {
        return [
            'solicitacao.required' => 'A Solicitação é requerida.'
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
