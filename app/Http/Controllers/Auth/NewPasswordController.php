<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

/**
 * Controller responsável por definir uma nova senha durante o processo de recuperação de senha.
 */
class NewPasswordController extends Controller
{
    /**
     * Exibe o formulário para criar uma nova senha usando o token recebido por e-mail.
     */
    public function create(Request $request)
    {
        // Retorna a view de redefinição de senha com o token e e-mail.
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Processa a redefinição da senha, validando token, e-mail e nova senha.
     */
    public function store(Request $request)
    {
        // Valida os campos obrigatórios.
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Tenta redefinir a senha do usuário.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Atualiza a senha criptografada.
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        // Redireciona para login com mensagem se sucesso, ou retorna erro.
        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
