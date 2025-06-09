<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

/**
 * Controller responsável por exibir o prompt (aviso) de verificação de e-mail para o usuário.
 */
class EmailVerificationPromptController extends Controller
{
    /**
     * Exibe a tela solicitando a verificação do e-mail.
     */
    public function __invoke()
    {
        // Retorna a view que pede a verificação de e-mail.
        return view('auth.verify-email');
    }
}
