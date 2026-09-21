<?php

namespace App\Http\Requests\Traits;

trait ValidacoesCustomizadas
{
    /**
     * Telefone
     * Formato: 10 dígitos
     */
    protected function validarTelefone($validator, string $campo, string $descricao): void
    {
        $valor = preg_replace('/\D/', '', $this->input($campo));

        if (blank($valor)) {
            return;
        }

        if (!preg_match('/^\d{10}$/', $valor)) {
            $validator->errors()->add($campo, "{$descricao} deve possuir 10 dígitos.");
        }
    }

    /**
     * Celular
     * Formato: 11 dígitos
     */
    protected function validarCelular($validator, string $campo, string $descricao): void
    {
        $valor = preg_replace('/\D/', '', $this->input($campo));

        if (blank($valor)) {
            return;
        }

        if (!preg_match('/^\d{11}$/', $valor)) {
            $validator->errors()->add($campo, "{$descricao} deve possuir 11 dígitos.");
        }
    }

    /**
     * CNH
     * Formato: 11 dígitos
     */
    protected function validarCnh($validator, string $campo, string $descricao): void
    {
        $valor = preg_replace('/\D/', '', $this->input($campo));

        if (blank($valor)) {
            return;
        }

        if (!preg_match('/^\d{11}$/', $valor)) {
            $validator->errors()->add($campo, "{$descricao} deve possuir 11 dígitos.");
        }
    }

    /**
     * PIS
     * Formato: 11 dígitos
     */
    protected function validarPis($validator, string $campo, string $descricao): void
    {
        $valor = preg_replace('/\D/', '', $this->input($campo));

        if (blank($valor)) {
            return;
        }

        if (!preg_match('/^\d{11}$/', $valor)) {
            $validator->errors()->add($campo, "{$descricao} deve possuir 11 dígitos.");
        }
    }

    /**
     * PASEP
     * Formato: 11 dígitos
     */
    protected function validarPasep($validator, string $campo, string $descricao): void
    {
        $valor = preg_replace('/\D/', '', $this->input($campo));

        if (blank($valor)) {
            return;
        }

        if (!preg_match('/^\d{11}$/', $valor)) {
            $validator->errors()->add($campo, "{$descricao} deve possuir 11 dígitos.");
        }
    }

    /**
     * Carteira de Trabalho
     * Formato: 0000000000
     */
    protected function validarCarteiraTrabalho($validator, string $campo, string $descricao): void
    {
        $valor = preg_replace('/\D/', '', $this->input($campo));

        if (blank($valor)) {
            return;
        }

        if (!preg_match('/^\d{10}$/', $valor)) {
            $validator->errors()->add($campo, "{$descricao} deve possuir 10 dígitos.");
        }
    }

    /**
     * CEP
     * Formato: 8 dígitos
     */
    protected function validarCep($validator, string $campo, string $descricao): void
    {
        $valor = preg_replace('/\D/', '', $this->input($campo));

        if (blank($valor)) {
            return;
        }

        if (!preg_match('/^\d{8}$/', $valor)) {
            $validator->errors()->add($campo, "{$descricao} deve possuir 8 dígitos.");
        }
    }

    /**
     * Valida um boletim no formato:
     * 001-31/12/2026
     */
    protected function validarBoletim($validator, string $campo, string $descricao): void
    {
        // Recupera o valor da requisição
        $valor = $this->input($campo);

        // Campo vazio é permitido
        if (blank($valor)) {
            return;
        }

        // Valida o formato: 001-31/12/2026
        if (!preg_match('/^(00[1-9]|0[1-9]\d|[1-9]\d{2})-(\d{2})\/(\d{2})\/(\d{4})$/', $valor, $matches)) {
            $validator->errors()->add($campo, "{$descricao} deve estar no formato 999-dd/mm/aaaa.");

            return;
        }

        $dia = (int) $matches[2];
        $mes = (int) $matches[3];
        $ano = (int) $matches[4];

        // Valida se a data realmente existe
        if (!checkdate($mes, $dia, $ano)) {
            $validator->errors()->add($campo, "Data {$descricao} inválida.");
        }
    }

    /**
     * Valida um RG no formato:
     * 00/0000.000
     */
    protected function validarRg($validator, string $campo, string $descricao): void
    {
        // Recupera o valor da requisição
        $valor = $this->input($campo);

        // Campo vazio é permitido
        if (blank($valor)) {
            return;
        }

        // Valida o formato: 00/0000.000
        if (!preg_match('/^\d{2}\/\d{4}\.\d{3}$/', $valor)) {
            $validator->errors()->add($campo, "{$descricao} deve estar no formato 00/0000.000.");
        }
    }
    
    /**
     * Valida um pagamento no formato:
     * mm/aaaa
     */
    protected function validarPagamento($validator, string $campo, string $descricao): void
    {
        // Recupera o valor da requisição
        $valor = $this->input($campo);

        // Campo vazio é permitido
        if (blank($valor)) {
            return;
        }

        // Valida o formato: mm/aaaa
        if (!preg_match('/^(0[1-9]|1[0-2])\/(\d{4})$/', $valor, $matches)) {
            $validator->errors()->add($campo, "{$descricao} deve estar no formato mm/aaaa.");

            return;
        }

        $mes = (int) $matches[1];
        $ano = (int) $matches[2];

        // Validação adicional (a regex já garante mês de 1 a 12)
        if (!checkdate($mes, 1, $ano)) {
            $validator->errors()->add($campo, "{$descricao} inválido.");
        }
    }
}
