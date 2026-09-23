<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Domain\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Domain\UserContext\UserContextService;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService,
        private UserContextService $userContextService
    ) {}

    public function loginForm()
    {
        if (Auth::check()) {
            return redirect('/dashboards');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user = $this->authService->login(
            $request->user,
            $request->password
        );

        if (!$user) {
            return back()->with('error', 'Usuário ou senha inválidos');
        }

        Auth::login($user);

        $this->userContextService->refresh();

        return redirect('/dashboards');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/dgf_sistema');
    }

    public function forgot_password_request()
    {
        return view('auth.passwords.user');
    }

    public function forgot_password_send(Request $request)
    {
        $request->validate([
            'user' => 'required'
        ]);

        $status = $this->authService->sendResetByUser($request->user);

        if ($status == 'USER_NOT_FOUND') {
            return back()->with('error', 'Usuário não encontrado');
        }

        return back()->with('success', 'Email de recuperação enviado');
    }

    public function forgot_password_reset_form($token)
    {
        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => request('email')
        ]);
    }

    public function forgot_password_reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        $status = $this->authService->resetPassword(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            )
        );

        if ($status == Password::PASSWORD_RESET) {
            return redirect('/login')
                ->with('success', 'Senha redefinida');
        }

        return back()->with('error', 'Erro ao redefinir senha');
    }
}
