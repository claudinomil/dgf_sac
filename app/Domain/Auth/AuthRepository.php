<?php

namespace App\Domain\Auth;

use App\Models\User;

class AuthRepository
{
    public function findByUser($user)
    {
        return User::where('user', $user)
            ->first();
    }

    public function findByEmail($email)
    {
        return User::where('email', $email)
            ->first();
    }

    public function updatePassword($user_id, $password)
    {
        return User::where('id', $user_id)
            ->update(['password' => bcrypt($password)]);
    }
}
