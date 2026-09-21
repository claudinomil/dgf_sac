<?php

namespace App\Domain\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthService
{
    public function __construct(
        private AuthRepository $authRepository
    ) {}

    public function login($user, $password)
    {

        $user = $this->authRepository->findByUser($user);

        if(!$user){
            return null;
        }

        if(!Hash::check($password,$user->password)){
            return null;
        }

        return $user;

    }

    public function sendResetByUser($user)
    {
        $usuario = $this->authRepository->findByUser($user);

        if(!$usuario){
            return 'USER_NOT_FOUND';
        }

        return Password::sendResetLink([
            'email' => $usuario->email
        ]);
    }

    public function resetPassword($data)
    {
        return Password::reset(
            $data,
            function ($user,$password){

                $user->password = bcrypt($password);
                $user->save();
            }
        );
    }

    public function forgotPassword(string $user)
    {
        $user = $this->authRepository->findByUser($user);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Usuário não encontrado'
            ];
        }

        $status = Password::sendResetLink([
            'email' => $user->email
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            return [
                'success' => true,
                'message' => 'Link de recuperação enviado'
            ];
        }

        return [
            'success' => false,
            'message' => 'Erro ao enviar link'
        ];
    }
}
