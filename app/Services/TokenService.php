<?php

namespace App\Services;

class TokenService
{
    private static function secret(): string
    {
        return config('app.token_service');
    }

    // Gera token genérico com escopo + id
    public static function gerar(string $scope, int|string $id, int $minutos = 10): string
    {
        $dados = ['scope' => $scope, 'id' => $id, 'exp' => time() + ($minutos * 60)];

        $json = json_encode($dados);

        $iv = random_bytes(16);

        $cipher = openssl_encrypt($json, 'AES-256-CBC', self::secret(), OPENSSL_RAW_DATA, $iv);

        $hmac = hash_hmac('sha256', $iv.$cipher, self::secret(), true);

        return rtrim(strtr(base64_encode($iv . $hmac . $cipher), '+/', '-_'), '=');
    }

    // Valida token e retorna payload decodificado
    public static function validar(string $token): array|false
    {
        $dados = base64_decode(strtr($token, '-_', '+/'));

        if ($dados === false) {
            return false;
        }

        $iv     = substr($dados, 0, 16);
        $hmac   = substr($dados, 16, 32);
        $cipher = substr($dados, 48);

        $hmacCalculado = hash_hmac('sha256', $iv.$cipher, self::secret(), true);

        if (!hash_equals($hmac, $hmacCalculado)) {
            return false;
        }

        $json = openssl_decrypt($cipher, 'AES-256-CBC', self::secret(), OPENSSL_RAW_DATA, $iv);

        if ($json === false) {
            return false;
        }

        $dados = json_decode($json, true);

        if (!is_array($dados)) {
            return false;
        }

        if (($dados['exp'] ?? 0) < time()) {
            return false;
        }

        return $dados;
    }

    // Helper opcional: extrair ID já validado
    public static function id(string $token): int|string|false
    {
        $dados = self::validar($token);

        return $dados['id'] ?? false;
    }

    // Helper opcional: extrair scope
    public static function scope(string $token): string|false
    {
        $dados = self::validar($token);

        return $dados['scope'] ?? false;
    }
}
