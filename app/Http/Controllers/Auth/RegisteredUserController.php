<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Controller responsável pelo cadastro (registro) de novos usuários.
 */
class RegisteredUserController extends Controller
{
    /**
     * Exibe o formulário de cadastro de usuário.
     */
    public function create()
    {
        // Retorna a view de cadastro.
        return view('auth.register');
    }

    /**
     * Processa o registro de um novo usuário.
     */
    public function store(Request $request)
    {
        // Valida os dados do formulário de cadastro.
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Cria o usuário no banco de dados.
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Dispara o evento de novo cadastro (útil para verificação de e-mail, etc).
        event(new Registered($user));

        // Realiza o login automático do novo usuário.
        Auth::login($user);

        // Redireciona para o dashboard ou página inicial.
        return redirect(route('dashboard'));
    }
}
