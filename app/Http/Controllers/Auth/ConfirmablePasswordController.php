<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller responsável por solicitar a confirmação da senha do usuário antes de permitir ações sensíveis.
 * Exemplo: alteração de dados críticos, exclusão de conta, etc.
 */
class ConfirmablePasswordController extends Controller
{
    /**
     * Exibe o formulário para o usuário confirmar sua senha atual.
     */
    public function show()
    {
        // Retorna a view de confirmação de senha.
        return view('auth.confirm-password');
    }

    /**
     * Processa a confirmação da senha.
     */
    public function store(Request $request)
    {
        // Verifica se a senha informada está correta.
        if (!Auth::validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            // Retorna erro caso a senha esteja incorreta.
            return back()->withErrors([
                'password' => __('A senha informada está incorreta.'),
            ]);
        }

        // Armazena o momento da confirmação na sessão.
        $request->session()->put('auth.password_confirmed_at', time());

        // Redireciona para a rota pretendida após confirmação.
        return redirect()->intended();
    }
}
