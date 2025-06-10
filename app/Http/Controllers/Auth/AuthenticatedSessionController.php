<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Controller responsável pelo gerenciamento da sessão de autenticação do usuário (login e logout).
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * Exibe o formulário de login.
     */
    public function create()
    {
        // Retorna a view de login para o usuário.
        return view('auth.login');
    }

    /**
     * Processa a tentativa de login do usuário.
     * Valida as credenciais e autentica o usuário.
     */
    public function store(Request $request)
    {
        // Valida as credenciais informadas no formulário.
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tenta autenticar o usuário usando as credenciais.
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            // Retorna erro de validação caso falhe.
            throw ValidationException::withMessages([
                'email' => __('As credenciais informadas não conferem.'),
            ]);
        }

        // Regenera a sessão para evitar fixation.
        $request->session()->regenerate();

        // Redireciona para a página pretendida após login.
        return redirect()->intended(route('home'));
    }

    /**
     * Efetua o logout do usuário e invalida a sessão.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        // Invalida a sessão e regenera o token CSRF.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redireciona para a página inicial ou de login.
        return redirect('/');
    }
}
