<?php

namespace App\Policies;

use App\Models\Conta;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContaPolicy
{
    use HandlesAuthorization;

    /**
     * Permite que qualquer usuário autenticado veja todas as contas dele.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Permite ver apenas contas do próprio usuário.
     */
    public function view(User $user, Conta $conta)
    {
        return $user->id === $conta->user_id;
    }

    /**
     * Permite que qualquer usuário autenticado crie contas.
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Permite atualizar apenas contas do próprio usuário.
     */
    public function update(User $user, Conta $conta)
    {
        return $user->id === $conta->user_id;
    }

    /**
     * Permite deletar apenas contas do próprio usuário.
     */
    public function delete(User $user, Conta $conta)
    {
        return $user->id === $conta->user_id;
    }

    /**
     * Permite restaurar apenas contas do próprio usuário.
     */
    public function restore(User $user, Conta $conta)
    {
        return $user->id === $conta->user_id;
    }

    /**
     * Permite excluir permanentemente apenas contas do próprio usuário.
     */
    public function forceDelete(User $user, Conta $conta)
    {
        return $user->id === $conta->user_id;
    }
}
