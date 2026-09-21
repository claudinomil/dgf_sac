<?php

namespace App\Domain\User;

use App\Domain\Lock\LockService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function __construct(
        private UserRepository $repository,
        private LockService $lockService
    ) {}

    public function getUsers($limit=null)
    {
        return $this->repository->index($limit);
    }

    public function getUsersFilter($array_dados, $limit=null)
    {
        return $this->repository->filter($array_dados, $limit);
    }

    public function getUser($id)
    {
        return $this->repository->find($id);
    }

    public function createUser(array $data)
    {
        $data['avatar'] = 'assets/images/users/avatar-0.png';

        // Gerar Password
        $password = Str::password(10, true, true, false, false);
        $data['password'] = Hash::make($password);

        // Enviar $password (Disfarçada) para Client enviar E-mail do Primeiro Acesso
        $password = 'G@998kLa2@-'.$password.'-_3ldfg3@yK';

        return $this->repository->create($data);
    }

    public function editUser($id)
    {
        $this->lockService->bloquear('users', $id, Auth::user()->id);

        return $this->repository->find($id);
    }

    public function updateUser($id, array $data)
    {
        $user_id = Auth::user()->id;

        try {
            // valida lock
            $this->lockService->validar('users', $id, $user_id);

            // update
            $this->repository->update($id, $data);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('users', $id, $user_id);
        }
    }

    public function deleteUser(int $id)
    {
        $user_id = Auth::user()->id;

        try {
            // Bloquear
            $this->lockService->bloquear('users', $id, $user_id);

            // Valida Lock
            $this->lockService->validar('users', $id, $user_id);

            // Busca o registro
            $user = $this->repository->find($id);

            if (!$user) {
                throw new \Exception('Registro não encontrado.');
            }

            // Delete
            $this->repository->delete($id);

            return true;
        } finally {
            // libera o lock
            $this->lockService->desbloquear('users', $id, $user_id);
        }
    }

    public function updateAvatar($user_id, $request)
    {
        if ($request->hasFile('profille_avatar')) {
            $file = $request->file('profille_avatar');
            $ext = $file->getClientOriginalExtension();
            $fileName = 'avatar-' . $user_id . '.' . $ext;
            $destination = public_path('/assets/images/users');
            $file->move($destination, $fileName);
            $data['avatar'] = 'assets/images/users/' . $fileName;

            $this->repository->update($user_id, $data);
        }
    }

    public function updatePassword($user_id, $currentPassword, $newPassword)
    {
        $user = $this->repository->find($user_id);

        if (!Hash::check($currentPassword, $user->password)) {
            return false;
        }

        $this->repository->update($user_id, [
            'password' => Hash::make($newPassword)
        ]);

        return true;
    }

    public function getTotais($op)
    {
        // Total Geral
        if ($op == 1) {
            return $this->repository->totais($op);
        }

        // Total Liberados
        if ($op == 2) {
            return $this->repository->totais($op);
        }

        // Total Bloqueados
        if ($op == 3) {
            return $this->repository->totais($op);
        }

        // Total Militares
        if ($op == 4) {
            return $this->repository->totais($op);
        }

        // Total Civis
        if ($op == 5) {
            return $this->repository->totais($op);
        }
    }
}
