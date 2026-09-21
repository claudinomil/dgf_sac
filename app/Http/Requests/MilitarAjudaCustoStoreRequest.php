<?php

namespace App\Http\Requests;

use App\Services\TokenService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Traits\ValidacoesCustomizadas;

class MilitarAjudaCustoStoreRequest extends FormRequest
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
            'ajuda_custo_tipo_id' => ['required'],
            'curso' => ['nullable', 'prohibited_if:ajuda_custo_tipo_id,1', 'required_if:ajuda_custo_tipo_id,2'],
            // 'data_inicio' => ['nullable', 'date_format:d/m/Y'],
            // 'data_termino' => ['required', 'date_format:d/m/Y'],
            'boletim' => ['required'],
            'pagamento' => ['required']
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

            // Validar Boletim caso esteja com conteúdo
            $this->validarBoletim($validator, 'boletim', 'Boletim');

            // Validar Pagamento caso esteja com conteúdo
            $this->validarPagamento($validator, 'pagamento', 'Pagamento');
        });
    }

    public function messages()
    {
        return [
            'militar_id.required' => 'O Militar é requerido.',
            'militar_id_token.required' => 'O Token do Militar é requerido.',
            'militarSituacaoId.required' => 'A Situação do Militar é requerido.',
            'militarSituacaoId_token.required' => 'O Token da Situação do Militar é requerido.',
            'ajuda_custo_tipo_id.required' => 'A Ajuda Custo Tipo é requerido.',
            'curso.required_if' => 'O Curso é requerido para Ajuda Custo Tipo.',
            'curso.prohibited_if' => 'O Curso não é requerido para Ajuda Custo Tipo.',
            // 'data_inicio.date_format' => 'A Data Início inválida.',
            // 'data_termino.required' => 'A Data Término é requerida.',
            // 'data_termino.date_format' => 'A Data Término inválida.',
            'boletim.required' => 'O Boletim é requerido.',
            'pagamento.required' => 'O Pagamento é requerido.'
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
