<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\RessarcimentoReferencia;
use App\Models\RessarcimentoMilitar;

class RessarcimentoReferenciaDeleteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $id = $this->route('id'); // id da rota

            $registro = RessarcimentoReferencia::where('id', $id)->first();

            if (!$registro) {
                return;
            }

            $novaReferencia = $this->referencia;

            if ($novaReferencia != $registro->referencia) {
                $qtd = RessarcimentoMilitar::where('referencia', $registro->referencia)->count();

                if ($qtd > 0) {
                    $validator->errors()->add('referencia', 'Não é possível excluir a referência. Existem militares vinculados.');
                }
            }
        });
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
