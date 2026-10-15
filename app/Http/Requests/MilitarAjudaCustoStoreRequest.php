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
            'boletim' => ['required'],
            'pagamento' => ['required'],
            'requerimento_numero' => ['required'],
            'requerimento_data' => ['required', 'date_format:d/m/Y'],

            // Por movimentação
            'unidade_origem' => ['required_if:ajuda_custo_tipo_id,1'],
            'unidade_destino' => ['required_if:ajuda_custo_tipo_id,1'],

            // Por curso
            'curso' => ['required_if:ajuda_custo_tipo_id,2'],
            'boletim_movimentacao_curso' => ['required_if:ajuda_custo_tipo_id,2']
        ];
    }

    protected function prepareForValidation(): void
    {
        $tipo = (int) $this->input('ajuda_custo_tipo_id');

        if ($tipo === 1) {
            // Por movimentação
            $this->merge([
                'curso' => null,
                'boletim_movimentacao_curso' => null,
            ]);
        }

        if ($tipo === 2) {
            // Por curso
            $this->merge([
                'unidade_origem' => null,
                'unidade_destino' => null,
            ]);
        }
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

            // Validar Boletim Movimentação Curso caso esteja com conteúdo
            if ((int) $this->input('ajuda_custo_tipo_id') === 2) {
                $this->validarBoletim($validator, 'boletim_movimentacao_curso', 'Boletim Movimentação Curso');
            }

            // Validar Requerimento Número caso esteja com conteúdo
            $this->validarRequerimento($validator, 'requerimento_numero', 'Requerimento Número');

            // Validar Referência Processo SEI caso esteja com conteúdo
            $this->validarProcessoSei($validator, 'referencia_processo_sei', 'Referência Processo SEI');
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
            'boletim.required' => 'O Boletim é requerido.',
            'pagamento.required' => 'O Pagamento é requerido.',
            'requerimento_numero.required' => 'O Requerimento Número é requerido.',
            'requerimento_data.required' => 'O Requerimento Data é requerido.',
            'requerimento_data.date_format' => 'O Requerimento Data inválida.',
            'unidade_origem.required_if' => 'A Unidade de Origem é requerida.',
            'unidade_destino.required_if' => 'A Unidade de Destino é requerida.',
            'curso.required_if' => 'O Curso é requerido.',
            'boletim_movimentacao_curso.required_if' => 'O Boletim Movimentação Curso é requerido.'
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
