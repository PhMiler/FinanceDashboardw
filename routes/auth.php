<?php

// Importação dos controllers de autenticação
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// Rotas acessíveis apenas para visitantes (usuários NÃO autenticados)
Route::middleware('guest')->group(function () {
    // Formulário de cadastro
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    // Envio do formulário de cadastro
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Formulário de login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    // Envio do formulário de login
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Formulário de solicitação de redefinição de senha
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    // Envio do formulário de redefinição de senha (envia e-mail)
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    // Formulário para definir uma nova senha via token recebido por e-mail
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    // Envio do formulário de nova senha
    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

// Rotas acessíveis apenas para usuários AUTENTICADOS
Route::middleware('auth')->group(function () {
    // Tela solicitando verificação de e-mail
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    // Link de verificação de e-mail enviado por e-mail
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    // Envia novo e-mail de verificação
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    // Formulário de confirmação de senha antes de ações sensíveis
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    // Envio do formulário de confirmação de senha
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Atualização da senha do usuário autenticado
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Logout (encerra a sessão do usuário)
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
