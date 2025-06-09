<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Controller responsável por permitir a alteração da senha enquanto o usuário está logado.
 */
class PasswordController extends Controller
{
    /**
     * Exibe o formulário para alteração de senha do usuário autenticado.
     */
    public function edit(Request $request)
    {
        // Retorna a view de alteração de senha.
        return view('auth.passwords.edit');
    }

    /**
     * Atualiza a senha do usuário após validação.
     */
    public function update(Request $request)
    {
        // Valida a senha atual, nova senha e confirmação.
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Verifica se a senha atual está correta.
        if (!Hash::check($request->current_password, $request->user()->password)) {
            return back()->withErrors(['current_password' => 'A senha atual não confere.']);
        }

        // Atualiza a senha.
        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        // Redireciona com mensagem de sucesso.
        return back()->with('status', 'Senha atualizada com sucesso!');
    }
}
