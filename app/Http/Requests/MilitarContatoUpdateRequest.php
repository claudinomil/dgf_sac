<?php

namespace App\Http\Requests;

use App\Services\TokenService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Traits\ValidacoesCustomizadas;

class MilitarContatoUpdateRequest extends FormRequest
{
    use ValidacoesCustomizadas;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'militar_id' => ['required', Rule::unique('militares_contatos', 'militar_id')->ignore($this->id)],
            'militar_id_token' => ['required'],
            'militarSituacaoId' => ['required'],
            'militarSituacaoId_token' => ['required']
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validação do Token - militar_id'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $token = blank($this->militar_id_token) ? 'xxxyyyzzz' : $this->militar_id_token;

            $dadosToken = TokenService::validar($token);

            if ($dadosToken === false) {
                $validator->errors()->add('militar_id', 'Token (Militar Id) inválido ou expirado.');
                return;
            }

            if ($dadosToken['scope'] !== 'militar_id') {
                $validator->errors()->add('militar_id', 'Escopo do token (Militar Id) inválido.');
                return;
            }

            if ((string) $dadosToken['id'] !== (string) $this->militar_id) {
                $validator->errors()->add('militar_id', 'O token não corresponde ao Militar informado.');
                return;
            }
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Validação do Token - militarSituacaoId''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $token = blank($this->militarSituacaoId_token) ? 'xxxyyyzzz' : $this->militarSituacaoId_token;

            $dadosToken = TokenService::validar($token);

            if ($dadosToken === false) {
                $validator->errors()->add('militarSituacaoId', 'Token (Militar Situação Id) inválido ou expirado.');
                return;
            }

            if ($dadosToken['scope'] !== 'militarSituacaoId') {
                $validator->errors()->add('militarSituacaoId', 'Escopo do token (Militar Situação Id) inválido.');
                return;
            }

            if ((string) $dadosToken['id'] !== (string) $this->militarSituacaoId) {
                $validator->errors()->add('militarSituacaoId', 'O token não corresponde a Situação do Militar informado.');
                return;
            }
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // CEP'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $this->validarCep($validator, 'cep', 'CEP');

            if (filled($this->cep)) {

                if (blank($this->numero)) {
                    $validator->errors()->add('numero', 'Número é obrigatório quando o CEP for informado.');
                }

                if (blank($this->logradouro)) {
                    $validator->errors()->add('logradouro', 'Logradouro é obrigatório quando o CEP for informado.');
                }

                if (blank($this->bairro)) {
                    $validator->errors()->add('bairro', 'Bairro é obrigatório quando o CEP for informado.');
                }

                if (blank($this->localidade)) {
                    $validator->errors()->add('localidade', 'Localidade é obrigatória quando o CEP for informado.');
                }

                if (blank($this->uf)) {
                    $validator->errors()->add('uf', 'UF é obrigatória quando o CEP for informado.');
                }
            }
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Telefones'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $this->validarTelefone($validator, 'telefone_1', 'Telefone 1');
            $this->validarTelefone($validator, 'telefone_2', 'Telefone 2');
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Celulares'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $this->validarCelular($validator, 'celular_1', 'Celular 1');
            $this->validarCelular($validator, 'celular_2', 'Celular 2');
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Email'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            if (filled($this->email) && !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $validator->errors()->add('email', 'E-mail inválido.');
            }
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        });
    }

    public function messages()
    {
        return [
            'militar_id.required' => 'O Militar é requerido.',
            'militar_id.unique' => 'O Militar já tem registro.',
            'militar_id_token.required' => 'O Token do Militar é requerido.',
            'militarSituacaoId.required' => 'A Situação do Militar é requerido.',
            'militarSituacaoId_token.required' => 'O Token da Situação do Militar é requerido.'
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
