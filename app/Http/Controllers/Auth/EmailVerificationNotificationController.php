<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Controller responsável por enviar o e-mail de verificação para o usuário.
 */
class EmailVerificationNotificationController extends Controller
{
    /**
     * Envia um novo e-mail de verificação para o usuário autenticado.
     */
    public function store(Request $request)
    {
        // Se o usuário já confirmou o e-mail, não precisa reenviar.
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'));
        }

        // Envia a notificação de verificação de e-mail.
        $request->user()->sendEmailVerificationNotification();

        // Retorna para a tela anterior com mensagem de sucesso.
        return back()->with('status', 'Link de verificação enviado para seu e-mail!');
    }
}
