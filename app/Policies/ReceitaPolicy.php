<?php // Início do arquivo PHP

namespace App\Policies; // Namespace para organização das policies

use App\Models\Receita; // Importa o model Receita
use App\Models\User;    // Importa o model User
use Illuminate\Auth\Access\HandlesAuthorization; // Importa trait para autorização

class ReceitaPolicy // Define a classe de Policy (autorização) para o model Receita
{
    use HandlesAuthorization; // Trait que oferece métodos auxiliares de autorização

    /**
     * Determina se o usuário pode visualizar qualquer receita.
     */
    public function viewAny(User $user) // Recebe o usuário autenticado
    {
        // Retorna true para permitir acesso à listagem geral
        return true;
    }

    /**
     * Determina se o usuário pode visualizar uma receita específica.
     */
    public function view(User $user, Receita $receita) // Recebe usuário e receita
    {
        // Só permite se a receita pertence ao usuário
        return $user->id === $receita->user_id;
    }

    /**
     * Determina se o usuário pode criar uma nova receita.
     */
    public function create(User $user)
    {
        // Retorna true para permitir criação de receitas a qualquer usuário autenticado
        return true;
    }

    /**
     * Determina se o usuário pode atualizar uma receita específica.
     */
    public function update(User $user, Receita $receita)
    {
        // Só permite se a receita pertence ao usuário
        return $user->id === $receita->user_id;
    }

    /**
     * Determina se o usuário pode deletar uma receita específica.
     */
    public function delete(User $user, Receita $receita)
    {
        // Só permite se a receita pertence ao usuário
        return $user->id === $receita->user_id;
    }

    /**
     * Determina se o usuário pode restaurar uma receita (caso use soft deletes).
     */
    public function restore(User $user, Receita $receita)
    {
        // Só permite se a receita pertence ao usuário
        return $user->id === $receita->user_id;
    }

    /**
     * Determina se o usuário pode excluir permanentemente uma receita.
     */
    public function forceDelete(User $user, Receita $receita)
    {
        // Só permite se a receita pertence ao usuário
        return $user->id === $receita->user_id;
    }
}
