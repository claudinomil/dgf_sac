<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class RessarcimentoOrgaoUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            //'cnpj' => ['nullable', Rule::unique('ressarcimento_orgaos')->ignore($this->id), 'cnpj'],
            'cnpj' => ['nullable', 'cnpj'],
            'esfera_id' => ['required', 'integer', 'numeric'],
            'poder_id' => ['required', 'integer', 'numeric'],
            'tratamento_id' => ['required', 'integer', 'numeric'],
            'vocativo_id' => ['required', 'integer', 'numeric'],
            'ressarcimento_funcao_id' => ['required', 'integer', 'numeric'],
            'cep' => ['required', 'digits:8'],
            'numero' => ['required'],
            'complemento' => ['nullable', 'min:1'],
            'telefone_1' => ['nullable', 'numeric', 'digits:10'],
            'telefone_2' => ['nullable', 'numeric', 'digits:10'],
            'contato_nome' => ['nullable'],
            'contato_telefone' => ['nullable', 'numeric', 'digits:10'],
            'contato_celular' => ['nullable', 'numeric', 'digits:11'],
            'contato_email' => ['nullable', 'email']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O Nome é requerido.',
            //'cnpj.unique' => 'O CNPJ já existe.',
            'cnpj.cnpj' => 'O CNPJ não é um número válido.',
            'esfera_id.required' => 'Esfera é requerido.',
            'esfera_id.integer' => 'A Esfera deve ser um ítem da lista.',
            'poder_id.required' => 'Poder é requerido.',
            'poder_id.integer' => 'O Poder deve ser um ítem da lista.',
            'tratamento_id.required' => 'Tratamento é requerido.',
            'tratamento_id.integer' => 'O Tratamento deve ser um ítem da lista.',
            'vocativo_id.required' => 'Vocativo é requerido.',
            'vocativo_id.integer' => 'O Vocativo deve ser um ítem da lista.',
            'ressarcimento_funcao_id.required' => 'Função é requerido.',
            'ressarcimento_funcao_id.integer' => 'A Função deve ser um ítem da lista.',
            'cep.required' => 'CEP é requerido.',
            'cep.digits' => 'O CEP deve ter 8 dígitos.',
            'numero.required' => 'Número é requerido.',
            'complemento.min' => 'O Complemento deve ter pelo menos 1 caractere.',
            'telefone_1.numeric' => 'O Telefone 1 deve ser um número válido.',
            'telefone_1.digits' => 'O Telefone 1 deve ser um número válido.',
            'telefone_2.numeric' => 'O Telefone 2 deve ser um número válido.',
            'telefone_2.digits' => 'O Telefone 2 deve ser um número válido.',
            'contato_telefone.numeric' => 'O Contato Telefone deve ser um número válido.',
            'contato_telefone.digits' => 'O Contato Telefone deve ser um número válido.',
            'contato_celular.numeric' => 'O Contato Celular deve ser um número válido.',
            'contato_celular.digits' => 'O Contato Celular deve ser um número válido.',
            'contato_email.email' => 'O Contato E-mail deve ser um endereço válido.'
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
