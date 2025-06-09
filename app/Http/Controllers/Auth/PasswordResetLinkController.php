<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

/**
 * Controller responsável por enviar o link de redefinição de senha para o e-mail do usuário.
 */
class PasswordResetLinkController extends Controller
{
    /**
     * Exibe o formulário para solicitar o link de redefinição de senha.
     */
    public function create()
    {
        // Retorna a view de solicitação de redefinição de senha.
        return view('auth.forgot-password');
    }

    /**
     * Envia o link de redefinição de senha para o e-mail informado.
     */
    public function store(Request $request)
    {
        // Valida o campo de e-mail.
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Tenta enviar o link de redefinição de senha.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Retorna mensagem apropriada dependendo do status.
        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
