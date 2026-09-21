<?php

namespace App\Http\Requests;

use App\Services\TokenService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use App\Http\Requests\Traits\ValidacoesCustomizadas;

class MilitarUpdateRequest extends FormRequest
{
    use ValidacoesCustomizadas;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'militarSituacaoId' => ['required'],
            'militarSituacaoId_token' => ['required'],
            'rg' => ['required', Rule::unique('militares', 'rg')->ignore($this->route('id'))],
            'identidade_funcional' => ['required'],
            'vinculo' => ['required'],
            'nome' => ['required'],
            'nome_guerra' => ['required'],
            'situacao_id' => ['required'],
            'quadro_id' => ['required'],
            'graduacao_id' => ['required'],
            'data_ingresso' => ['required', 'date_format:d/m/Y'],
            'unidade_id' => ['required'],
            'prestando_servico_id' => ['required'],
            'data_segunda_praca' => ['nullable', 'date_format:d/m/Y'],
            'data_nascimento' => ['required', 'date_format:d/m/Y'],
            'cpf' => ['required', 'cpf', Rule::unique('militares', 'cpf')->ignore($this->route('id'))],
            'temporario' => ['required']
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
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
            $this->validarBoletim($validator, 'boletim_situacao', 'Boletim Situação');
            $this->validarBoletim($validator, 'boletim_graduacao', 'Boletim Graduação');
            $this->validarBoletim($validator, 'boletim_movimentacao', 'Boletim Movimentação');
            $this->validarBoletim($validator, 'boletim_quadro', 'Boletim Quadro');
            $this->validarBoletim($validator, 'boletim_ingresso', 'Boletim Ingresso');
            $this->validarBoletim($validator, 'boletim_segunda_praca', 'Boletim Segunda Praça');
            $this->validarBoletim($validator, 'boletim_prestando_servico', 'Boletim Prestando Serviço');
            $this->validarBoletim($validator, 'boletim_funcao', 'Boletim Função');
            $this->validarBoletim($validator, 'boletim_comportamento', 'Boletim Comportamento');
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Validar RG''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $this->validarRg($validator, 'rg', 'RG');
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        });
    }

    public function messages()
    {
        return [
            'militarSituacaoId.required' => 'A Situação do Militar é requerido.',
            'militarSituacaoId_token.required' => 'O Token da Situação do Militar é requerido.',
            'rg.required' => 'O RG é requerido.',
            'rg.unique' => 'O RG já está cadastrado.',
            'identidade_funcional.required' => 'A Identidade Funcional é requerido.',
            'vinculo.required' => 'O Vínculo é requerido.',
            'nome.required' => 'O Nome é requerido.',
            'nome_guerra.required' => 'O Nome Guerra é requerido.',
            'situacao_id.required' => 'A Situação é requerido.',
            'quadro_id.required' => 'O Quadro é requerido.',
            'graduacao_id.required' => 'A Graduação é requerido.',
            'data_ingresso.required' => 'A Data Ingresso é requerido.',
            'data_ingresso.date_format' => 'A Data Ingresso é inválida.',
            'unidade_id.required' => 'A Unidade é requerido.',
            'prestando_servico_id.required' => 'O Prestando Serviço é requerido.',
            'data_segunda_praca.date_format' => 'A Data Segunda Praça é inválida.',
            'data_nascimento.required' => 'A Data Nascimento é requerido.',
            'data_nascimento.date_format' => 'A Data Nascimento é inválida.',
            'cpf.required' => 'O CPF é requerido.',
            'cpf.cpf' => 'O CPF é inválido.',
            'cpf.unique' => 'O CPF já está cadastrado.',
            'temporario.required' => 'O Temporário é requerido.'
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
