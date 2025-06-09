<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Controller responsável por gerenciar o perfil do usuário autenticado.
 * Permite visualizar, atualizar dados e alterar senha do usuário.
 */
class ProfileController extends Controller
{
    /**
     * Exibe o perfil do usuário autenticado.
     */
    public function show()
    {
        // Recupera o usuário atualmente autenticado.
        $user = Auth::user();

        // Retorna a view de perfil com os dados do usuário.
        return view('profile.show', compact('user'));
    }

    /**
     * Exibe o formulário para editar os dados do perfil.
     */
    public function edit()
    {
        // Recupera o usuário autenticado.
        $user = Auth::user();

        // Retorna a view de edição de perfil.
        return view('profile.edit', compact('user'));
    }

    /**
     * Atualiza os dados do perfil do usuário após validação.
     */
    public function update(Request $request)
    {
        // Recupera o usuário autenticado.
        $user = Auth::user();

        // Validação dos dados do formulário de perfil.
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ], [
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome não pode passar de 255 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.max' => 'O e-mail não pode passar de 255 caracteres.',
            'email.unique' => 'Este e-mail já está em uso por outro usuário.',
        ]);

        // Atualiza os dados do usuário.
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Redireciona de volta para o perfil com mensagem de sucesso.
        return redirect()->route('profile.show')->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Exibe o formulário para alterar a senha do usuário.
     */
    public function editPassword()
    {
        // Retorna apenas a view de alteração de senha.
        return view('profile.edit-password');
    }

    /**
     * Atualiza a senha do usuário, validando a senha atual e a nova.
     */
    public function updatePassword(Request $request)
    {
        // Recupera o usuário autenticado.
        $user = Auth::user();

        // Validação das senhas (atual e nova).
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Informe a senha atual.',
            'password.required' => 'Informe a nova senha.',
            'password.min' => 'A nova senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da nova senha não confere.',
        ]);

        // Verifica se a senha atual está correta.
        if (!Hash::check($request->current_password, $user->password)) {
            // Retorna com erro caso a senha esteja incorreta.
            return back()->withErrors(['current_password' => 'A senha atual não confere.']);
        }

        // Atualiza a senha do usuário.
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Redireciona com mensagem de sucesso.
        return redirect()->route('profile.show')->with('success', 'Senha alterada com sucesso!');
    }
}
