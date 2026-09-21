<?php

namespace App\Http\Requests;

use App\Services\TokenService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Traits\ValidacoesCustomizadas;

class MilitarDependenteUpdateRequest extends FormRequest
{
    use ValidacoesCustomizadas;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'militar_id' => ['required'],
            'militar_id_token' => ['required'],
            'militarSituacaoId' => ['required'],
            'militarSituacaoId_token' => ['required'],
            'parentesco_id' => ['required'],
            'name' => ['required'],
            'cpf' => ['required'],
            'data_nascimento' => ['nullable', 'date_format:d/m/Y'],
            'data_casamento' => ['nullable', 'date_format:d/m/Y'],
            'sexo_biologico_id' => ['required'],
            'vinculo_permanente' => ['required'],
            'data_requerimento' => ['nullable', 'date_format:d/m/Y'],
            'data_processo' => ['nullable', 'date_format:d/m/Y'],
            'decisao_judicial' => ['required'],
            'decisao_judicial_a_contar_de' => ['nullable', 'date_format:d/m/Y'],
            'imposto_renda' => ['required'],
            'fundo_saude' => ['required']
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

            // Validar Boletins caso estejam com conteúdo''''''''''''''''''''''''''''''''''''''''''''''''''
            $this->validarBoletim($validator, 'boletim', 'Boletim');
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        });
    }

    public function messages()
    {
        return [
            'militar_id.required' => 'O Militar é requerido.',
            'militar_id_token.required' => 'O Token do Militar é requerido.',
            'militarSituacaoId.required' => 'A Situação do Militar é requerido.',
            'militarSituacaoId_token.required' => 'O Token da Situação do Militar é requerido.',
            'parentesco_id.required' => 'O Parentesco é requerido.',
            'name.required' => 'O Nome é requerido.',
            'cpf.required' => 'O CPF é requerido.',
            'data_nascimento.date_format' => 'A Data Nascimento é inválida.',
            'data_casamento.date_format' => 'A Data Casamento é inválida.',
            'sexo_biologico_id.required' => 'O Sexo Biológico é requerido.',
            'vinculo_permanente.required' => 'O Vínculo Permanente é requerido.',
            'data_requerimento.date_format' => 'A Data Requerimento é inválida.',
            'data_processo.date_format' => 'A Data Processo é inválida.',
            'decisao_judicial.required' => 'A Decisão Judicial é requerida.',
            'decisao_judicial_a_contar_de.date_format' => 'A Decisão Judicial A Contar De é inválida.',
            'imposto_renda.required' => 'O Imposto Renda é requerido.',
            'fundo_saude.required' => 'O Fundo Saúde é requerido.'
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
