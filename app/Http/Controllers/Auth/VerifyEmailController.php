<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/**
 * Controller responsável por processar a verificação de e-mail do usuário.
 */
class VerifyEmailController extends Controller
{
    /**
     * Processa a verificação do e-mail a partir do link enviado para o usuário.
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        // Se o e-mail já está verificado, redireciona para o dashboard.
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'));
        }

        // Marca o e-mail como verificado e dispara o evento.
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // Redireciona para o dashboard com mensagem de sucesso.
        return redirect()->intended(route('dashboard'))->with('verified', true);
    }
}
